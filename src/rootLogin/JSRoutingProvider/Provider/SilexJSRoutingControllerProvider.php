<?php

namespace rootLogin\JSRoutingProvider\Provider;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Generator\UrlGenerator;

class SilexJSRoutingControllerProvider implements ControllerProviderInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    public function connect(Application $app)
    {
        $this->app = $app;

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get("/router.js", function(Application $app) {
            $res = file_get_contents(__DIR__ . "/../Resources/js/routing.js");

            foreach($this->getAllRoutes() as $name => $route) {
                $route = json_encode($route);
                $res .= "router.addRoute('$name', $route);";
            }

            return new Response($res, 200, array("Content-Type" => "text/javascript"));
        })->bind("jsrouting")->getRoute()->setOption("expose",true);

        return $controllers;
    }

    public function getAllRoutes() {
        /** @var RouteCollection $routeCollection */
        $routeCollection = $this->app['routes'];

        $routes = array();
        /** @var Route $route */
        foreach($routeCollection as $key => $route) {
            if($route->getOption("expose") || in_array($key, $this->app['jsrouting.exposed_routes'])) {
                $routes[$key] = array(
                    "host" => $route->getHost(),
                    "path" => $route->getPath(),
                    "schemes" => $route->getSchemes(),
                    "requirements" => $route->getRequirements(),
                    "condition" => $route->getCondition(),
                );
            }
        }

        return $routes;
    }
}