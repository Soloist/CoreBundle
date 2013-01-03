<?php

namespace Soloist\Bundle\CoreBundle\Block\Video;

/**
 * The Polyvalent video provider
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @{inheritDoc}
     */
    public function compute($url)
    {
        $matches = null;
        preg_match($this->getRegex(), $url, $matches);

        return $matches['ref'];
    }

    /**
     * @{inheritDoc}
     */
    public function reverseCompute($ref)
    {
        return strtr($this->getUrl(), array('%ref%' => $ref));
    }

    /**
    * @{inheritDoc}
    */
    public function supports($url)
    {
        return 1 === preg_match($this->getRegex(), $url);
    }

    /**
     * @return string
     */
    abstract public function getRegex();

    /**
     * @return string
     */
    abstract public function getUrl();
}
