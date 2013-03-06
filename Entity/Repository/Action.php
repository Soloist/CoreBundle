<?php

namespace Soloist\Bundle\CoreBundle\Entity\Repository;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class Action extends NestedTreeRepository
{
    public function findActionPointing($action, $params)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.action = :action')
            ->setParameter('action', $action);

        foreach ($params as $name => $value) {
            $param = 'p_'.$name;
            $qb
                ->andWhere(sprintf('a.params LIKE :%s', $param))
                ->setParameter($param, sprintf('%%%s%%%s%%', $name, $value));
        }

        $result = $qb->getQuery()->getResult();

        return isset($result[0]) ? $result[0] : null;
    }
}
