<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType,
    Symfony\Component\Form\FormBuilderInterface;

use Soloist\Bundle\CoreBundle\Form\DataTransformer\ArrayToJsonTransformer;

class JsonArrayType extends TextType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->prependClientTransformer(new ArrayToJsonTransformer)
        ;
    }

    public function getName()
    {
        return 'json_array';
    }

    public function getParent()
    {
        return 'text';
    }
}
