<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class ImageBlockType extends BlockType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title')
            ->add('path', 'hidden')
        ;
    }

    public function getDataClass()
    {
        return 'Soloist\Bundle\CoreBundle\Entity\ImageBlock';
    }

    public function getName()
    {
        return 'soloist_block_image';
    }
}
