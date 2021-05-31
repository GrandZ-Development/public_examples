<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\BusinessHour;
use League\Fractal\TransformerAbstract;

class BusinessHourTransformer extends TransformerAbstract
{


    public function transform(BusinessHour $businessHour){

        return [
            'id'    => $businessHour->id,
            'day'   => $businessHour->day,
            'start_time'    => $businessHour->start_time,
            'end_time'      => $businessHour->end_time,
            'closed'        => (boolean)$businessHour->closed
        ];
    }
}
