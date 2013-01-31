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
     *
     * @param Node|int $node
     * @param int      $maxItems
     *
     * @return array
     */
    public function showPartAction($node, $maxItems = 10)
    {
        $repo = $this->getDoctrine()->getRepository('SoloistCoreBundle:Node');
        if (!$node instanceof Node) {
            $node = $repo->find($node);
        }

        // if node is a leaf, root will be his parent
        $root = $node;
        if ($root->getLft() + 1 == $root->getRgt()) {
            $root = $node->getParent();
        }
        $level = $root->getLevel();
        $nodes = $repo->children($root);

        // Only keep same level nodes
        $nodes = array_filter(
            $nodes,
            function(Node $node) use ($level) {
                return $level + 1 === $node->getLevel();
            }
        );

        //Limit results
        if ($node === $root) {
            $nodes = array_slice($nodes, 0, $maxItems);
        } else {
            $offset = array_search($node, $nodes);
            $before = floor(($maxItems - 1) / 2);
            $nodes = array_slice($nodes, $offset - $before > 0 ? $offset - $before : 0, $maxItems);
        }

        return array(
            'root'    => $root,
            'nodes'   => $nodes,
            'current' => $node
        );
    }
}
