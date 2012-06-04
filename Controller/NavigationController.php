<?php

namespace Soloist\Bundle\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller
{
    /**
     * @Template()
     * @return array
     */
    public function showAction()
    {
        return array('nodes' => $this->getDoctrine()->getRepository('SoloistCoreBundle:Node')->getRootNodes());
    }
}
