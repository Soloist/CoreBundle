<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\EventListener\MergeCollectionListener,
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Soloist\Bundle\CoreBundle\EventListener\ResizeFormListener;

class BlockCollectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $resizeListener = new ResizeFormListener($builder->getFormFactory(), $options['block_factory'], $options['options']);
        $builder->addEventSubscriber($resizeListener);
        $builder->addEventSubscriber(new MergeCollectionListener(true,true));
    }

    public function getDefaultOptions()
    {
        return array(
            'block_factory'  => null,
            'type'           => 'text',
            'options'        => array(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'soloist_block_collection';
    }

}
