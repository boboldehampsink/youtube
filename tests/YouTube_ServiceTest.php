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
     * Test process type hinting.
     *
     * @expectedException \PHPUnit_Framework_Error
     * @covers ::process
     */
    final public function testProcessTypeHinting()
    {
        $service = new YouTubeService();
        $service->process(new \stdClass(), new \stdClass(), 'handle', 0);
    }

    /**
     * Test process.
     *
     * @param bool|\Exception                      $exception
     * @param string|\Google_Service_YouTube_Video $status
     *
     * @covers ::process
     * @dataProvider providePaths
     */
    final public function testProcess($exception, $status)
    {
        // Set up service
        $this->setMockYouTubeService($exception, $status);

        // Set up model
        $model = $this->getMockAssetFileModel();

        // Process
        $result = craft()->youTube->process($model, $model, 'handle', 0);

        // Depend asserts on exception
        if (!$exception) {
            if (!is_string($status)) {
                $this->assertTrue($result);
            } else {
                $this->assertSame($result, 'Unable to communicate with the YouTube API client.');
            }
        } else {
            $this->assertStringEndsWith('error occurred: message', $result);
        }
    }

    /**
     * Provide different paths for process.
     *
     * @return array
     */
    final public function providePaths()
    {
        require_once __DIR__.'/../vendor/autoload.php';

        // Set YouTube ID
        $status = new \Google_Service_YouTube_Video();
        $status->id = '9NiMDN1fxno';

        return array(
            'Succeed' => array(false, $status),
            'Catch \Exception' => array(new \Exception('message'), $status),
            'Catch Craft\Exception' => array(new Exception('message'), $status),
            'Catch \Google_Service_Exception' => array(new \Google_Service_Exception('message'), $status),
            'Catch \Google_Exception' => array(new \Google_Exception('message'), $status),
            'Catch invalid video object' => array(false, 'string'),
        );
    }

    /**
     * Mock YouTube Service.
     *
     * @param bool|\Exception                      $exception
     * @param string|\Google_Service_YouTube_Video $status
     *
     * @return YouTube|\PHPUnit_Framework_MockObject_MockObject
     */
    private function setMockYouTubeService($exception = false, $status = 'string')
    {
        $this->setMockContentService();
        $this->setMockYouTubeOauthService();

        $mock = $this->getMockBuilder('Craft\YouTubeService')
            ->setMethods(array('exists', 'uploadChunks', 'saveHash', 'getAssetFileHash'))
            ->getMock();

        $mock->expects($this->any())->method('getAssetFileHash')->willReturn(md5('test.jpg'));

        if ($exception instanceof \Exception) {
            $mock->expects($this->any())->method('uploadChunks')->will($this->throwException($exception));
        } else {
            $mock->expects($this->any())->method('uploadChunks')->willReturn($status);
        }

        $this->setComponent(craft(), 'youTube', $mock);
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

    /**
     * Mock YouTube Oauth Service.
     *
     * @return YouTube|\PHPUnit_Framework_MockObject_MockObject
     */
    private function setMockYouTubeOauthService()
    {
        $mock = $this->getMockBuilder('Craft\YouTube_OauthService')
            ->disableOriginalConstructor()
            ->getMock();

        $token = $this->getMockOAuthTokenModel();

        $mock->expects($this->any())->method('getToken')->willReturn($token);

        $this->setComponent(craft(), 'youTube_oauth', $mock);
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
}
