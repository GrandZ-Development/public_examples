<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/promotion',
        'middleware'    => ['auth:api']
    ];
    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'PromotionController@createPromotion');
        $api->get('/list', 'PromotionController@listPromotions');
        $api->get('/{id}', 'PromotionController@getPromotion');
        $api->post('/update', 'PromotionController@updatePromotion');
        $api->delete('/delete/{id}', 'PromotionController@deletePromotion');
    });
});
