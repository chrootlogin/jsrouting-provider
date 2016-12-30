<?php

namespace rootLogin\JSRoutingProvider\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use rootLogin\JSRoutingProvider\Command\DumpJSCommand;
use rootLogin\JSRoutingProvider\Command\DumpRouterCommand;
use Silex\Api\BootableProviderInterface;
use Silex\Application;

class SilexJSRoutingServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        foreach ($this->getDefaults() as $key => $value) {
            if (!isset($app[$key])) {
                $app[$key] = $value;
            }
        }

        $app->mount($app['jsrouting.base_url'], new SilexJSRoutingControllerProvider());
    }

    public function boot(Application $app)
    {
        if(isset($app['console'])) {
            $console = $app['console'];
            if(get_class($console) == "Saxulum\Console\Console\ConsoleApplication") {
                /** @var \Saxulum\Console\Console\ConsoleApplication $console */
                $console->add(new DumpJSCommand());
                $console->add(new DumpRouterCommand());
            }
        }
    }

    public function getDefaults() {
        return array(
            "jsrouting.base_url" => "/",
            "jsrouting.exposed_routes" => array(),
        );
    }
}
