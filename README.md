Silex JSRouting Provider
========================

The JSRouting Provider is a silex routing provider for javascript, that exposes routes to a javascript file. Then you can generate routes for use with javascript frameworks like AngularJS.

Installation
------------

Register the provider in your silex application:
``` {.php}
$app->register(new rootLogin\JSRoutingProvider\Provider\SilexJSRoutingProvider(), array(
  "jsrouting.base_url" => "/",
  "jsrouting.exposed_routes" => array("routeA", "routeB")
  ));
```

Include and use it in your frontend like this.
``` {.html}
<script src="{{ path("jsrouting") }}"></script>
<script>
  console.log(router.generate("routeA"));
  console.log(router.generate("routeB", {id: 3}));
</script>
```

Warning
-------
This project is in early development stages. No warranty if it kills your kittens or starts a nuclear war ;)
