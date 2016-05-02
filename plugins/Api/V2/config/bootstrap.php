<?php
use Cake\Core\Configure;
use Cake\Utility\Hash;

ini_set('always_populate_raw_post_data', 1);
if (substr(env('REQUEST_URI'), 0, 5) === '/api/v2/') {
    $errorHandler = new \CakeApiBaselayer\Error\ApiErrorHandler([
        'exceptionRenderer' => '\CakeApiBaselayer\Error\ApiExceptionRenderer'
    ]);
    $errorHandler->register();
}

// Load and merge default with app config
$config = require 'config.php';
if (Configure::check('Api.V2')) {
    $config = Hash::merge(Configure::read('Api.V2'), $config);
}
Configure::write('Api.V2', $config);
