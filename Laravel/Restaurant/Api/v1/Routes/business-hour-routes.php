<?php
use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/business-hour',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'BusinessHoursControllers@createHour');
        $api->get('/list', 'BusinessHoursControllers@listHours');
        $api->post('/update', 'BusinessHoursControllers@updateBusinessHour');
        $api->delete('/delete/{id}', 'BusinessHoursControllers@deleteHour');
    });
});
