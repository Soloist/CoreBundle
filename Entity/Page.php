<?php

namespace Soloist\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Page extends Node
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

    public function __construct()
    {
        parent::__construct();

        $this->blocks = new ArrayCollection;
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

}
