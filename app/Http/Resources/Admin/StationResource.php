<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
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
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'cost' => $this->cost,
            'cost_description' => $this->cost_description,
            'manufacturer' => $this->manufacturer,
            'model' => $this->model,
            'pwps_version' => $this->pwps_version,
            'qr_enabled' => $this->qr_enabled,
            'outlets' => json_decode($this->outlets),
            'hours' => empty($this->hours)?null: $this->hours,
            'pre_charge_instructions' => $this->pre_charge_instructions,
            'available' => $this->available,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'location_id' => $this->location_id,
            'plugshare_location_id' => $this->plugshare_location_id,
            'plugshare_station_id' => $this->plugshare_station_id,
            'location' => new LocationResource($this->whenLoaded('location')),

        ];
    }
}
