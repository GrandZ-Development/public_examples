<?php

namespace App\Modules\Restaurant\Api\v1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'type'          => $this->type,
            'name'          => $this->name,
            'description'   => $this->description,
            'has_price'         => $this->has_price,
            'price'         => $this->price,
            'take_out_price'         => $this->take_out_price,
            'delivery_price'         => $this->delivery_price,
            'image'     => ($this->image && file_exists(storage_path('app/public/'.$this->image)))?url('storage/'.$this->image):null,
            'additional_fees' =>  $this->additional_fees,
            'ingredients'     =>  $this->ingredients,
            'toppings'        =>  $this->toppings,
            'choices' =>  $this->multiple_choices,
            'upsells' => $this->upsells,
            'sides'   => $this->sides,
            'status'  => $this->status ?? null,
            'out_of_stock'  => $this->out_of_stock == 1 ? true : false,
        ];
    }
}
