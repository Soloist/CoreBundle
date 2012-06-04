<?php

namespace Soloist\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Util\Inflector;
/**
 * The Node Class do some things...
 *
 * @author Yohan Giarelli <yohan@giarelli.org>
 */

abstract class Node
{
    /**
     * The node ID
     */
    protected $id;

    /**
     * NestedSet left value
     *
     * @var int
     */
    protected $lft;

    /**
     * NestedSet right value
     *
     * @var int
     */
    protected $rgt;

    /**
     * Node level (0 => root, 1 => root child, etc..)
     * @var int
     */
    protected $level;

    /**
     * Tree Root id
     */
    protected $root;

    /**
     * The parent
     *
     * @var \Soloist\Bundle\CoreBundle\Node
     */
    protected $parent;

    /**
     * The childrens. As Doctrine collection
     *
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $children;

    /**
     * Soft root. If true, subtree will be isolated
     *
     * @var boolean
     */
    protected $isSoftRoot;

    /**
     * The node name
     *
     * @var string
     */
    protected $title;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->children = new ArrayCollection;
    }

    /**
     * @param \Soloist\Bundle\CoreBundle\Entity\Doctrine\Common\Collections\Collection $children
     */
    public function addChild(Node $node)
    {
        $this->children->add($node);
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Entity\Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param boolean $isSoftRoot
     */
    public function setSoftRoot($isSoftRoot)
    {
        $this->isSoftRoot = $isSoftRoot;
    }

    /**
     * @return boolean
     */
    public function isSoftRoot()
    {
        return $this->isSoftRoot;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return int
     */
    public function getLft()
    {
        return $this->lft;
    }

    public function setParent(Node $node)
    {
        $this->parent = $node;
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Node
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return int
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function __toString()
    {
        return str_repeat('- ', $this->level) . $this->title;
    }

    public function getRouteParams()
    {
        return array(
            'id'   => $this->id,
            'type' => $this->getType()
        );
    }

    public function isRoot()
    {
        return null === $this->parent;
    }

    abstract public function getType();

    /**
     * @return \Soloist\Bundle\CoreBundle\Entity\DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function postLoad()
    {
    }
}
