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
     * Get OAuth token.
     *
     * @return OAuth_TokenModel
     */
    public function getToken()
    {
        // Get tokenId
        $tokenId = craft()->youTube->settings->tokenId;

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
        // Get token
        $token = $this->getToken();

        // Delete token
        if ($token) {
            craft()->oauth->deleteToken($token);
        }

        // Save plugin settings
        craft()->plugins->savePluginSettings(craft()->youTube->plugin, array('tokenId' => null));
    }

    /**
     * Save OAuth Token.
     */
    public function saveToken($token)
    {
        // Get existing token
        $existingToken = $this->getToken();

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
        craft()->plugins->savePluginSettings(craft()->youTube->plugin, array('tokenId' => $token->id));
    }
}
