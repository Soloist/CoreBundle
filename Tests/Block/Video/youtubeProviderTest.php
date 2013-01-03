<?php

namespace Soloist\Bundle\CoreBundle\Tests\Block\Video;

use Soloist\Bundle\CoreBundle\Block\Video\YoutubeProvider;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class YoutubeProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var YoutubeProvider
     */
    protected $object;

    public function setUp()
    {
        $this->object = new YoutubeProvider;
    }

    /**
     * @dataProvider supportedUrlsProvider
     */
    public function testSupportedUrls($url, $canonical, $excpectedRef)
    {
        $this->assertTrue($this->object->supports($url));
        $this->assertSame($excpectedRef, $this->object->compute($url));
        $this->assertSame($canonical, $this->object->reverseCompute($excpectedRef));
    }

    /**
     * @dataProvider unsupportedUrlsProvider
     */
    public function testUnsupportedUrls($url)
    {
        $this->assertFalse($this->object->supports($url));
    }

    public function supportedUrlsProvider()
    {
        return array(
            array('https://www.youtube.com/watch?v=aX_yp5_TJ8A', 'http://www.youtube.com/watch?v=aX_yp5_TJ8A', 'aX_yp5_TJ8A'),
            array('https://youtube.com/watch?v=aX_yp5_TJ8A', 'http://www.youtube.com/watch?v=aX_yp5_TJ8A', 'aX_yp5_TJ8A'),
        );
    }

    public function unsupportedUrlsProvider()
    {
        return array(
            array('https://www.youtube.com/?aX_yp5_TJ8A'),
            array('http://www.dailymotion.com/video/xw5zpg'),
        );
    }
}
