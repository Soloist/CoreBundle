<?php

namespace Soloist\Bundle\CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Soloist\Bundle\CoreBundle\Block\Factory;
use Soloist\Bundle\CoreBundle\Entity\Block;


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
            FormEvents::PRE_BIND         => 'preBind'
        );
    }

    public function preSetData(FormEvent $event)
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
            $this->addBlockRow($form, $value);
        }
    }

    /**
     * Hack for re-setting blocks names
     *
     * @param FormEvent $event
     */
    public function preBind(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $blocks = $this->blockFactory->getPageType($form->getParent()->get('pageType')->getData());

        // Add needed blocks
        foreach ($data as $key => $value) {
            if (!$form->has($key) && isset($blocks[$key])) {
                $block = $blocks[$key];
                $block->setNode($form->getParent()->getData());
                $this->addBlockRow($form, $block);
            }
            if (!$value['name']) {
                $data[$key]['name'] = $key;
            }
        }

        // removes old ones
        foreach ($form as $key => $field) {
            if (!isset($blocks[$key])) {
                $form->remove($key);
            }
        }

        $event->setData($data);
    }

    /**
     * @param FormInterface $form
     * @param Block $block
     */
    private function addBlockRow(FormInterface $form, Block $block)
    {
        $form->add($this->factory->createNamed(
            $block->getName(),
            $this->blockFactory->getBlockForm($block->getType()),
            $block,
            array_replace(array('property_path' => '['.$block->getName().']'), $this->options)
        ));
    }
}
