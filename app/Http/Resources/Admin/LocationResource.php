<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Client;
use App\Models\Admin\Connector;
use App\Models\Admin\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Client::find(auth('api-client')->id());
        $location = Location::with('favoriters')->find($this->id);
        $is_favorite = $user ? $user->hasFavorited($location) : false;
        $connectors=collect($this->stations)->pluck('outlets')->toArray();
        $connectors_api=[];
        $photos = $this->photos ? json_decode($this->photos) : [];
        foreach ($photos as $index => $photo)
            $photos[$index] = asset($photo);

        foreach ($connectors as $connector){
            $connectors_array=json_decode($connector,true);
            foreach ($connectors_array as $connector_array) {
                $connector_array['connector'] = Connector::find($connector_array['connector_id']);
                $connectors_api[] = $connector_array;
            }
        }


        return [
            'id' => $this->id,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'description' => $this->description,
            'main_photo' => $photos?collect($photos)->first():null,
            'photos' => $photos,
            'score' => empty($this->score) ? null : $this->score,
            'cost' => $this->cost,
            'cost_description' => $this->cost_description,
            'access' => $this->access,
            'icon' => $this->icon,
            'icon_type' => $this->icon_type,
            'phone' => $this->phone,
            'address' => $this->address,
            'pwps_version' => $this->pwps_version,
            'qr_enabled' => $this->qr_enabled,
            'poi_name' => $this->poi_name,
            'parking_type_name' => $this->parking_type_name,
            'locale' => $this->locale,
            'opening_date' => $this->opening_date,
            'hours' => empty($this->hours) ? null : $this->hours,
            'open247' => $this->open247,
            'favorites_count' => $location->favoriters->count(),
            'is_favorite' => $is_favorite,
            'coming_soon' => $this->coming_soon,
            'under_repair' => $this->under_repair,
            'access_restrictions' => $this->access_restrictions,
            'parking_attributes' => $this->parking_attributes,
            'parking_level' => $this->parking_level,
            'overhead_clearance_meters' => $this->overhead_clearance_meters,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'plugshare_location_id' => $this->plugshare_location_id,
            'outlet_count' => collect($this->stations)->pluck('outlets')->count(),
            'connectors' => $connectors_api,

            'stations' => $this->whenLoaded('stations', StationResource::collection($this->stations)),
            'amenities' => $this->whenLoaded('amenities', AmenityResource::collection($this->amenities)),

        ];
    }
}
