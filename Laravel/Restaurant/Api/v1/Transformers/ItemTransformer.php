<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\Item;
use League\Fractal\TransformerAbstract;

class ItemTransformer extends TransformerAbstract
{


    public function transform(Item $item){

        return [
            'id'            => $item->id,
            'type'          => $item->type,
            'category_id'   => $item->category_id,
            'category'      => $item->category,
            'name'          => $item->name,
            'sku'           => $item->sku,
            'description'   => $item->description,
            'availability'  => explode(',', $item->availability),
            'has_price'         => $item->has_price,
            'price'         => round($item->price, 2),
            'take_out_price'         => round($item->take_out_price ,2),
            'delivery_price'         => round($item->delivery_price, 2),
            'image'     => ($item->image && file_exists(storage_path('app/public/'.$item->image)))?url('storage/'.$item->image):null,
            'additional_fees' =>  $item->additional_fees,
            'ingredients'     =>  $item->ingredients,
            'toppings'        =>  $item->toppings,
            'choices' =>  $item->multiple_choices,
            'upsells' => $item->upsells,
            'sides'   => $item->sides,
            'status'  => $item->status ?? null,
            'out_of_stock'  => $item->out_of_stock == 1 ? true : false,

        ];
    }
}
