<?php

namespace App\Models\Admin;

use App\Traits\IsActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    use IsActiveScope;
    public $table = 'books';
    protected $appends = ['full_name'];

    public $fillable = [
        'name',
        'description',
        'photo',
        'subject_id',
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

    public function subject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Subject::class, 'subject_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ( ' . optional($this->subject)->full_name. ' ) ';
    }

    public static function getSelectData()
    {
        $formattedModel = self::all()->map(function ($model) {
            return [
                'id' => $model->id,
                'name' => $model->full_name,
            ];
        })->pluck('name', 'id')->toArray();
        return $formattedModel;
    }
}
