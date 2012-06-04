<?php

namespace Soloist\Bundle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 *
 */
class RequestAction extends Event
{
    private $actions = array();

    public function addAction($label, $action, $params = array())
    {
        $this->actions[] = array(
            'label'  => $label,
            'action' => $action,
            'params' => $params,
        );
    }

    public function getActions()
    {
        return $this->actions;
    }
}
