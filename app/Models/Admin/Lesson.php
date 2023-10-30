<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Lesson extends Model
{
    use HasFactory;    public $table = 'lessons';

    public $fillable = [
        'name',
        'description',
        'photo',
        'unit_id',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'photo' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'nullable',
        'description' => 'nullable'
    ];
    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Unit::class, 'unit_id', 'id');
    }
}
