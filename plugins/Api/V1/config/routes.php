<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin('Api/V1', ['path' => '/api'], function (RouteBuilder $routes) {
    $routes->fallbacks(DashedRoute::class);
});
Router::plugin('Api/V1', ['path' => '/api/v1'], function (RouteBuilder $routes) {
    $routes->fallbacks(DashedRoute::class);
});
