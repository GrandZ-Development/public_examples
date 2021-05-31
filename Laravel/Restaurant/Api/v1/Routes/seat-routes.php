<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/seat',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'SeatController@createSeat');
        $api->post('/store', 'SeatController@updateOrCreate');
        $api->get('/list', 'SeatController@listSeats');
        $api->post('/update', 'SeatController@updateSeat');
        $api->delete('/delete/{id}', 'SeatController@deleteSeat');
    });
});
