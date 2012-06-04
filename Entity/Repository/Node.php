<?php

namespace Soloist\Bundle\CoreBundle\Entity\Repository;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

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
}
