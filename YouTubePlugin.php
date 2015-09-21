<?php

namespace Craft;

/**
 * YouTube Plugin.
 *
 * Upload video assets to YouTube.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 */
class YouTubePlugin extends BasePlugin
{
    /**
     * Get plugin name.
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('YouTube Upload');
    }

    /**
     * Get plugin version.
     *
     * @return string
     */
    public function getVersion()
    {
        return '0.4.1';
    }

    /**
     * Get plugin developer.
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'Bob Olde Hampsink';
    }

    /**
     * Get plugin developer url.
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://github.com/boboldehampsink';
    }

    /**
     * Define plugin settings.
     *
     * @return array
     */
    public function defineSettings()
    {
        return array(
            'tokenId' => AttributeType::Number,
        );
    }

    /**
     * Get settings html.
     *
     * @return string
     */
    public function getSettingsHtml()
    {
        // Set default options
        $options = array(
            'gateway' => 'google',
            'provider' => false,
            'account' => false,
            'token' => false,
            'error' => false,
        );

        // Get provider
        $provider = craft()->oauth->getProvider('google', false);
        if ($provider) {
            if ($provider->isConfigured()) {

                // Get token
                $token = craft()->youTube_oauth->getToken();
                if ($token) {
                    $provider->setToken($token);

                    // Get account
                    try {
                        $account = $provider->getAccount();

                        if ($account) {
                            $options['account'] = $account;
                            $options['settings'] = $this->getSettings();
                        }
                    } catch (\Exception $e) {
                        $options['error'] = $e->getMessage();
                    }
                }
                $options['token'] = $token;
            }
            $options['provider'] = $provider;
        }

        return craft()->templates->render('youtube/settings/_plugin', $options);
    }

    /**
     * Remove tokens on uninstall.
     */
    public function onBeforeUninstall()
    {
        if (isset(craft()->oauth)) {
            craft()->oauth->deleteTokensByPlugin('youtube');
        }
    }

    /**
     * Initialize plugin.
     */
    public function init()
    {
        // Initialize parent
        parent::init();

        // Autoload dependencies
        require_once dirname(__FILE__).'/vendor/autoload.php';
    }
}
