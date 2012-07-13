<?php

namespace Soloist\Bundle\CoreBundle\Entity\Repository;

use Doctrine\ORM\Query\Expr;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use DoctrineExtensions\Taggable\Taggable;

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
     * Get similar results
     * NEED a taggable node
     * Sql draft available here: https://gist.github.com/3105206/70ab5aaa6654890433d8e5d9671f320a695d3627
     * @param  Taggable $resource
     * @param  integer  $limit
     * @return array
     */
    public function getSimilarResults(Taggable $resource, $limit = 5)
    {
        $qb = $this->createQueryBuilder('n');
        // will be better with a native query
    }
}
