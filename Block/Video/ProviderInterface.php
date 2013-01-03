<?php

namespace Soloist\Bundle\CoreBundle\Block\Video;

/**
 * The video provider interface
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
interface ProviderInterface
{
    /**
     * Returns the video ref
     *
     * @param  string $url
     *
     * @return string
     */
    public function compute($url);

    /**
     * return an url to the video
     *
     * @param  string $ref
     *
     * @return string
     */
    public function reverseCompute($ref);

    /**
     * Returns true if the given URL is supported by the provider
     *
     * @param  string $url
     *
     * @return bool
     */
    public function supports($url);

    /**
     * Return the provider name
     *
     * @return string
     */
    public function getName();
}
