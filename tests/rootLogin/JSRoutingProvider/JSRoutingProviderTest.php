<?php

namespace rootLogin\Tests\JSRoutingProvider;

use Silex\Application;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use rootLogin\JSRoutingProvider\JSRoutingProvider;

class JSRoutingProviderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Silex\Application
	 */
	protected $app;

	/**
	 * @var array
	 */
	protected $expectedRouteResult = array(
		"routeA" => array(
			"host" => "",
			"path" => "/router.js",
			"schemes" => array(),
			"requirements" => array(
				"_method" => "GET"
			),
			"condition" => ""
		),
		"routeB" => array(
			"host" => "",
			"path" => "/user/{id}",
			"schemes" => array(),
			"requirements" => array(
				"_method" => "GET|POST"
			),
			"condition" => ""
		)
	);

	protected $jsPath;
	
	public function __construct()
	{
		$this->jsPath = __DIR__ . "/../../../src/rootLogin/JSRoutingProvider/Resources/js/routing.js";

		// Build Sample Application
		$this->app = new Application();
		/** @var RouteCollection $routeCollection */
		$routeCollection = $this->app['routes'];
		
		$routeA = new Route("/router.js");
		$routeA->setMethods("GET");
		$routeA->setRequirement("_method", "GET");
		$routeA->setOption("expose", true);
		$routeCollection->add("routeA", $routeA);
		
		$routeB = new Route("/user/{id}");
		$routeB->setMethods(array("GET","POST"));
		$routeB->setRequirement("_method", "GET|POST");
		$routeB->setOption("expose", true);
		$routeCollection->add("routeB", $routeB);
	}
	
	public function testGetJavaScript()
	{
		$jsrp = new JSRoutingProvider($this->app);
		
		$this->assertEquals(
			$jsrp->getJavaScript(), 
			file_get_contents($this->jsPath)
		);
	}
	
	public function testGetJSRoutes() 
	{
		$jsrp = new JSRoutingProvider($this->app);
		
		$res = "";
		foreach($this->expectedRouteResult as $name => $route) {
			$res .= "\nrouter.addRoute('$name', " . json_encode($route) . ");";
		}
		
		$this->assertEquals($jsrp->getJSRoutes(), $res);
	}

	public function testJSwithRoutes() {
		$jsrp = new JSRoutingProvider($this->app);

		$res = file_get_contents($this->jsPath);
		foreach($this->expectedRouteResult as $name => $route) {
			$res .= "\nrouter.addRoute('$name', " . json_encode($route) . ");";
		}

		$this->assertEquals($jsrp->getJSwithRoutes(), $res);
	}
}