<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\AttemptAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopStudentExamAttemptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data = collect($data)->only(['student', 'total_marks', 'total_earned_marks'])->toArray();
        $data['is_current_student']=auth('api-student')->id();
        $data['student'] = collect($data['student'])->only(['id', 'name', 'username', 'email', 'photo'])->toArray();
//        $data['number_correct_answer']=AttemptAnswer::where(['exam_attempt_id' => $this->id, 'is_correct' => 1, 'student_id' => auth('api-student')->id()])->count();
//        $data['number_wrong_answer']=AttemptAnswer::where(['exam_attempt_id' => $this->id, 'is_correct' => 0, 'student_id' => auth('api-student')->id()])->count();
        return $data;
    }
}
