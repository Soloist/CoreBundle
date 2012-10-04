<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class TextBlockType extends BlockType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('value', 'textarea', array('required' => false))
        ;
    }

    public function getDataClass()
    {
        return 'Soloist\Bundle\CoreBundle\Entity\TextBlock';
    }

    public function getName()
    {
        return 'soloist_block_text';
    }
}
