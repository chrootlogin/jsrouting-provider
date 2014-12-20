Silex JSRouting Provider
========================

The JSRouting Provider is a silex routing provider for javascript, that exposes routes to a javascript file. Then you can generate routes for use with javascript frameworks like AngularJS.

[![Build Status](https://api.travis-ci.org/chrootlogin/jsrouting-provider.png?branch=master)](https://travis-ci.org/chrootlogin/jsrouting-provider)
[![Total Downloads](https://poser.pugx.org/rootlogin/jsrouting-provider/downloads.png)](https://packagist.org/packages/rootlogin/jsrouting-provider)
[![Latest Stable Version](https://poser.pugx.org/rootlogin/jsrouting-provider/v/stable.png)](https://packagist.org/packages/rootlogin/jsrouting-provider)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chrootLogin/jsrouting-provider/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chrootLogin/jsrouting-provider/?branch=master)

Installation
------------

Register the provider in your silex application:
``` {.php}
$app->register(new rootLogin\JSRoutingProvider\Provider\SilexJSRoutingServiceProvider(), array(
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

Console
-------
If you want to use the console commands please install at least [saxulum/saxulum-console](https://github.com/saxulum/saxulum-console).
It will be automatically activated after you registered the provider.

### Available Commands

* jsrouting:dump
  This dumps the router with the known routes (buggy, ATM);
* jsrouting:dump:router.js
  This only dumps the router.js. You need to add the routes manually.
  
Run the tests
-------------
Go to the base directory of the jsrouting-provider. Do a `composer install` and enter `vendor/bin/phpunit`.

Contribution
------------
Pull request are welcome. Or if you can't or want code you can also contribute by opening a ticket if you see something is wrong.
  
Warning
-------
This project is in early development stages. No warranty if it kills your kittens or starts a nuclear war ;)
