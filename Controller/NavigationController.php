<?php

namespace Soloist\Bundle\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Soloist\Bundle\CoreBundle\Entity\Node;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller
{
    /**
     * @return Response
     */
    public function showAction()
    {
        $cache = $this->get('soloist.core.cache.tree');
        if ($cache->has()) {
            return $cache->get();
        }

        $response = $this->render(
            'SoloistCoreBundle:Navigation:show.html.twig',
            array(
                'nodes' => $this->getDoctrine()->getRepository('SoloistCoreBundle:Node')->getRootNodes()
            )
        );
        $cache->set($response);

        return $response;
    }

    /**
     * @Template()
     * @param Node|int $node
     * @param int|null $depth
     * @return array
     */
    public function showPartAction($node, $depth = null)
    {
        $repo = $this->getDoctrine()->getRepository('SoloistCoreBundle:Node');
        if (!$node instanceof Node) {
            $node = $repo->find($node);
        }

        $root = $node;
        if ($root->getLft() + 1 == $root->getRgt()) {
            $root = $node->getParent();
        }

        return array(
            'root'    => $root,
            'nodes'   => $repo->children($root),
            'current' => $node
        );
    }
}
