<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'description' => $this->description,
            'photo' => $this->photo,
            'conversation_id' => $this->conversation_id,
            'image_dimensions' => getImageDimensions($this->photo),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
