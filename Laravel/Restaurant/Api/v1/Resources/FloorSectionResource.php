<?php

namespace App\Modules\Restaurant\Api\v1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FloorSectionResource extends JsonResource
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
            'name' => $this->name,
            'floor_id' => $this->floor_id,
            'tables' => SectionTableResource::collection($this->tables)
        ];
    }
}
