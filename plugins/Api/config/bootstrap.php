<?php
ini_set('always_populate_raw_post_data', 1);
if (substr(env('REQUEST_URI'), 0, 5) === '/api/') {
    $errorHandler = new \CkTools\Error\ApiErrorHandler([
        'exceptionRenderer' => '\CkTools\Error\ApiExceptionRenderer'
    ]);
    $errorHandler->register();
}
