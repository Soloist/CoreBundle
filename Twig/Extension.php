<?php

namespace Soloist\Bundle\CoreBundle\Twig;

use Soloist\Bundle\CoreBundle\Block\Factory,
    Soloist\Bundle\CoreBundle\Router;

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

    public function __construct(Factory $factory, Router $router)
    {
        $this->blockFactory = $factory;
        $this->router       = $router;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->templating = $environment;
    }

    public function getFunctions()
    {
        return array(
            'soloist_block_form' => new \Twig_Function_Method($this, 'getBlockTemplateForm', array('is_safe' => array('html'))),
            'soloist_page_form'  => new \Twig_Function_Method($this, 'getPageTemplateForm',  array('is_safe' => array('html'))),
            'soloist_path'       => new \Twig_Function_Method($this, 'generateUrl', array('is_safe' => array('html'))),
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

    public function getName()
    {
        return 'soloist_core';
    }
}
