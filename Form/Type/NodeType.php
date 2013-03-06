<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Soloist\Bundle\CoreBundle\Entity\Node;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
            $builder
                ->add(
                    'placementMethod',
                    'choice',
                    array(
                        'choices'     => Node::$placementMethods,
                        'empty_value' => '',
                        'label'       => 'Méthode de placement'
                    )
                )
                ->add(
                    'refererNode',
                    'entity',
                    array(
                        'class'       => 'SoloistCoreBundle:Node',
                        'empty_value' => '',
                        'label'       => 'Noeud de référence',
                        'query_builder' => function(EntityRepository $repo) {
                            return $repo->createQueryBuilder('n')->orderBy('n.lft');
                        }
                    )
                );
        }

        $builder
            ->add('title', null, array('label' => 'Titre'))
            ->add('specialKey', null, array('label' => 'Clé spéciale', 'required' => false))
            ->add('visibleInMenu', null, array('label' => 'Visible dans le menu ?', 'required' => false))
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
