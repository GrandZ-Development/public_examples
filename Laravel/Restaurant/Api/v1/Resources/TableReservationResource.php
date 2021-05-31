<?php

namespace App\Modules\Restaurant\Api\v1\Resources;

use App\Modules\Order\Api\v1\Resources\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TableReservationResource extends JsonResource
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
            'id' => $this->id,
            'opened_by' => $this->opened_by,
            'no_of_seats' => $this->no_of_seats,
            'table_id' => $this->table_id,
            'is_open' => $this->is_open,
            'opened_at' => $this->created_at->toDateTimeString(),
            'order' => new OrderResource($this->order)
        ];
    }
}
