<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\Seat;
use League\Fractal\TransformerAbstract;

class SeatTransformer extends TransformerAbstract
{


    public function transform(Seat $model){
        return [
            'id'        => $model->id,
            'name'      => $model->name,
            'image'     => asset($model->image),

        ];

    }
}
