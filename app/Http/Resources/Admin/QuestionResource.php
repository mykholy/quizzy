<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'type' => $this->type,
            'description' => $this->description,
            'photo' => $this->photo,
            'semester' => $this->semester,
            'points' => $this->points,
            'time' => $this->time,
            'is_active' => $this->is_active,
            'answers' => $this->whenLoaded('answers', AnswerResource::collection($this->answers)),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
