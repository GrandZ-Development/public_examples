<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/table',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'TableController@createTable');
        $api->get('/list', 'TableController@listTables');
        $api->put('/store', 'TableController@store');
        $api->post('/update', 'TableController@updateTable');
        $api->delete('/delete/{id}', 'TableController@deleteTable');
    });
});
