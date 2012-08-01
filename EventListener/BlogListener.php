<?php

namespace Soloist\Bundle\CoreBundle\EventListener;

use Soloist\Bundle\CoreBundle\Form\Type\BlockSettings\PageShortcutType,
    Soloist\Bundle\BlogBundle\EventListener\Event\RequestCategories;

use Doctrine\ORM\EntityManager;

class BlogListener
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    /**
     * Listen to the RequestCategories event from blog bundle
     *
     * @param \Soloist\Bundle\BlogBundle\EventListener\Event\RequestCategories $event
     */
    public function onRequestCategories(RequestCategories $event)
    {
        $repo = $this->em->getRepository('SoloistCoreBundle:Category');
        $categories = $repo->findAll();

        foreach($categories as $category) {
            $event->addCategory($category->getGlobalId(), $category->getTitle());
        }
    }
}
