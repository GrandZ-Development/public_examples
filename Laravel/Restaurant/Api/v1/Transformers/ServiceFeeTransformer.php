<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\ServiceFee;
use League\Fractal\TransformerAbstract;

class ServiceFeeTransformer extends TransformerAbstract
{


    public function transform(ServiceFee $serviceFee){

        return [
          'id'      => $serviceFee->id,
          'name'    => $serviceFee->name,
          'amount'  => $serviceFee->amount
        ];
    }
}
