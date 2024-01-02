<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'question_types' => $this->question_types,
            'level' => $this->level,
            'type_assessment' => $this->type_assessment,
            'description' => $this->description,
            'photo' => $this->photo,
            'file' => $this->file,
            'semester' => $this->semester,
            'subject_id' => $this->subject_id,
            'points' => $this->points,
            'time' => $this->time,
            'is_active' => $this->is_active,
            'questions' => $this->whenLoaded('questions', QuestionResource::collection($this->questions)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
