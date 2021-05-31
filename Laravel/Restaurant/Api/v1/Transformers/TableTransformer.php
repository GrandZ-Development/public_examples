<?php


namespace App\Modules\Restaurant\Api\v1\Transformers;


use App\Modules\Restaurant\Models\Table;
use League\Fractal\TransformerAbstract;

class TableTransformer extends TransformerAbstract
{


    public function transform(Table $table){
        return [
            'id'        => $table->id,
            'section_id'        => $table->section_id,
            'name'      => $table->name,
            'type'      => $table->type,
//            'no_of_seats' => $table->no_of_seats,
            'position'=> $table->position,
            'seats'=> $table->seats,
            'can_merge'   => (boolean) $table->can_merge,


        ];

    }
}
