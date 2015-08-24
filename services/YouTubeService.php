<?php

namespace Craft;

/**
 * YouTube Upload Task.
 *
 * Upload video assets to YouTube.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   http://buildwithcraft.com/license Craft License Agreement
 *
 * @link      http://github.com/boboldehampsink
 */
class YouTubeService extends BaseApplicationComponent
{
    /**
     * Holds a reference to the plugin class.
     *
     * @var YouTubePlugin
     */
    protected $plugin;

    /**
     * Holds the plugin settings.
     *
     * @var array
     */
    protected $settings;

    /**
     * Holds the OAuth client.
     *
     * @var \Google_Client|null
     */
    protected $client;

    /**
     * Holds the YouTube API.
     *
     * @var \Google_Service_YouTube|null
     */
    protected $youtube;

    /**
     * Initialize plugin.
     */
    public function init()
    {
        // Initialize parent
        parent::init();

        // Autoload dependencies
        require_once dirname(__FILE__).'/../vendor/autoload.php';

        // Get plugin
        $this->plugin = craft()->plugins->getPlugin('youtube');

        // Get plugin settings
        $this->settings = $this->plugin->getSettings();
    }

    /**
     * Upload and process the result.
     *
     * @param BaseElementModel $element
     * @param AssetFileModel   $asset
     * @param string           $handle
     * @param int              $step
     *
     * @return bool
     */
    public function process(BaseElementModel $element, AssetFileModel $asset, $handle, $step)
    {
        // Get max power
        craft()->config->maxPowerCaptain();

        // Upload to YouTube
        try {
            $status = $this->assemble($element, $asset);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        // Add video to (existing) content
        $content = $element->getAttribute($handle);
        $element->getContent()->$handle = array_merge((is_array($content) ? $content : array()), array($status->id));

        // Save the content without validation
        craft()->content->saveContent($element, false);

        // All went well
        return true;
    }

    /**
     * Send video's to YouTube.
     *
     * @param BaseElementModel $element
     * @param AssetFileModel   $assetId
     *
     * @return bool
     *
     * @throws Exception
     */
    protected function assemble(BaseElementModel $element, AssetFileModel $asset)
    {
        // Autenticate first
        $this->authenticate();

        try {
            // Create YouTube Video snippet
            $snippet = $this->createVideoSnippet($asset);

            // Set the YouTube Video's status
            $status = $this->setVideoStatus();

            // Create a new video resource
            $video = $this->createVideoResource($snippet, $status);

            // Now upload the resource
            return $this->uploadVideo($asset, $video);

            // Or catch exceptions if we fail
        } catch (\Google_Service_Exception $e) {

            // Rethrow service error
            throw new Exception(Craft::t('A service error occurred: {error}', array('error' => $e->getMessage())));
        } catch (\Google_Exception $e) {

            // Rethrow client error
            throw new Exception(Craft::t('A client error occurred: {error}', array('error' => $e->getMessage())));
        }
    }

    /**
     * Get OAuth token.
     *
     * @return OAuth_TokenModel
     */
    public function getToken()
    {
        // Get tokenId
        $tokenId = $this->settings->tokenId;

        // Get token
        $token = craft()->oauth->getTokenById($tokenId);
        if ($token) {
            return $token;
        }
    }

    /**
     * Delete OAuth token.
     */
    public function deleteToken()
    {
        // Get tokenId
        $tokenId = $this->settings->tokenId;

        // Get token
        $token = craft()->oauth->getTokenById($tokenId);

        // Delete token
        if ($token) {
            craft()->oauth->deleteToken($token);
        }

        // Save plugin settings
        craft()->plugins->savePluginSettings($this->plugin, array('tokenId' => null));
    }

    /**
     * Save OAuth Token.
     */
    public function saveToken($token)
    {
        // Get tokenId
        $tokenId = $this->settings->tokenId;

        // Get existing token
        $existingToken = craft()->oauth->getTokenById($tokenId);

        // Do we have a valid token?
        if (!$token) {
            $token = new Oauth_TokenModel();
        }

        // Do we have a valid existing token
        if (isset($existingToken)) {
            $token->id = $existingToken->id;
        }

        // Set provider and handle
        $token->providerHandle = 'google';
        $token->pluginHandle = 'youtube';

        // Save token
        craft()->oauth->saveToken($token);

        // Save plugin settings
        craft()->plugins->savePluginSettings($this->plugin, array('tokenId' => $token->id));
    }

    /**
     * Authenticate with YouTube.
     *
     * @throws Exception
     */
    protected function authenticate()
    {
        // Get token by id
        $token = craft()->oauth->getTokenById($this->settings->tokenId);

        // Make token compatible with Google API
        $json = JsonHelper::encode(array(
            'access_token'  => $token->accessToken,
            'refresh_token' => $token->refreshToken,
            'expires_in'    => $token->endOfLife,
            'created'       => time(),
        ));

        // Set up a Google Client
        $this->client = new \Google_Client();
        $this->client->setAccessToken($json);

        // Define an object that will be used to make all API requests.
        $this->youtube = new \Google_Service_YouTube($this->client);
    }

    /**
     * Create a snippet with title, description, tags and category ID
     * Create an asset resource and set its snippet metadata and type.
     *
     * @param AssetFileModel $asset
     *
     * @return \Google_Service_YouTube_VideoSnippet
     */
    protected function createVideoSnippet(AssetFileModel $asset)
    {
        $snippet = new \Google_Service_YouTube_VideoSnippet();
        $snippet->setTitle((string) $asset);

        return $snippet;
    }

    /**
     * Set the video's status to "public". Valid statuses are "public",
     * "private" and "unlisted".
     *
     * @return \Google_Service_YouTube_VideoStatus
     */
    protected function setVideoStatus()
    {
        $status = new \Google_Service_YouTube_VideoStatus();
        $status->privacyStatus = 'unlisted';

        return $status;
    }

    /**
     * Associate the snippet and status objects with a new video resource.
     *
     * @param \Google_Service_YouTube_VideoSnippet $snippet
     * @param \Google_Service_YouTube_VideoStatus  $status
     *
     * @return \Google_Service_YouTube_Video
     */
    protected function createVideoResource(\Google_Service_YouTube_VideoSnippet $snippet, \Google_Service_YouTube_VideoStatus $status)
    {
        $video = new \Google_Service_YouTube_Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);

        return $video;
    }

