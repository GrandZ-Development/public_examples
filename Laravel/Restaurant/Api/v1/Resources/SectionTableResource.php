<?php

namespace App\Modules\Restaurant\Api\v1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionTableResource extends JsonResource
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
            'section_id' => $this->section_id,
            'name' => $this->name,
            'type'      => $this->type,
            'position'=> $this->position,
            'seats'=> TableSeatResource::collection($this->seats),
            'can_merge' => $this->can_merge,
            'reservation' => $this->getReservation()
        ];
    }
    private function getReservation()
    {
        $reservation = $this->open_reservation;
        $data = null;
        if ($reservation)
        {
            $data['id'] = $reservation->id;
            $data['opened_by'] = $reservation->opened_by;
            $data['no_of_seats'] = $reservation->no_of_seats;
            $data['table_id'] = $reservation->table_id;
            $data['is_open'] = $reservation->is_open;
            $data['opened_at'] = $reservation->created_at->toDateTimeString();
        }
        return $data;
    }
}
