<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/image',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'ImageController@createImage');
        $api->get('/list', 'ImageController@listImages');
        $api->post('/update', 'ImageController@updateImage');
        $api->delete('/delete/{id}', 'ImageController@deleteImage');
    });
});
