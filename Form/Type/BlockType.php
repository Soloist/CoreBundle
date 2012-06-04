<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\AbstractType;

abstract class BlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'hidden');
    }

    public function getName()
    {
        return 'soloist_block';
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => $this->getDataClass(),
        );
    }

    abstract public function getDataClass();
}
