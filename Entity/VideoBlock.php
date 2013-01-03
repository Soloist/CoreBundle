<?php

namespace Soloist\Bundle\CoreBundle\Entity;

class VideoBlock extends Block
{
    /**
     * @var string
     */
    protected $ref;

    /**
     * @var string
     */
    protected $provider;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param string $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @{inheritDoc}
     */
    public function getType()
    {
        return 'video';
    }
}
