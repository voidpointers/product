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
        $api->get('listings/category', 'ListingsController@category');

        $api->get('product/update_title', 'ProductController@update_title');
        $api->get('product/update_desc', 'ProductController@update_desc');
        $api->get('product/update_tags', 'ProductController@update_tags');
        // $api->resource('listings', 'ListingsController');
    });
});
