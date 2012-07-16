<?php

namespace Soloist\Bundle\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Soloist\Bundle\CoreBundle\Entity\Node,
    DoctrineExtensions\Taggable\Taggable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    /**
     * Show similars elements
     *
     * @param  Taggable $node
     * @return Respons
     */
    public function showSimilarAction(Taggable $node)
    {
        if (!$node instanceof Taggable) {
            throw new InvalidArgumentException('Sorry ! I need tags to search similar content. Therefore your element must implements "DoctrineExtensions\Taggable\Taggable".');
        }
        $type = $node->getType();

        if ($type != 'page') {
            throw new InvalidArgumentException('Sorry ! This node is currently not supported.');
        }

        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadOrCreateTags($node);

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('SoloistCoreBundle:Node');

        $similarElements = $repo->getSimilarResults($node);

        return $this->render('SoloistCoreBundle:Navigation:Similar/'. $type . '.html.twig', array(
            'nodes' => $similarElements
        ));
    }
}
