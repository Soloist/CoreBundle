<?php

namespace Soloist\Bundle\CoreBundle\Node;

use Symfony\Component\DependencyInjection\ContainerAware;

use Soloist\Bundle\CoreBundle\Block\Factory as BlockFactory;

class Factory extends ContainerAware
{
    /**
     * @var array
     */
    protected $nodes = array();

    /**
     * @var array
     */
    protected $forms = array();

    /**
     * @var \Soloist\Bundle\CoreBundle\Block\Factory
     */
    protected $blockFactory;

    public function __construct(BlockFactory $blockFactory, $config)
    {
        $this->blockFactory = $blockFactory;
        foreach ($config as $key => $params) {
            $this->nodes[$key] = $params['class'];
            $this->forms[$key] = $params['form_type'];
        }
    }

    public function getNode($type, $pageType = null)
    {
        $clazz = $this->nodes[$type];
        $node = new $clazz;

        if ('page' == $type) {
            $pageType = null === $pageType ? $this->blockFactory->getPageFirst() : $pageType;
            $node->setPageType($pageType);
            foreach ($this->blockFactory->getPageType($pageType) as $block) {
                $node->addBlock($block);
                $block->setNode($node);
            }
        }

        return $node;
    }

    public function getFormType($type, $node = null)
    {
        $formType = null;
        if (class_exists($this->forms[$type])) {
            $clazz = $this->forms[$type];
            $formType = new $clazz($this->container->get('doctrine.orm.entity_manager'));
        } else {
            $formType = $this->container->get($this->forms[$type]);
        }

        $formType->setNode($node);

        return $formType;
    }
}
