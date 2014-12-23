var jsdom = require('jsdom');

describe('JSRouting Router', function() {
    var router;
    beforeEach(function (done) {
        jsdom.env({
            html: '<html><body></body></html>',
            scripts: ['../../src/rootLogin/JSRoutingProvider/Resources/js/routing.js'],
            done: function (err, window) {
                if (err) console.log(err);
                router = window.router;
                done();
            }
        });
    });

    it('Should generate a simple route', function () {
        window = { location: { protocol: "http" }};

        router.addRoute("routeA", { host: "", path: "/hello", requirements: {}});

        expect(router.generate("routeA")).toBe("/hello");
    });

    it('Should generate a extended route', function () {
        window = { location: { protocol: "http" }};

        router.addRoute("routeA", { host: "", path: "/hello/{name}", requirements: {}});

        expect(router.generate("routeA", { "name": "test" })).toBe("/hello/test");
    });
});