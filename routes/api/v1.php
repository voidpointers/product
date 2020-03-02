<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'middleware' => 'api.auth'
], function ($api) {
    $api->group([
        'namespace' => 'Api\Shop\V1\Controllers',
        'prefix' => 'systems',
    ], function ($api) {
        $api->resource('shop', 'ShopsController');
    });
});

$api->version('v1', [], function ($api) {
    $api->group([
        'namespace' => 'Api\Auth\V1\Controllers',
        'prefix' => 'socialites',
    ], function ($api) {
        $api->get('auth/{provider}', 'AuthController@redirectToProvider');
    });
});

