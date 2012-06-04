<?php

namespace Soloist\Bundle\CoreBundle\Entity;

abstract class Block
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Node
     */
    protected $page;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Soloist\Bundle\CoreBundle\Entity\Page $node
     */
    public function setNode(Page $page)
    {
        $this->page = $page;
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    abstract public function getType();
}
