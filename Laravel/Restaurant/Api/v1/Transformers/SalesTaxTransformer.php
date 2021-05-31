<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\SalesTax;
use League\Fractal\TransformerAbstract;

class SalesTaxTransformer extends TransformerAbstract
{


    public function transform(SalesTax $salesTax){

        return [
           'id'     => $salesTax->id,
           'name'   => $salesTax->name,
           'tax'    => $salesTax->tax
        ];

    }
}
