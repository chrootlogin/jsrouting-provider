<?php

namespace rootLogin\JSRoutingProvider\Provider;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Parser as YamlParser;

class SilexJSRoutingProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        foreach ($this->getDefaults() as $key => $value) {
            if (!isset($app[$key])) {
                $app[$key] = $value;
            }
        }

        $app->mount($app['jsrouting.base_url'], new SilexJSRoutingControllerProvider());
    }

    public function boot(Application $app) {}

    public function getDefaults() {
        return array(
            "jsrouting.base_url" => "/",
            "jsrouting.exposed_routes" => array(),
        );
    }
}