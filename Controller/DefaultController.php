<?php

namespace Soloist\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Soloist\Bundle\CoreBundle\Entity\Action,
    Soloist\Bundle\CoreBundle\Entity\Page,
    Soloist\Bundle\CoreBundle\Entity\Node;

use Doctrine\Common\Util\Inflector;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $node = $this->getDoctrine()->getEntityManager()->getRepository('SoloistCoreBundle:Node')->findRoot();

        $action = Inflector::camelize('show_'.$node->getType().'_action');
        if (method_exists($this, $action)) {
            return $this->$action($node);
        }
    }

    public function showAction(Page $page)
    {
        $template = $this->get('soloist.block.factory')->getPageTemplate($page->getPageType());

        return $this->render($template, array('page' => $page));
    }

    public function showPageAction(Page $page)
    {
        return $this->showAction($page);
    }

    public function showActionAction(Action $action)
    {
        return $this->forward($action->getAction(), $action->getParams());
    }
}
