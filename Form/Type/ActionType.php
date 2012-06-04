<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class ActionType extends NodeType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('label')
            ->add('action')
            ->add('params', 'json_array')
        ;
    }

    /**
     * @{inheritDoc}
     */
    public function getName()
    {
        return 'soloist_action';
    }
}
