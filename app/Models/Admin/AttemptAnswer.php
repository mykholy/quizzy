<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttemptAnswer extends Model
{
    use HasFactory;

    public $table = "attempt_answers";
    protected $guarded = [];

    public static $rules = [
        'exam_attempt_id' => 'required|exists:exam_attempts,id',
        'question_id' => 'required|exists:questions,id',
        'given_answer' => 'nullable',
    ];
    protected $casts = [
        'question_mark' => 'string',
        'achieved_mark' => 'string',
        'minus_mark' => 'string',
        'time_spent' => 'integer',
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function examAttempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id', 'id');
    }


}
