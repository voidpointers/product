<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    // 'middleware' => 'api.auth'
], function ($api) {
    $api->group([
        'namespace' => 'Api\Product\V1\Controllers',
    ], function ($api) {
        $api->get('listings', 'ListingsController@index');
        $api->get('listings/pull', 'ListingsController@pull');
        $api->get('listings/detail', 'ListingsController@detail');
        $api->post('listings', 'ListingsController@update');
    });
});
