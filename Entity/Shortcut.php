<?php

namespace Soloist\Bundle\CoreBundle\Entity;

class Shortcut extends Node
{
    /**
     * @var \Soloist\Bundle\CoreBundle\Entity\Node
     */
    protected $node;

    /**
     * @param \Soloist\Bundle\CoreBundle\Entity\Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Entity\Node
     */
    public function getNode()
    {
        return $this->node;
    }

    public function getType()
    {
        return 'shortcut';
    }
}
