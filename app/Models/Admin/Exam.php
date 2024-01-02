<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    public $table = 'exams';
    public static $EXAM_TYPE_CHOICE = "choice";
    public static $EXAM_TYPE_CHOICE_SPECIALIST = "choice_specialist";
    public static $EXAM_TYPE_RANDOMLY = "randomly";
    public static $EXAM_TYPE_AI = "ai";

    public $fillable = [
        'name',
        'type',
        'question_types',
        'level',
        'type_assessment',
        'description',
        'photo',
        'semester',
        'points',
        'time',
        'subject_id',
        'book_id',
        'unit_id',
        'lesson_id',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'question_types' => 'string',
        'level' => 'string',
        'type_assessment' => 'string',
        'description' => 'string',
        'photo' => 'string',
        'file' => 'string',
        'semester' => 'string',
        'points' => 'decimal:2',
        'time' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'nullable',
        'description' => 'nullable',
        'semester' => 'in:1,2,3,4',
        'points' => 'min:0'
    ];

    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }
    public function subject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Subject::class, 'subject_id', 'id');
    }

    public function book(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Book::class, 'book_id', 'id');
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Unit::class, 'unit_id', 'id');
    }

    public function lesson(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Lesson::class, 'lesson_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('points');
    }


    public static function getAllTypes()
    {
        return [
            self::$EXAM_TYPE_CHOICE => trans('models/exams.type.' . self::$EXAM_TYPE_CHOICE),
            self::$EXAM_TYPE_CHOICE_SPECIALIST => trans('models/exams.type.' . self::$EXAM_TYPE_CHOICE_SPECIALIST),
            self::$EXAM_TYPE_RANDOMLY => trans('models/exams.type.' . self::$EXAM_TYPE_RANDOMLY),
            self::$EXAM_TYPE_AI => trans('models/exams.type.' . self::$EXAM_TYPE_AI),
        ];
    }

    public static function getAllTypeAssessment()
    {
        return [
            'direct' => trans('models/exams.direct' ),
            'after_finish' => trans('models/exams.after_finish' ),
        ];
    }
}
