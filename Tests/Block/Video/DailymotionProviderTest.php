<?php

namespace Soloist\Bundle\CoreBundle\Tests\Block\Video;

use Soloist\Bundle\CoreBundle\Block\Video\DailymotionProvider;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class DailymotionProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DailymotionProvider
     */
    protected $object;

    public function setUp()
    {
        $this->object = new DailymotionProvider;
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
            array('http://www.dailymotion.com/video/xw5zpg#.UOWmKrZKJcw', 'http://www.dailymotion.com/video/xw5zpg', 'xw5zpg'),
            array('http://www.dailymotion.com/video/xw5zpg', 'http://www.dailymotion.com/video/xw5zpg', 'xw5zpg'),
            array('http://www.dailymotion.com/video/xw5zpg_best-of-abrutis-32_fun#.UOWmJLZKJcx', 'http://www.dailymotion.com/video/xw5zpg', 'xw5zpg'),
        );
    }

    public function unsupportedUrlsProvider()
    {
        return array(
            array('http://www.dailymotion.com/xw5zpg#.UOWmKrZKJcw'),
            array('https://www.youtube.com/watch?v=aX_yp5_TJ8A'),
        );
    }
}
