<?php
use Cake\Routing\Router;

Router::plugin('Api/V1', ['path' => '/api/v1/'], function ($routes) {
    $routes->connect('/version', ['controller' => 'App', 'action' => 'version']);
    $routes->fallbacks('InflectedRoute');
});
