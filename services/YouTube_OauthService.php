<?php

namespace Craft;

/**
 * YouTube OAuth Service.
 *
 * Handles OAuth logics
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 */
class YouTube_OauthService extends BaseApplicationComponent
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
     * Initialize service.
     *
     * @codeCoverageIgnore
     */
    public function init()
    {
        // Get plugin
        $this->plugin = craft()->plugins->getPlugin('youtube');

        // Get plugin settings
        $this->settings = $this->plugin->getSettings();
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

        // Return token
        return craft()->oauth->getTokenById($tokenId);
    }

    /**
     * Delete OAuth token.
     */
    public function deleteToken()
    {
        // Get token
        $token = $this->getToken();

        // Delete token
        if ($token) {
            craft()->oauth->deleteToken($token);
        }

        // Save plugin settings
        return craft()->plugins->savePluginSettings($this->plugin, array('tokenId' => null));
    }

    /**
     * Save OAuth Token.
     */
    public function saveToken($token)
    {
        // Get existing token
        $existingToken = $this->getToken();

        // Do we have a valid token?
        // @codeCoverageIgnoreStart
        if (!$token) {
            $token = new Oauth_TokenModel();
        }
        // @codeCoverageIgnoreEnd

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
        return craft()->plugins->savePluginSettings($this->plugin, array('tokenId' => $token->id));
    }
}
