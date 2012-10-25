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
     * @var TreeListener
     */
    private $treeListener;

    /**
     * @param TreeListener $treeListener
     */
    public function __construct(TreeListener $treeListener)
    {
        $this->treeListener = $treeListener;
    }

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
                $node->setPlacementMethod('PrevSibling');
                $node->setRefererNode($repo->findOneBy(array(
                    'rgt' => $node->getLft() - 1,
                    'root' => $node->getRoot()
                )));
            }
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $node = $args->getEntity();
        if ($node instanceof Node) {
            $em = $args->getEntityManager();
            if ($referer = $node->getRefererNode()) {
                $wrapped = new EntityWrapper($node, $em);
                $wrapped->setPropertyValue('parent', $referer);
                $this->treeListener
                    ->getStrategy($em, get_class($node))
                    ->setNodePosition(spl_object_hash($node), $node->getPlacementMethod());
                $wrapped->setPropertyValue('lft', 0); // simulate changeset
            }
        }
    }
    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $node = $args->getEntity();
        if ($node instanceof Node) {
            $em = $args->getEntityManager();
            if ($referer = $node->getRefererNode()) {
                $this->treeListener
                    ->getStrategy($em, get_class($node))
                    ->updateNode($em, $node, $referer, $node->getPlacementMethod());
            }
        }
    }

    /**
     * @{inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return array('postLoad', 'prePersist', 'preUpdate');
    }
}
