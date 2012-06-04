<?php

namespace Soloist\Bundle\CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface,
    Symfony\Component\Form\FormFactoryInterface,
    Symfony\Component\Form\Event\DataEvent,
    Symfony\Component\Form\FormEvents;

use Soloist\Bundle\CoreBundle\Block\Factory;


/**
 * Resize a collection form element based on the data sent from the client.
 *
 * @author Bernhard Schussek <bernhard.schussek@symfony-project.com>
 */
class ResizeFormListener implements EventSubscriberInterface
{
    /**
     * @var FormFactoryInterface
     */
    protected $factory;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var \Soloist\Bundle\CoreBundle\Block\Factory
     */
    protected $blockFactory;

    public function __construct(FormFactoryInterface $factory, Factory $blockFactory, array $options = array())
    {
        $this->factory      = $factory;
        $this->options      = $options;
        $this->blockFactory = $blockFactory;
    }

    static public function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }

    public function preSetData(DataEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (null === $data) {
            $data = array();
        }

        // First remove all rows
        foreach ($form as $name => $child) {
            $form->remove($name);
        }

        // Then add all rows again in the correct order
        foreach ($data as $value) {
            $form->add($this->factory->createNamed(
                $value->getName(),
                $this->blockFactory->getBlockForm($value->getType()),
                $value,
                array_replace(array('property_path' => '['.$value->getName().']'), $this->options)
            ));
        }
    }
}
