<?php

namespace Soloist\Bundle\CoreBundle\EventListener;

use FrequenceWeb\Bundle\DashboardBundle\Menu\Event\Configure;

use Doctrine\ORM\EntityManager;

class DashboardListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onConfigureNewMenu(Configure $event)
    {
        $root = $event->getRoot();
        $root->addChild('Catégorie', array(
            'route' => 'soloist_admin_node_new',
            'routeParameters' => array('type' => 'category')
        ));
        $root->addChild('Raccourci', array(
            'route' => 'soloist_admin_node_new',
            'routeParameters' => array('type' => 'shortcut')
        ));
        $root->addChild('Lien (externe)', array(
            'route' => 'soloist_admin_node_new',
            'routeParameters' => array('type' => 'link')
        ));
        $root->addChild('Page', array(
            'route' => 'soloist_admin_node_new',
            'routeParameters' => array('type' => 'page')
        ));
    }

    public function onConfigureTopMenu(Configure $event)
    {
        $root = $event->getRoot();
        $root->addChild('Menu', array('route' => 'soloist_admin_node_index'));
    }

    public function onConfigureLeftMenu(Configure $event)
    {
        $root = $event->getRoot();
        $content = $root->addChild('Menu');
        $nodes = $this->em->getRepository('SoloistCoreBundle:Node')->findAllOrderedByLeft();

        foreach ($nodes as $node) {
            $content->addChild(
                str_repeat('&middot; ', $node->getLevel()). $node->getTitle(),
                array('route' => 'soloist_admin_node_edit', 'routeParameters' => $node->getRouteParams())
            );
        }
    }
}
