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

    public function __construct(NodeFactory $nodeFactory, EntityManager $em, FormFactory $factory)
    {
        $this->em          = $em;
        $this->factory     = $factory;
        $this->nodeFactory = $nodeFactory;
    }

    public function create(Form $form, Request $request)
    {
        $form->bind($request);
        if ($form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();

            return true;
        }

        return false;
    }

    public function update(Form $form, Request $request)
    {
        $form->bind($request);
        if ($form->isValid()) {
            $this->em->flush();

            return true;
        }

        return false;
    }

    public function getCreateForm($type, $pageType = null)
    {
        $node = $this->nodeFactory->getNode($type, $pageType);
        $form = $this->nodeFactory->getFormType($type);

        return $this->factory->create($form, $node);
    }

    public function getUpdateForm(NodeEntity $node)
    {
        $form = $this->nodeFactory->getFormType($node->getType(), $node);

        return $this->factory->create($form, $node);
    }
}
