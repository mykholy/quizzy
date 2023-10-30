<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    public $table = 'answers';

    public $fillable = [
        'title',
        'question_type',
        'answer_two_gap_match',
        'answer_view_format',
        'answer_order',
        'answer_settings',
        'photo',
        'question_id',
        'is_correct'
    ];

    protected $casts = [
        'title' => 'string',
        'question_type' => 'string',
        'answer_two_gap_match' => 'string',
        'answer_view_format' => 'string',
        'answer_order' => 'integer',
        'answer_settings' => 'string',
        'photo' => 'string',
        'is_correct' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'required',
        'answer_view_format' => 'in:text,image,text_image',
        'photo' => 'required_if:answer_view_format,image,text_image'

    ];

    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Question::class, 'question_id', 'id');
    }
    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    static function checkQuestionsTypeCanAddManyAnswers($type)
    {

        switch ($type) {
            case Question::$QUESTION_TYPE_TRUE_FALSE :
                return false;
                break;
            default:
                return true;
        }
    }

    static function getAllAnswerViewFormat()
    {
        return [
            'text' => __('models/answers.text'),
            'image' => __('models/answers.image'),
            'text_image' => __('models/answers.text_image'),

        ];
    }
}
