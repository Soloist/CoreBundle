<?php

namespace Soloist\Bundle\CoreBundle;

use Doctrine\Common\Util\Inflector;
use Soloist\Bundle\CoreBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Routing\Router as FrameworkRouter;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Router
{
    /**
     * @var FrameworkRouter
     */
    protected $router;

    /**
     * @param FrameworkRouter $router
     */
    public function __construct(FrameworkRouter $router)
    {
        $this->router = $router;
    }

    /**
     * Generate Url for given node
     *
     * @param Entity\Node $node
     * @param bool        $absolute
     *
     * @return string|null
     *
     * @throws HttpException
     */
    public function generate(Entity\Node $node, $absolute = false)
    {
        $method = Inflector::camelize('generate-for-'.$node->getType());
        if (!method_exists($this, $method)) {
            return null;
        }

        return $this->$method($node, $absolute);
    }

    /**
     * @param Entity\Page $page
     * @param bool        $absolute
     *
     * @return string
     */
    protected function generateForPage(Entity\Page $page, $absolute = false)
    {
        return $this->router->generate('soloist_show', array('slug' => $page->getSlug()), $absolute);
    }

    /**
     * @param Entity\Action $action
     * @param bool          $absolute
     *
     * @return string
     */
    protected function generateForAction(Entity\Action $action, $absolute = false)
    {
        $params = $action->getParams();
        $route = $params['route'];
        unset($params['route']);

        return $this->router->generate($route, $params, $absolute);
    }

    /**
     * @param Entity\Category $category
     * @param bool            $absolute
     *
     * @return null|string
     */
    public function generateForCategory(Entity\Category $category, $absolute = false)
    {
        if (0 < count($category->getChildren())) {
            return $this->generate($category->getChildren()->first(), $absolute);
        }

        return null;
    }
}
