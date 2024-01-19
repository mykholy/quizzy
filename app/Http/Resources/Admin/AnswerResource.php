<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'title' => $this->title,
            'question_type' => $this->question_type,
            'answer_two_gap_match' => $this->answer_two_gap_match,
            'answer_view_format' => $this->answer_view_format,
            'answer_order' => $this->answer_order,
            'answer_settings' => $this->answer_settings,
            'photo' => $this->photo,
            'image_dimensions' => getImageDimensions($this->photo),

            'is_correct' => $this->is_correct,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
