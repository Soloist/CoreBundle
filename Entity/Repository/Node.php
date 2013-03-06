<?php

namespace Soloist\Bundle\CoreBundle\Entity\Repository;

use Doctrine\ORM\Query\Expr;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Soloist\Bundle\CoreBundle\Entity\Node as NodeEntity;

class Node extends NestedTreeRepository
{
    public function findAllOrderedByLeft()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.lft')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Entity\Node
     */
    public function findRoot()
    {
        return $this
            ->getRootNodesQueryBuilder()
            ->getQuery()
            ->getSingleResult()
        ;
    }

    /**
     * Returns the first sub-root ancestor of given node
     *
     * @param NodeEntity   $node
     *
     * @return NodeEntity
     */
    public function findFirstLevelParent(NodeEntity $node)
    {
        return $this->createQueryBuilder('n')
            ->where('n.lft <= :lft')
            ->andWhere('n.rgt >= :rgt')
            ->andWhere('n.level = 1')
            ->setParameters(
                array(
                    'lft' => $node->getLft(),
                    'rgt' => $node->getRgt(),
                )
            )
            ->getQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param string $specialKey
     *
     * @return NodeEntity
     */
    public function findBySpecialKey($specialKey)
    {
        return $this->createQueryBuilder('n')
            ->where('n.specialKey = :key')
            ->setParameter('key', $specialKey)
            ->getQuery()
            ->getSingleResult();
    }
}
