<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\Side;
use League\Fractal\TransformerAbstract;

class SideTransformer extends TransformerAbstract
{


    public function transform(Side $side){

        return [
           'id'             => $side->id,
            'name'          => $side->name,
            'sku'           => $side->sku,
            'description'   => $side->description,
            'availability'  => explode(',', $side->availability),
            'price'         => $side->price,
            'image'     => ($side->image && file_exists(storage_path('app/public/'.$side->image)))?url('storage/'.$side->image):null,
            'additional_fees' =>  $side->additional_fees,
            'ingredients'     =>  $side->ingredients,

        ];
    }
}
