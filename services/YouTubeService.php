<?php

namespace Craft;

/**
 * YouTube Upload Service.
 *
 * Upload video assets to YouTube.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 */
class YouTubeService extends BaseApplicationComponent
{
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
     * Holds asset existence checks.
     *
     * @var array
     */
    protected $exists = array();

    /**
     * Holds cached asset locations.
     *
     * @var array
     */
    protected $assets = array();

    /**
     * Holds cached file hashes.
     *
     * @var array
     */
    protected $hashes = array();

    /**
     * Upload and process the result.
     *
     * @param BaseElementModel $element
     * @param AssetFileModel   $asset
     * @param string           $handle
     *
     * @return bool
     */
    public function process(BaseElementModel $element, AssetFileModel $asset, $handle)
    {
        // Check if we have this asset already
        if (!($youTubeId = $this->exists($asset))) {

            // Upload to YouTube
            try {
                $youTubeId = $this->assemble($asset);
            } catch (Exception $e) {
                // @codeCoverageIgnoreStart
                return $e->getMessage();
                // @codeCoverageIgnoreEnd
            }
        }

        // Clean up asset file
        $this->cleanupAssetFile($asset);

        // Get current video's
        $content = $element->getContent()->getAttribute($handle);

        // Make sure content's an array
        $content = is_array($content) ? $content : array();

        // Remove this asset's id from the content
        unset($content[array_search($asset->id, $content)]);

        // Add video to (existing) content
        $element->getContent()->$handle = array_merge($content, array($youTubeId));

        // Save the content without validation
        craft()->content->saveContent($element, false);

        // All went well
        return true;
    }

    /**
     * Check if this asset file already exists.
     *
     * @param AssetFileModel $asset
     *
     * @return string|bool
     *
     * @codeCoverageIgnore
     */
    protected function exists(AssetFileModel $asset)
    {
        // Check if we have this exist cached already
        if (!isset($this->exists[$asset->id])) {

            // Get asset file hash
            $hash = $this->getAssetFileHash($asset);

            // Look up in db
            $record = YouTube_HashesRecord::model()->findByAttributes(array(
                'hash' => $hash,
            ));

            // Get YouTube ID
            $this->exists[$asset->id] = $record ? $record->youtubeId : false;
        }

        return $this->exists[$asset->id];
    }

    /**
     * Send video's to YouTube.
     *
     * @param AssetFileModel $asset
     *
     * @return string|bool
     *
     * @throws Exception
     */
    protected function assemble(AssetFileModel $asset)
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

            // Now upload the resource and get the status
            $status = $this->uploadVideo($asset, $video);

