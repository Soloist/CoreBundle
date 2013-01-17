<?php

namespace Soloist\Bundle\CoreBundle\Entity;

/**
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
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
     * @param Page $page
     */
    public function setNode(Page $page)
    {
        $this->page = $page;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return string
     */
    abstract public function getType();
}
