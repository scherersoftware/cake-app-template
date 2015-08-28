<?php
use Cake\Routing\Router;

Router::plugin('Admin', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
