<?php

namespace Craft;

/**
 * YouTube OAuth Service Test.
 *
 * Asserts for the YouTube_OauthService class
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 *
 * @coversDefaultClass Craft\YouTube_OauthService
 * @covers ::<!public>
 */
class YouTube_Oauth_ServiceTest extends BaseTest
{
    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        require_once __DIR__.'/../vendor/autoload.php';
        require_once __DIR__.'/../YouTubePlugin.php';
        require_once __DIR__.'/../services/YouTubeService.php';
        require_once __DIR__.'/../services/YouTube_OauthService.php';
        require_once __DIR__.'/../models/YouTube_VideoModel.php';
        require_once __DIR__.'/../records/YouTube_HashesRecord.php';
        require_once __DIR__.'/../../oauth/services/OauthService.php';
        require_once __DIR__.'/../../oauth/records/Oauth_ProviderInfosRecord.php';
        require_once __DIR__.'/../../oauth/models/Oauth_ProviderInfosModel.php';
        require_once __DIR__.'/../../oauth/records/Oauth_TokenRecord.php';
        require_once __DIR__.'/../../oauth/models/Oauth_TokenModel.php';
    }

    /**
     * Test getting of token
     *
     * @covers ::getToken
     */
    final public function testGetToken()
    {
        $this->setMockPluginsService();
        $this->setMockOAuthService();

        // Get token from service
        $service = new YouTube_OauthService();
        $service->init();
        $token = $service->getToken();

        $this->assertInstanceOf('Craft\Oauth_TokenModel', $token);
    }

    /**
     * Test deleting of token
     *
     * @covers ::deleteToken
     */
    final public function testDeleteToken()
    {
        $this->setMockPluginsService();
        $this->setMockOAuthService();

        // Initialise service
        $service = new YouTube_OauthService();
        $service->init();

        // Delete token
        $result = $service->deleteToken();

        $this->assertTrue($result);
    }

    /**
     * Test saving of token
     *
     * @covers ::saveToken
     */
    final public function testSaveToken()
    {
        $this->setMockPluginsService();
        $this->setMockOAuthService();

        // Initialise service
        $service = new YouTube_OauthService();
        $service->init();

        // Get token mock
        $token = $this->getMockOAuthTokenModel();

        // Save token
        $result = $service->saveToken($token);

        $this->assertTrue($result);
    }

    /**
     * Mock OAuth Service.
     *
     * @return OauthService|\PHPUnit_Framework_MockObject_MockObject
     */
    private function setMockOauthService()
    {
        $mock = $this->getMockBuilder('Craft\OauthService')
            ->disableOriginalConstructor()
            ->getMock();

        $token = $this->getMockOauthTokenModel();

        $mock->expects($this->any())->method('getTokenById')->willReturn($token);
        $mock->expects($this->any())->method('deleteToken')->willReturn(true);

        $this->setComponent(craft(), 'oauth', $mock);
    }

    /**
     * Mock OAuth Token Model.
     *
     * @return OAuth_TokenModel
     */
    private function getMockOAuthTokenModel()
    {
        $mock = new OAuth_TokenModel();
        $mock->accessToken = 'ya29.zQEjMLOfhL4VrrAKNsLFZcV8V1HJIU0cyq8-FciOKITQABdBEjlEwxZjHCyIhxXKV1vX6g';
        $mock->refreshToken = '1/CEY3ISZaEFaQkG-wjtETZYa3s2lwtjJWh5bp4Tm4Xi9IgOrJDtdun6zK6XiATCKT';
        $mock->endOfLife = '1439377156';

        return $mock;
    }

    /**
     * Mock Plugins Service.
     *
     * @return PluginsService|\PHPUnit_Framework_MockObject_MockObject
     */
    private function setMockPluginsService()
    {
        $mock = $this->getMockBuilder('Craft\PluginsService')
            ->disableOriginalConstructor()
            ->getMock();

        $plugin = new YouTubePlugin();

        $mock->expects($this->any())->method('getPlugin')->willReturn($plugin);
        $mock->expects($this->any())->method('savePluginSettings')->willReturn(true);

        $this->setComponent(craft(), 'plugins', $mock);
    }

    /**
     * Mock YouTube Plugin
     *
     * @return YouTubePlugin|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockYouTubePlugin()
    {
        $mock = $this->getMockBuilder('Craft\YouTubePlugin')
            ->disableOriginalConstructor()
            ->getMock();

        $settings = new \stdClass();
        $settings->tokenId = 1;

        $mock->expects($this->any())->method('getSettings')->willReturn($settings);

        return $mock;
    }
}
