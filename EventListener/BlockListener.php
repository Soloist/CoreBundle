<?php

namespace Soloist\Bundle\CoreBundle\EventListener;

use Soloist\Bundle\CoreBundle\Form\Type\BlockSettings\PageShortcutType,
    Soloist\Bundle\BlockBundle\EventListener\Event\RequestTypes;

use Doctrine\ORM\EntityManager;

class BlockListener
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    /**
     * Listen to the RequestTypes event from block bundle
     *
     * @param \Soloist\Bundle\BlockBundle\EventListener\Event\RequestTypes $event
     */
    public function onRequestTypes(RequestTypes $event)
    {
        $event->getManager()
            // Add last_news block
            ->addBlockType('page_shortcut', array(
                'name'          => 'Raccourcis de page',
                'action'        => 'SoloistCoreBundle:Default:pageShortcut',
                'settings'      => array('page' => null, 'path_image' => null, 'description' => null),
                'form'          => new PageShortcutType($this->em),
                'form_template' => 'SoloistCoreBundle:AdminBlock:configurePageShortcut.html.twig'
            ))
        ;
    }
}
