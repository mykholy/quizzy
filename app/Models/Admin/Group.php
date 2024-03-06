<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Musonza\Chat\Traits\Messageable;

class Group extends Model
{
    use HasFactory;
    use Messageable;
    public $table = 'groups';

    public $fillable = [
        'name',
        'description',
        'subject_id',
        'teacher_id',
        'conversation_id',
        'photo'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'photo' => 'string'
    ];

    public static array $rules = [
        'name' => 'nullable',
        'description' => 'nullable'
    ];

    public function subject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Subject::class, 'subject_id', 'id');
    }

    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Teacher::class, 'teacher_id', 'id');
    }

    public function students(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Admin\Student::class,"student_group");
    }

    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
