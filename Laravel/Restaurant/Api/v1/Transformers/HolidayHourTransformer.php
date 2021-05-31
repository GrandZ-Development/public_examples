<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\BusinessHour;
use League\Fractal\TransformerAbstract;

class HolidayHourTransformer extends TransformerAbstract
{


    public function transform($data){

        return [
            'id' => $data->id,
            'date'    => $data->date,
            'name'    => $data->name,
            'hours'   => $data->hours,
            'closed'   => $data->closed
        ];
    }
}
