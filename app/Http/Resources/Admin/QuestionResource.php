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
            'level' => $this->level,
            'description' => $this->description,
            'photo' => $this->photo,
            'file' => $this->file,
            'file_type' => checkFileType($this->file),
            'points' => $this->points,
            'time' => $this->time,
            'reference' => $this->reference,
            'lesson_id' => $this->lesson_id,
            'is_active' => $this->is_active,
            'answers' => $this->whenLoaded('answers', AnswerResource::collection($this->answers)),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
