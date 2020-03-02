<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    // 'middleware' => 'api.auth'
], function ($api) {
    $api->group([
        'namespace' => 'Api\Product\V1\Controllers',
        'prefix' => 'products',
    ], function ($api) {
        $api->resource('products', 'ProductsController');
    });
});
