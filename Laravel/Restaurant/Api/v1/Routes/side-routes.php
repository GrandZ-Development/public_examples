<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/side',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'SideController@createSide');
        $api->get('/list', 'SideController@listSides');
        $api->get('/{id}', 'SideController@getSide');
        $api->post('/update', 'SideController@updateSide');
        $api->delete('/delete/{id}', 'SideController@deleteSide');
    });
});
