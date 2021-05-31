<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/item',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'ItemController@createItem');
        $api->get('/list', 'ItemController@listItems');
        $api->get('/list-by-type/{type}', 'ItemController@listItemsByType');
        $api->get('/category/{id}', 'ItemController@listCategoryItems');
        $api->get('/{id}', 'ItemController@getItem');
        $api->post('/update', 'ItemController@updateItem');
        $api->delete('/delete/{id}', 'ItemController@deleteItem');
        $api->post('/out-of-stock/{id}', 'ItemController@outOfStock');


    });
});
