<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/service-fee',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'ServiceFeeController@createFee');
        $api->get('/list', 'ServiceFeeController@listFees');
        $api->get('/{id}', 'ServiceFeeController@getServiceFee');
        $api->post('/update', 'ServiceFeeController@updateFee');
        $api->delete('/delete/{id}', 'ServiceFeeController@deleteDelete');
    });
});
