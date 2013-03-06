<?php

namespace Soloist\Bundle\CoreBundle\Twig;

use Soloist\Bundle\CoreBundle\Block\Factory;
use Soloist\Bundle\CoreBundle\Context\Navigation;
use Soloist\Bundle\CoreBundle\Entity\Page;
use Soloist\Bundle\CoreBundle\Router;

class Extension extends \Twig_Extension
{
    /**
     * @var \Soloist\Bundle\CoreBundle\Block\Factory
     */
    private $blockFactory;

    /**
     * @var \Twig_Environment
     */
    private $templating;

    /**
     * @var \Soloist\Bundle\CoreBundle\Router
     */
    private $router;

    /**
     * @var Navigation
     */
    private $navigation;

    public function __construct(Factory $factory, Router $router, Navigation $navigation)
    {
        $this->blockFactory = $factory;
        $this->router       = $router;
        $this->navigation   = $navigation;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->templating = $environment;
    }

    public function getFunctions()
    {
        return array(
            'soloist_block_form'     => new \Twig_Function_Method($this, 'getBlockTemplateForm', array('is_safe' => array('html'))),
            'soloist_page_form'      => new \Twig_Function_Method($this, 'getPageTemplateForm',  array('is_safe' => array('html'))),
            'soloist_path'           => new \Twig_Function_Method($this, 'generateUrl', array('is_safe' => array('html'))),
            'current_node'           => new \Twig_Function_Method($this, 'getCurrentNode'),
            'current_slug'           => new \Twig_Function_Method($this, 'getCurrentSlug'),
            'first_level_identifier' => new \Twig_Function_Method($this, 'getFirstLevelIdentifier'),
        );
    }

    public function getBlockTemplateForm($type, $context)
    {
        return $this->templating->loadTemplate($this->blockFactory->getBlockTemplate($type))->render($context);
    }

    public function getPageTemplateForm($type, $context)
    {
        $formTemplate = $this->blockFactory->getPageFormTemplate($type) ?: 'SoloistCoreBundle:Admin:block_form.html.twig';

        return $this->templating->loadTemplate($formTemplate)->render($context);
    }

    public function generateUrl($node, $absolute = false)
    {
        return $this->router->generate($node, $absolute);
    }

    /**
     * @return string|null
     */
    public function getCurrentSlug()
    {
        $node = $this->navigation->getCurrent();

        return $node instanceof Page ? $node->getSlug() : null;
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Entity\Node
     */
    public function getCurrentNode()
    {
        return $this->navigation->getCurrent();
    }

    /**
     * @return string
     */
    public function getFirstLevelIdentifier()
    {
        return $this->navigation->getCurrentFirstLevel()->getIdentifier();
    }

    public function getName()
    {
        return 'soloist_core';
    }
}
