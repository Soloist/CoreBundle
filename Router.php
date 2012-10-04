<?php

namespace Soloist\Bundle\CoreBundle;

use Doctrine\Common\Util\Inflector;

use Soloist\Bundle\CoreBundle\Entity;

use Symfony\Component\HttpKernel\Exception\HttpException,
    Symfony\Bundle\FrameworkBundle\Routing\Router as FrameworkRouter;

class Router
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(FrameworkRouter $router)
    {
        $this->router = $router;
    }

    /**
     * Generate Url for given node
     *
     * @param $name
     * @param Entity\Node $node
     * @param bool $absolute
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function generate(Entity\Node $node, $absolute = false)
    {
        $method = Inflector::camelize('generate-for-'.$node->getType());
        if (!method_exists($this, $method)) {
            return null;
        }

        return $this->$method($node, $absolute);
    }

    protected function generateForPage(Entity\Page $page, $absolute = false)
    {
        return $this->router->generate('soloist_show', array('slug' => $page->getSlug()), $absolute);
    }

    protected function generateForAction(Entity\Action $action, $absolute = false)
    {
        $params = $action->getParams();
        $route = $params['route'];
        unset($params['route']);

        return $this->router->generate($route, $params, $absolute);
    }


}
