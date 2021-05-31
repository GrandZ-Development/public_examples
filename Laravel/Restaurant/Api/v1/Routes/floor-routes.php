<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/floor',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
//        $api->post('/create', 'FloorController@createFloor');
        $api->put('/store', 'FloorController@store');
        $api->get('/list', 'FloorController@listFloors');

//        $api->post('/update', 'FloorController@updateFloor');
        $api->delete('/delete/{id}', 'FloorController@deleteFloor');


        $api->get('/plan', 'FloorController@getFloorPlan'); // Server Portal,


    });
});
