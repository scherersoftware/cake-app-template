<?php
use Cake\Routing\Router;

Router::plugin('Api/V2', ['path' => '/api/v2'], function ($routes) {
    $routes->connect('/version', ['controller' => 'App', 'action' => 'version']);
    $routes->fallbacks('DashedRoute');
});
