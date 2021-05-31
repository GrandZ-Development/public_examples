<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\Promotion;
use League\Fractal\TransformerAbstract;

class PromotionTransformer extends TransformerAbstract
{


    public function transform(Promotion $promotion){

        return [
            'id'            => $promotion->id,
            'name'          => $promotion->name,
            'time_type'     => $promotion->time_type,
            'value_type'    => $promotion->value_type,
            'start_time'    => $promotion->start_time,
            'end_time'      => $promotion->end_time,
            'repeat'        => (boolean)$promotion->repeat,
            'day'           => $promotion->day,
            'start_date'    => $promotion->start_date,
            'end_date'      => $promotion->end_date,
            'value'         => $promotion->value,
            'items'         => $promotion->items
        ];
    }
}