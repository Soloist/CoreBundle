<?php

namespace Soloist\Bundle\CoreBundle\Block;



class Factory
{
    /**
     * @var array
     */
    protected $pageConfig;

    /**
     * @var array
     */
    protected $blockConfig;

    /**
     * @param array $pageConfig
     * @param array $blockConfig
     */
    public function __construct(array $pageConfig, array $blockConfig)
    {
        $this->pageConfig  = $pageConfig;
        $this->blockConfig = $blockConfig;
    }

    /**
     * Returns the first page type namee
     *
     * @return string
     */
    public function getPageFirst()
    {
        $keys = array_keys($this->pageConfig);

        return array_shift($keys);
    }

    /**
     * Retyrbs an array of blocks to include in the page
     *
     * @param $type
     * @return array|\Soloist\Bundle\CoreBundle\Entity\Block
     */
    public function getPageType($type)
    {
        if (isset($this->pageConfig[$type])) {
            $blockDefinition = $this->pageConfig[$type];
            $blocks = array();

            foreach ($blockDefinition['fields'] as $name => $blockType) {
                $blocks[$name] = $this->createBlock($blockType);
                $blocks[$name]->setName($name);
            }

            return $blocks;
        }

        return array();
    }

    /**
     * Returns the template for page rendering
     *
     * @param $type
     * @return null
     */
    public function getPageTemplate($type)
    {
        if (isset($this->pageConfig[$type])) {
            return $this->pageConfig[$type]['template'];
        }

        return null;
    }

    /**
     * Returns the template for page rendering
     *
     * @param $type
     * @return null
     */
    public function getPageFormTemplate($type)
    {
        if (isset($this->pageConfig[$type])) {
            return $this->pageConfig[$type]['admin_template'];
        }

        return null;
    }

    /**
     * Returns an array of available pages types
     *
     * @return array|string
     */
    public function getPageTypes()
    {
        $keys = array_keys($this->pageConfig);

        return array_combine($keys, $keys);
    }

    /**
     * Creates an instance of the wanted Block
     *
     * @param $type
     * @return \Soloist\Bundle\CoreBundle\Entity\Block
     */
    public function createBlock($type)
    {
        if (isset($this->blockConfig[$type])) {
            $class = $this->blockConfig[$type];
            return new $class['class'];
        }

        return null;
    }

    public function getBlockTemplate($type)
    {
        if (isset($this->blockConfig[$type])) {
            return $this->blockConfig[$type]['form_template'];
        }

        return null;
    }

    public function getBlockForm($type)
    {
        if (isset($this->blockConfig[$type])) {
            $class = $this->blockConfig[$type];
            return new $class['form_type'];
        }

        return null;
    }
}
