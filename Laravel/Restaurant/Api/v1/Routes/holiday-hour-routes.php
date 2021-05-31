<?php
use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/holiday-hour',
//        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/day/create', 'HolidayHoursControllers@createDay');
        $api->post('/day/update', 'HolidayHoursControllers@updateHours');
        $api->get('/day/list', 'HolidayHoursControllers@listDays');
        $api->post('/day/delete', 'HolidayHoursControllers@deleteDay');
        $api->post('/day/update-status', 'HolidayHoursControllers@updateStatus');
    });
});
