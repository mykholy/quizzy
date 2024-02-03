<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Unit extends Model
{
    use HasFactory;
    public $table = 'units';

    public $fillable = [
        'name',
        'description',
        'photo',
        'book_id',
        'semester',
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
    public function lessons(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(\App\Models\Admin\Lesson::class, 'unit_id');
    }


    public function book(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Book::class, 'book_id', 'id');
    }
}
