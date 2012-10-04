<?php

namespace Soloist\Bundle\CoreBundle\Cache;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Soloist\Bundle\CoreBundle\Entity\Node;

/**
 * Invalidate the tree cache
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class NodeCacheListener implements EventSubscriber
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $uow = $args->getEntityManager()->getUnitOfWork();
        $entities = array_merge(
            $uow->getScheduledEntityDeletions(),
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates()
        );

        foreach ($entities as $entity) {
            if ($entity instanceof Node) {
                $this->cache->remove();

                return;
            }
        }
    }

    /**
     * @{inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return array(Events::onFlush);
    }
}
