<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/section',
        'middleware'    => ['auth:api']
    ];
    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'SectionController@createSection');
        $api->put('/store', 'SectionController@store');
        $api->get('/list', 'SectionController@listSections');
        $api->post('/update', 'SectionController@updateSection');
        $api->delete('/delete/{id}', 'SectionController@deleteSection');
        $api->post('/add-table', 'SectionController@addTable');
        $api->post('/remove-table', 'SectionController@removeTable');
    });
});
