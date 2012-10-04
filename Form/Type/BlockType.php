<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class BlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'hidden', array('required' => false));
    }

    public function getName()
    {
        return 'soloist_block';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => $this->getDataClass()));
    }

    abstract public function getDataClass();
}
