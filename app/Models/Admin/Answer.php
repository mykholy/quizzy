<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Answer extends Model
{
    use HasFactory;    public $table = 'answers';

    public $fillable = [
        'title',
        'question_type',
        'answer_two_gap_match',
        'answer_view_format',
        'answer_order',
        'answer_settings',
        'photo',
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
        'title' => 'nullable',
        'answer_view_format' => 'in:1,2'
    ];

    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Question::class, 'question_id', 'id');
    }
}