        // Catch exceptions if we fail and rethrow
        // @codeCoverageIgnoreStart
        } catch (\Google_Service_Exception $e) {
            throw new Exception(Craft::t('A service error occurred: {error}', array('error' => $e->getMessage())));
        } catch (\Google_Exception $e) {
            throw new Exception(Craft::t('A client error occurred: {error}', array('error' => $e->getMessage())));
        } catch (\Exception $e) {
            throw new Exception(Craft::t('An unknown error occured: {error}', array('error' => $e->getMessage())));
        }
        // @codeCoverageIgnoreEnd

        // Validate status
        if ($status instanceof \Google_Service_YouTube_Video) {

            // Save hash
            $this->saveHash($asset, $status->id);

            // Return YouTube ID
            return $status->id;
        }

        // Or die
        // @codeCoverageIgnoreStart
        throw new Exception(Craft::t('Unable to communicate with the YouTube API client'));
        // @codeCoverageIgnoreEnd
    }

    /**
     * Authenticate with YouTube.
     */
    protected function authenticate()
    {
        // Get token
        $token = craft()->youTube_oauth->getToken();

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
     *
     * @throws Exception
     *
     * @return bool|string
     */
    protected function uploadVideo(AssetFileModel $asset, \Google_Service_YouTube_Video $video)
    {
        // Get file by asset
        $file = $this->getAssetFile($asset);

        // Specify the size of each chunk of data, in bytes. Set a higher value for
        // reliable connection as fewer chunks lead to faster uploads. Set a lower
        // value for better recovery on less reliable connections.
        $chunkSizeBytes = 1 * 1024 * 1024;

        // Verify the client
        if ($this->client instanceof \Google_Client) {

            // Setting the defer flag to true tells the client to return a request which can be called
            // with ->execute(); instead of making the API call immediately.
            $this->client->setDefer(true);

            // Create a request for the API's videos.insert method to create and upload the video.
            $insertRequest = $this->youtube->videos->insert('status,snippet', $video);

            // Create a MediaFileUpload object for resumable uploads.
            $media = new \Google_Http_MediaFileUpload($this->client, $insertRequest, 'video/*', null, true, $chunkSizeBytes);
            $media->setFileSize(IOHelper::getFileSize($file));

            // Read the media file and upload it chunk by chunk.
            $status = $this->uploadChunks($file, $media, $chunkSizeBytes);

            // If you want to make other calls after the file upload, set setDefer back to false
            $this->client->setDefer(false);

            // Return the status
            return $status;
        }

        // Or die
        // @codeCoverageIgnoreStart
        throw new Exception(Craft::t('Unable to authenticate the YouTube API client'));
        // @codeCoverageIgnoreEnd
    }

    /**
     * Upload file in chunks.
     *
     * @param string                       $file
     * @param \Google_Http_MediaFileUpload $media
     * @param int                          $chunkSizeBytes
     *
     * @return bool|string
     *
     * @codeCoverageIgnore
     */
    protected function uploadChunks($file, \Google_Http_MediaFileUpload $media, $chunkSizeBytes)
    {
        $status = false;

        // Upload in chunks
        $handle = fopen($file, 'rb');
        while (!$status && !feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }
        fclose($handle);

        // Return YouTube ID or false
        return $status;
    }

    /**
     * Save asset hash.
     *
     * @param AssetFileModel $asset
     * @param string         $youtubeId
     *
     * @codeCoverageIgnore
     */
    protected function saveHash(AssetFileModel $asset, $youtubeId)
    {
        // Check if its new
        if (!$this->exists($asset)) {

            // Get asset file hash
            $hash = $this->getAssetFileHash($asset);

            // Save to db
            $record = new YouTube_HashesRecord();
            $record->youtubeId = $youtubeId;
            $record->hash = $hash;
            $record->save();
        }
    }

    /**
     * Gets a file by its asset.
     *
     * @param AssetFileModel $asset
     *
     * @return string
     */
    protected function getAssetFile(AssetFileModel $asset)
    {
        // Check if we have this filenname cached already
        if (!isset($this->assets[$asset->id])) {

            // Get asset source
            $source = $asset->getSource();

            // Get asset source type
            $sourceType = $source->getSourceType();

            // Get asset file
            $this->assets[$asset->id] = $sourceType->getLocalCopy($asset);
        }

        return $this->assets[$asset->id];
    }

    /**
     * Get file hash.
     *
     * @param AssetFileModel $asset
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    protected function getAssetFileHash(AssetFileModel $asset)
    {
        // Check if we have this hash cached already
        if (!isset($this->hashes[$asset->id])) {

            // Get asset file
            $file = $this->getAssetFile($asset);

            // Calculate md5 hash of file
            $this->hashes[$asset->id] = md5_file($file);
        }

        return $this->hashes[$asset->id];
    }

    /**
     * Clean up temporary asset files.
     *
     * @param AssetFileModel $asset
     */
    protected function cleanupAssetFile(AssetFileModel $asset)
    {
        // Get asset file
        $file = $this->getAssetFile($asset);

        // Remove the local asset file
        IOHelper::deleteFile($file);
    }
}
