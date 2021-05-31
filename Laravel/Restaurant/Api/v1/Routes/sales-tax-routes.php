<?php

use Dingo\Api\Routing\Router;
$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace'     => 'App\Modules\Restaurant\Api\v1\Controllers',
        'prefix'        => 'restaurant/sales-tax',
        'middleware'    => ['auth:api']
    ];

    $api->group($groupOptions, function ($api) {
        $api->post('/create', 'SalesTaxController@createSalesTax');
        $api->get('/list', 'SalesTaxController@listSalesTax');
        $api->get('/{id}', 'SalesTaxController@getSalesTax');
        $api->post('/update', 'SalesTaxController@updateSalesTax');
        $api->delete('/delete/{id}', 'SalesTaxController@deleteSalesTax');
    });
});
