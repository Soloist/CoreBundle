<?php

namespace Soloist\Bundle\CoreBundle\Context;

use Soloist\Bundle\CoreBundle\Entity\Node;
use Soloist\Bundle\CoreBundle\Entity\Page;
use Soloist\Bundle\CoreBundle\Entity\Repository\Node as NodeRepository;

/**
 * The context class for managing current page
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class Navigation
{
    /**
     * @var NodeRepository
     */
    protected $repository;

    /**
     * @var Node
     */
    protected $current;

    /**
     * @param NodeRepository $repository
     */
    public function __construct(NodeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Node $node
     */
    public function setCurrent(Node $node)
    {
        $this->current = $node;
    }

    /**
     * @return Node
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @return Node
     */
    public function getCurrentFirstLevel()
    {
        return $this->repository->findFirstLevelParent($this->getCurrent());
    }
}
