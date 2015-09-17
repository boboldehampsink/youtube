<?php

namespace Craft;

/**
 * YouTube Controller.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 */
class YouTubeController extends BaseController
{
    /**
     * Connect.
     */
    public function actionConnect()
    {
        // Get referer
        $referer = craft()->httpSession->get('youtube.referer');

        // If not set, set it
        if (!$referer) {
            $referer = craft()->request->getUrlReferrer();
            craft()->httpSession->add('youtube.referer', $referer);
        }

        // Set YouTube OAuth options
        $options = array(
            'plugin' => 'youtube',
            'provider' => 'google',
            'scopes' => array(
                'https://www.googleapis.com/auth/userinfo.profile',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/youtube',
                'https://www.googleapis.com/auth/youtube.upload',
            ),
            'params' => array(
                'access_type' => 'offline',
                'approval_prompt' => 'force',
            ),
        );

        // Connect
        if ($response = craft()->oauth->connect($options)) {
            if ($response['success']) {

                // Get token
                $token = $response['token'];

                // Save token
                craft()->youTube_oauth->saveToken($token);

                // Session notice
                craft()->userSession->setNotice(Craft::t('Connected.'));
            } else {
                // Session notice
                craft()->userSession->setError(Craft::t($response['errorMsg']));
            }
        } else {
            // session error
            craft()->userSession->setError(Craft::t('Couldn’t connect'));
        }

        // Redirect
        craft()->httpSession->remove('youtube.referer');
        $this->redirect($referer);
    }

    /**
     * Disconnect.
     */
    public function actionDisconnect()
    {
        // Delete token
        craft()->youTube_oauth->deleteToken();

        // Set notice
        craft()->userSession->setNotice(Craft::t('Disconnected.'));

        // Redirect
        $redirect = craft()->request->getUrlReferrer();
        $this->redirect($redirect);
    }
}
