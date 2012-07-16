<?php

namespace Soloist\Bundle\CoreBundle\Type\BlockSettings;

use Symfony\Component\Form\DataTransformerInterface,
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityManager;

/**
 *
 * Block for similar content.
 * @author nek
 *
 */
class SimilarContentType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Construct form
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Build the form
     * @param  FormBuilderInterface $builder
     * @param  array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->appendClientTransformer($this)
            ->add('node', 'choice', array(
                'class'         => 'SoloistCoreBundle:Page',
                'empty_value'   => 'Choisissez un élément',
                'label'         => 'Élément'
            ))
        ;
    }
}
