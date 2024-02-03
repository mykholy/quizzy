<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\AttemptAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamAttemptMiniResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data = collect($data)->only(['subject','student_id', 'book', 'id', 'total_questions', 'total_answered_questions'])->toArray();
        return $data;
    }
}
