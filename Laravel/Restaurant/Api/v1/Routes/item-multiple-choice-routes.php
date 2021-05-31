<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/item-multiple-choice',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'ItemMultipleChoiceController@createMultipleChoice');
        $api->get('/list', 'ItemMultipleChoiceController@listMultipleChoices');
        $api->post('/update', 'ItemMultipleChoiceController@updateMultipleChoice');
        $api->delete('/delete/{id}', 'ItemMultipleChoiceController@deleteMultipleChoice');
    });
});
