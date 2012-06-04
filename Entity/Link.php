<?php

namespace Soloist\Bundle\CoreBundle\Entity;

class Link extends Node
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @param $uri string
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    public function getType()
    {
        return 'link';
    }
}
