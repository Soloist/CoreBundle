<?php

namespace Soloist\Bundle\CoreBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Gedmo\Tool\Wrapper\EntityWrapper;
use Gedmo\Tree\TreeListener;
use Soloist\Bundle\CoreBundle\Entity\Node;

/**
 * Event subscriber to manage node position
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class NodePlacementSubscriber implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $node = $args->getEntity();
        if ($node instanceof Node && null !== $node->getParent()) {
            // We are first child
            if ($node->getParent()->getLft() + 1 === $node->getLft()) {
                $node->setPlacementMethod('FirstChild');
                $node->setRefererNode($node->getParent());
            } else {
                $repo = $args->getEntityManager()->getRepository('SoloistCoreBundle:Node');
                $node->setPlacementMethod('NextSibling');
                $node->setRefererNode($repo->findOneBy(array(
                    'rgt' => $node->getLft() - 1,
                    'root' => $node->getRoot()
                )));
            }
        }
    }

    /**
     * @{inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return array('postLoad');
    }
}
