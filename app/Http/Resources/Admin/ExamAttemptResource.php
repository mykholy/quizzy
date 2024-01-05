<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\AttemptAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamAttemptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data=parent::toArray($request);
        $data['number_correct_answer']=AttemptAnswer::where(['exam_attempt_id' => $this->id, 'is_correct' => 1, 'student_id' => auth('api-student')->id()])->count();
        $data['number_wrong_answer']=AttemptAnswer::where(['exam_attempt_id' => $this->id, 'is_correct' => 0, 'student_id' => auth('api-student')->id()])->count();
        return $data;
    }
}
