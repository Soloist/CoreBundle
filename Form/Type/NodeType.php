<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Soloist\Bundle\CoreBundle\Entity\Node;

/**
 * The NodeType Class do some things...
 *
 * @author Yohan Giarelli <yohan@giarelli.org>
 */

abstract class NodeType extends AbstractType
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var null|\Soloist\Bundle\CoreBundle\Entity\Node
     */
    protected $node;

    public function __construct(EntityManager $em)
    {
        $this->em   = $em;
    }

    public function setNode(Node $node = null)
    {
        $this->node = $node;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->needDisplayParent($this->node)) {
            $builder->add('parent');
        }

        $builder
            ->add('title')
            ->add('soft_root', 'checkbox', array('required' => false))
        ;
    }

    protected function needDisplayParent(Node $node = null)
    {
        if (null === $node) {
            try {
                $this->em->getRepository('SoloistCoreBundle:Node')->findRoot();

                return true;
            } catch (\Doctrine\ORM\NoResultException $e) {
                return false;
            }
        }

        return null !== $node->getParent();
    }


}
