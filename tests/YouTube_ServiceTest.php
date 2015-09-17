<?php

namespace Craft;

/**
 * YouTube Service Test.
 *
 * Asserts for the YouTubeService class
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Itmundi
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 *
 * @coversDefaultClass Craft\YouTubeService
 * @covers ::<!public>
 */
class YouTube_ServiceTest extends BaseTest
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
     * Test init of service
     *
     * @covers ::init
     */
    public function testInit()
    {
        // Set up service
        $this->setMockYouTubeService();

        // Expect plugin instance
        $this->assertInstanceOf('Craft\YouTubePlugin', craft()->youTube->plugin);
    }

    /**
     * Test process type hinting.
     *
     * @covers ::process
     */
    public function testProcessTypeHinting()
    {
        // Set up service
        $service = new YouTubeService();

        // Expect exception
        $this->setExpectedException(get_class(new \PHPUnit_Framework_Error('', 0, '', 1)));

        // Test type hinting correctness
        $service->process(new \stdClass(), new \stdClass(), 'handle', 0);
    }

    /**
     * Test process.
     *
     * @covers ::process
     */
    public function testProcess()
    {
        // Set up service
        $this->setMockYouTubeService();

        // Set up model
        $model = $this->getMockAssetFileModel();

        // Process
        $result = craft()->youTube->process($model, $model, 'handle', 0);

        // Assert true
        $this->assertTrue($result);
    }

    /**
     * Mock YouTube Service.
     *
     * @return YouTube|\PHPUnit_Framework_MockObject_MockObject
     */
    private function setMockYouTubeService()
    {
        $this->setMockPluginsService();
        $this->setMockOauthService();
        $this->setMockContentService();
        $this->setMockYouTubeOauthService();

        $mock = $this->getMockBuilder('Craft\YouTubeService')
            ->setMethods(array('exists', 'uploadChunks', 'saveHash', 'getAssetFileHash'))
            ->getMock();

        // Set YouTube ID
        $status = new \Google_Service_YouTube_Video();
        $status->id = '9NiMDN1fxno';

        $mock->expects($this->any())->method('exists')->willReturn(false);
        $mock->expects($this->any())->method('uploadChunks')->willReturn($status);
        $mock->expects($this->any())->method('getAssetFileHash')->willReturn(md5('test.jpg'));

        $this->setComponent(craft(), 'youTube', $mock);
    }

    /**
     * Mock YouTube Oauth Service.
     *
     * @return YouTube|\PHPUnit_Framework_MockObject_MockObject
     */
    private function setMockYouTubeOauthService()
    {
        $service = new YouTube_OauthService();

        $this->setComponent(craft(), 'youTube_oauth', $service);
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

        $this->setComponent(craft(), 'plugins', $mock);
    }

    /**
     * Mock AssetFileModel.
     *
     * @return AssetFileModel|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockAssetFileModel()
    {
        $mock = $this->getMockBuilder('Craft\AssetFileModel')
            ->disableOriginalConstructor()
            ->getMock();

        $source = $this->getMockAssetSourceModel();
        $content = $this->getMockContentModel();

        $mock->expects($this->any())->method('getSource')->willReturn($source);
        $mock->expects($this->any())->method('getContent')->willReturn($content);

        return $mock;
    }

    /**
     * Mock AssetSourceModel.
     *
     * @return AssetSourceModel|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockAssetSourceModel()
    {
        $mock = $this->getMockBuilder('Craft\AssetSourceModel')
            ->disableOriginalConstructor()
            ->getMock();

        $sourceType = $this->getMockBaseAssetSourceType();

        $mock->expects($this->any())->method('getSourceType')->willReturn($sourceType);

        return $mock;
    }

    /**
     * Mock AssetSourceModel.
     *
     * @return AssetSourceModel|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockBaseAssetSourceType()
    {
        $mock = $this->getMockBuilder('Craft\BaseAssetSourceType')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->any())->method('getLocalCopy')->willReturn('test.jpg');

        return $mock;
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
     * Mock ContentModel.
     *
     * @return ContentModel|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockContentModel()
    {
        $mock = $this->getMockBuilder('Craft\ContentModel')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->any())->method('getAttribute')->willReturn(array());

        return $mock;
    }

    /**
     * Mock Content Service.
     *
     * @return ContentService|\PHPUnit_Framework_MockObject_MockObject
     */
    private function setMockContentService()
    {
        $mock = $this->getMockBuilder('Craft\ContentService')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->any())->method('saveContent')->willReturn(true);

        $this->setComponent(craft(), 'content', $mock);
    }
}
