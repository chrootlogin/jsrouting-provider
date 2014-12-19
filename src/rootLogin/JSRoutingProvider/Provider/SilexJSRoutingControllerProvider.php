<?php

namespace rootLogin\JSRoutingProvider\Provider;

use rootLogin\JSRoutingProvider\JSRoutingProvider;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SilexJSRoutingControllerProvider implements ControllerProviderInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var JSRoutingProvider
     */
    private $jsrp;

    public function connect(Application $app)
    {
        $this->app = $app;
        $this->jsrp = new JSRoutingProvider($app);

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get("/router.js", function(Application $app) {
            return new Response($this->jsrp->getJSwithRoutes(), 200, array("Content-Type" => "text/javascript"));
        })->bind("jsrouting")->getRoute()->setOption("expose",true);

        return $controllers;
    }
}