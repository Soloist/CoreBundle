<?php

namespace Soloist\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use DoctrineExtensions\Taggable\Taggable;

class Page extends Node implements Taggable
{

    /**
     * The page slug
     *
     * @var string
     */
    protected $slug;

    /**
     *
     * The page type, as defined in configuration
     * @var string
     */
    protected $pageType;


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $blocks;

    /**
     * Tags managed by FPNTagBundle
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $tags;

    /**
     * Tas as text
     * @var string
     */
    public $tagsAsText;

    public function __construct()
    {
        $this->blocks = new ArrayCollection;
        $this->tags =   new ArrayCollection;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    public function addBlock(Block $block)
    {
        $this->blocks[$block->getName()] = $block;
        $block->setNode($this);
    }

    public function removeBlock(Block $blockToRemove)
    {
        foreach ($this->blocks as $key => $block) {
            if ($block->getName() == $blockToRemove->getName()) {
                $this->blocks->remove($key);
            }
        }
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    public function getType()
    {
        return 'page';
    }

    /**
     * @param string $pageType
     */
    public function setPageType($pageType)
    {
        $this->pageType = $pageType;
    }

    /**
     * @return string
     */
    public function getPageType()
    {
        return $this->pageType;
    }

    public function getBlock($blockName)
    {
        if (isset($this->blocks[$blockName])) {
            return $this->blocks[$blockName];
        }

        foreach ($this->blocks as $block) {
            if ($block->getName() == $blockName) {
                return $block;
            }
        }

        return null;
    }

    /*
     * Lifecycle Events
     */
    public function postLoad()
    {
        $blocks = new ArrayCollection;
        foreach ($this->blocks as $block) {
            $blocks[$block->getName()] = $block;
        }

        $this->blocks = $blocks;
    }

    /**
     * Get tags
     * @return ArrayCollection
     */
    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    /**
     * Get tag type
     * @return string
     */
    public function getTaggableType()
    {
        return 'soloist_tag';
    }

    /**
     * Get id of the current entity
     * @return integer
     */
    public function getTaggableId()
    {
        return $this->getId();
    }

}
