<?php

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    public $table = "exam_attempts";
    protected $guarded = [];

    public static $rules = [
        'exam_id' => 'required|exists:exams,id',

    ];

    public function attemptAnswers()
    {
        return $this->hasMany(AttemptAnswer::class, 'exam_attempt_id');
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


}
