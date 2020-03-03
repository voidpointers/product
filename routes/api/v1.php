<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    // 'middleware' => 'api.auth'
], function ($api) {
    $api->group([
        'namespace' => 'Api\Product\V1\Controllers',
    ], function ($api) {
        $api->get('listings/{shop_id}', 'ListingsController@index');
        $api->get('listings/{shop_id}/pull', 'ListingsController@pull');
        $api->get('listings/{shop_id}', 'ListingsController@product');
        // $api->resource('listings', 'ListingsController');
    });
});
