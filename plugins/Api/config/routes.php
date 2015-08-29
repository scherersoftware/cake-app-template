<?php
use Cake\Routing\Router;

Router::plugin('Api', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
