<?php

namespace Soloist\Bundle\CoreBundle\Block\Video;

/**
 * The Youtube video provider
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class YoutubeProvider extends AbstractProvider
{
    const REGEX = '@^https?://(www\.)?youtube\.com/watch\?v=(?<ref>[_a-z0-9]+)@i';
    const URL = 'http://www.youtube.com/watch?v=%ref%';

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
        return 'Youtube';
    }
}