    /**
     * Create a resumable video upload to YouTube.
     *
     * @param AssetFileModel                $asset
     * @param \Google_Service_YouTube_Video $video
     */
    protected function uploadVideo(AssetFileModel $asset, \Google_Service_YouTube_Video $video)
    {
        // Get file by asset
        $file = $this->getAssetFile($asset);

        // Specify the size of each chunk of data, in bytes. Set a higher value for
        // reliable connection as fewer chunks lead to faster uploads. Set a lower
        // value for better recovery on less reliable connections.
        $chunkSizeBytes = 1 * 1024 * 1024;

        // Setting the defer flag to true tells the client to return a request which can be called
        // with ->execute(); instead of making the API call immediately.
        $this->client->setDefer(true);

        // Create a request for the API's videos.insert method to create and upload the video.
        $insertRequest = $this->youtube->videos->insert('status,snippet', $video);

        // Create a MediaFileUpload object for resumable uploads.
        $media = new \Google_Http_MediaFileUpload($this->client, $insertRequest, 'video/*', null, true, $chunkSizeBytes);
        $media->setFileSize(IOHelper::getFileSize($file));

        // Read the media file and upload it chunk by chunk.
        $status = false;
        $handle = fopen($file, 'rb');
        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }
        fclose($handle);

        // If you want to make other calls after the file upload, set setDefer back to false
        $this->client->setDefer(false);

        // Remove the local asset file
        IOHelper::deleteFile($file);

        // Return the status
        return $status;
    }

    /**
     * Gets a file by its asset.
     *
     * @param AssetFileModel $assetId
     *
     * @return string
     */
    protected function getAssetFile(AssetFileModel $asset)
    {
        // Get asset source
        $source = $asset->getSource();

        // Get asset source type
        $sourceType = $source->getSourceType();

        // Get asset file and return
        return $sourceType->getLocalCopy($asset);
    }
}
