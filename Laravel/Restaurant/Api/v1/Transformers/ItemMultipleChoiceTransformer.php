<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\ItemMultipleChoice;
use League\Fractal\TransformerAbstract;

class ItemMultipleChoiceTransformer extends TransformerAbstract
{

    public function transform(ItemMultipleChoice $itemOption){

        return [
            'id'    => $itemOption->id,
            'name' => $itemOption->name,
            'options' => json_decode($itemOption->options),
            'image'	  => ($itemOption->image && file_exists(storage_path('app/public/'.$itemOption->image)))?url('storage/'.$itemOption->image):null,
        ];
    }
}
