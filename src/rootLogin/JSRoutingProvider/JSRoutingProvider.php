<?php
/**
 * Created by PhpStorm.
 * User: simu
 * Date: 19.12.14
 * Time: 16:43
 */

namespace rootLogin\JSRoutingProvider;

use Silex\Application;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class JSRoutingProvider {
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application &$app)
    {
        $this->app = $app;
    }

    public function getJSwithRoutes() {
        $res = $this->getJavaScript() . $this->getJSRoutes();
        if (!empty($this->app['jsrouting.base_url'])) {
            $res .= "\nrouter.baseurl = '" . $this->app['jsrouting.base_url'] . "';";
        }

        return $res;
    }

    public function getJavaScript()
    {
        return file_get_contents(__DIR__ . "/Resources/js/routing.js");
    }

    public function getJSRoutes()
    {
        $res = "";
        foreach($this->getAllRoutes() as $name => $route) {
            $route = json_encode($route);
            $res .= "\nrouter.addRoute('$name', $route);";
        }

        return $res;
    }

    public function getAllRoutes()
    {
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
