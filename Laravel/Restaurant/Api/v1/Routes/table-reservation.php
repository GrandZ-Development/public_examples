<?php
use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/table-reservation',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'TableReservationController@create');
        $api->get('/{id}', 'TableReservationController@show');
    });
});