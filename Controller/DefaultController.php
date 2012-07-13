<?php

namespace Soloist\Bundle\CoreBundle\Controller;

use Doctrine\Common\Util\Inflector,
    DoctrineExtensions\Taggable\Taggable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Soloist\Bundle\CoreBundle\Entity\Action,
    Soloist\Bundle\CoreBundle\Entity\Page,
    Soloist\Bundle\CoreBundle\Entity\Node;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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

    /**
     * @Template()
     * @param $page
     * @param $path_image
     * @param $description
     * @return array
     */
    public function pageShortcutAction($page, $path_image, $description)
    {
        return array(
            'page'        => $this->getDoctrine()->getRepository('SoloistCoreBundle:Page')->find($page),
            'image'       => $path_image,
            'description' => $description,
        );
    }

    /**
     * @Template()
     * @return array
     */
    public function similarContentAction($node)
    {
        if (!$node instanceof Taggable) {
            throw new InvalidArgumentException('Sorry ! I need tags to search similar content. Therefore your element must implements "DoctrineExtensions\Taggable\Taggable".')
        }
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadOrCreateTags($node);
    }
}
