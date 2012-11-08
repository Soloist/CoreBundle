<?php

namespace Soloist\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Inflector;
use HtmlTools\Inflector as HtmlInflector;
/**
 * The Node Class do some things...
 *
 * @author Yohan Giarelli <yohan@giarelli.org>
 */

abstract class Node
{
    /**
     * @var array<string>
     */
    public static $placementMethods = array(
        'PrevSibling' => 'Avant',
        'NextSibling' => 'Après',
        'FirstChild'  => 'Premier enfant de',
        'LastChild'   => 'Dernier enfant de',
    );

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
     *
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
     * @var \Soloist\Bundle\CoreBundle\Entity\Node
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
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var Node
     */
    protected $refererNode;

    /**
     * @var string
     */
    protected $placementMethod;

    public function __construct()
    {
        $this->children   = new ArrayCollection;
        $this->isSoftRoot = false;
    }

    /**
     * @param Node $node
     */
    public function addChild(Node $node)
    {
        $this->children->add($node);
    }

    /**
     * @return ArrayCollection
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
     * @return Node
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
     * @return \DateTime
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

    public function getGlobalId()
    {
        return 'core-' . $this->getType() . '-' . $this->getId();
    }

    /**
     * @param string $placementMethod
     */
    public function setPlacementMethod($placementMethod)
    {
        $this->placementMethod = $placementMethod;
    }

    /**
     * @return string
     */
    public function getPlacementMethod()
    {
        return $this->placementMethod;
    }

    /**
     * @param \Soloist\Bundle\CoreBundle\Entity\Node $refererNode
     */
    public function setRefererNode($refererNode)
    {
        $this->refererNode = $refererNode;
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Entity\Node
     */
    public function getRefererNode()
    {
        return $this->refererNode;
    }

    public function getIdentifier()
    {
        return HtmlInflector::urlize($this->getTitle());
    }
}
