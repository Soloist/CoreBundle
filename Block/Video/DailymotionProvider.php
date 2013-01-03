<?php

namespace Soloist\Bundle\CoreBundle\Block\Video;

/**
 * The Dailymotion video provider
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class DailymotionProvider extends AbstractProvider
{
    const REGEX = '@^https?://([-a-z0-9]+\.)?dailymotion\.com/video/(?<ref>[0-9a-z]+)@i';
    const URL = 'http://www.dailymotion.com/video/%ref%';

    /**
     * @{inheritDoc}
     */
    public function getRegex()
    {
        return static::REGEX;
    }

    /**
     * @{inheritDoc}
     */
    public function getUrl()
    {
        return static::URL;
    }

    /**
     * @{inheritDoc}
     */
    public function getName()
    {
        return 'Dailymotion';
    }
}
