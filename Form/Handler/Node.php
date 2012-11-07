<?php

namespace Soloist\Bundle\CoreBundle\Form\Handler;

use Doctrine\ORM\EntityManager,
    Doctrine\Common\Util\Inflector;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\Form\Form;

use Soloist\Bundle\CoreBundle\Node\Factory as NodeFactory,
    Soloist\Bundle\CoreBundle\Entity\Node as NodeEntity,
    Soloist\Bundle\CoreBundle\Form\Type\PageType,
    Soloist\Bundle\CoreBundle\Entity\Page;

class Node
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $factory;

    /**
     * @var \Soloist\Bundle\CoreBundle\Node\Factory
     */
    protected $nodeFactory;

    /**
     * @param NodeFactory   $nodeFactory
     * @param EntityManager $em
     * @param FormFactory   $factory
     */
    public function __construct(NodeFactory $nodeFactory, EntityManager $em, FormFactory $factory)
    {
        $this->em          = $em;
        $this->factory     = $factory;
        $this->nodeFactory = $nodeFactory;
    }

    /**
     * @param Form    $form
     * @param Request $request
     *
     * @return bool
     */
    public function create(Form $form, Request $request)
    {
        $form->bind($request);
        if ($form->isValid()) {
            $this->processNodePlacement($form);
            $this->em->flush();

            return true;
        }

        return false;
    }

    /**
     * @param Form    $form
     * @param Request $request
     *
     * @return bool
     */
    public function update(Form $form, Request $request)
    {
        $form->bind($request);
        if ($form->isValid()) {
            $this->processNodePlacement($form);
            $this->em->flush();

            return true;
        }

        return false;
    }

    /**
     * @param string $type
     * @param string $pageType
     *
     * @return Form
     */
    public function getCreateForm($type, $pageType = null)
    {
        $node = $this->nodeFactory->getNode($type, $pageType);
        $form = $this->nodeFactory->getFormType($type);

        return $this->factory->create($form, $node);
    }

    /**
     * @param NodeEntity $node
     *
     * @return Form
     */
    public function getUpdateForm(NodeEntity $node)
    {
        $form = $this->nodeFactory->getFormType($node->getType(), $node);

        return $this->factory->create($form, $node);
    }

    /**
     * @param Form $form
     */
    protected function processNodePlacement(Form $form)
    {
        $node = $form->getData();
        $method = sprintf('persistAs%sOf', $node->getPlacementMethod());
        $this->em->getRepository('SoloistCoreBundle:Node')->$method($node, $node->getRefererNode());
    }
}
