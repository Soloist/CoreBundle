<?php

namespace Soloist\Bundle\CoreBundle\Entity\Repository;

use Doctrine\ORM\Query\Expr;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use DoctrineExtensions\Taggable\Taggable;

use Doctrine\ORM\Query\ResultSetMappingBuilder;

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
        $tagsList = '';
        $count = $resource->getTags()->count();

        if ($count < 1) {
            return array();
        }

        foreach ($resource->getTags() as $tag) {
            if (!empty($tagsList)) {
                $tagsList .= ', ';
            }
            $tagsList .= '\'' . $tag->getSlug() . '\'';
        }

        $part = <<<SQL
SELECT DISTINCT * FROM node a
WHERE id IN (
    SELECT resourceId FROM tagging tg
    INNER JOIN t.name as t ON t.id = tg.tag_id
    WHERE t.slug IN({$tagsList})
        AND resourceType = 'soloist_node'
    GROUP BY resourceId
    HAVING COUNT(t.id) = $count
)
ORDER BY node.created_at ASC
SQL;
        $sql = '';

        do {
            if (!empty($sql)) {
                $sql .= ' UNION ';
            }
            $sql .= str_replace('$count', $count, $sql);
            $count--;
        } while ($sql === '' || $count > 0);


        $sql .= "\n" . 'LIMIT ' . $limit;

        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata('SoloistCoreBundle:Node', 'n');

        $replacedValues = array($count, $limit);
        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }
}
