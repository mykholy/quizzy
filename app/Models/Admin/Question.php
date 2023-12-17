<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    public $table = 'questions';
    protected $with=['answers'];
    public static $QUESTION_TYPE_SINGLE_CHOICE = "single_choice";
    public static $QUESTION_TYPE_MULTIPLE_CHOICE = "multiple_choice";
    public static $QUESTION_TYPE_TRUE_FALSE = "true_false";
    public static $QUESTION_TYPE_SHORT_ANSWER = "short_answer";
    public static $QUESTION_TYPE_LONG_ANSWER = "long_answer";
    public static $QUESTION_TYPE_COMPARE = "compare";

    public $fillable = [
        'name',
        'type',
        'description',
        'photo',
        'file',
        'level',
//        'semester',
        'points',
        'lesson_id',
//        'academic_year_id',
        'time',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'level' => 'string',
        'description' => 'string',
        'photo' => 'string',
        'file' => 'string',
        'points' => 'decimal:2',
        'time' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'nullable',
        'description' => 'nullable',
        'points' => 'min:0'
    ];

    public function lesson(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Lesson::class, 'lesson_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }


    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getFileAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    static function getQuestionType($type)
    {
        return trans('models/questions.type.' . $type);
    }

    static function checkQuestionsTypeHaveAnswers($type)
    {

        switch ($type) {
//            case self::$QUESTION_TYPE_SHORT_ANSWER:
//                return false;
//                break;
            default:
                return true;
        }
    }

    public static function getAllTypes()
    {
        return [
            self::$QUESTION_TYPE_SINGLE_CHOICE => trans('models/questions.type.' . self::$QUESTION_TYPE_SINGLE_CHOICE),
            self::$QUESTION_TYPE_MULTIPLE_CHOICE => trans('models/questions.type.' . self::$QUESTION_TYPE_MULTIPLE_CHOICE),
            self::$QUESTION_TYPE_TRUE_FALSE => trans('models/questions.type.' . self::$QUESTION_TYPE_TRUE_FALSE),
            self::$QUESTION_TYPE_SHORT_ANSWER => trans('models/questions.type.' . self::$QUESTION_TYPE_SHORT_ANSWER),
            self::$QUESTION_TYPE_LONG_ANSWER => trans('models/questions.type.' . self::$QUESTION_TYPE_LONG_ANSWER),
            self::$QUESTION_TYPE_COMPARE => trans('models/questions.type.' . self::$QUESTION_TYPE_COMPARE),
        ];
    }

    public static function getAllLevel()
    {

        return [
            'easy' => trans('models/questions.levels.easy'),
            'medium' => trans('models/questions.levels.medium'),
            'difficult' => trans('models/questions.levels.difficult'),
        ];
    }
}
