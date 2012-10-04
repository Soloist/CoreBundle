<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageBlockType extends BlockType
{
    /**
     * @{inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title', null, array('required' => false))
            ->add('path', 'hidden', array('required' => false))
        ;
    }

    /**
     * @{inheritDoc}
     */
    public function getDataClass()
    {
        return 'Soloist\Bundle\CoreBundle\Entity\ImageBlock';
    }

    /**
     * @{inheritDoc}
     */
    public function getName()
    {
        return 'soloist_block_image';
    }
}
