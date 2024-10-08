<?php

namespace App\Models\Admin;

use App\Traits\IsActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    use IsActiveScope;
    public $table = 'subjects';
    protected $appends = ['full_name'];
    public $fillable = [
        'name',
        'photo',
        'academic_year_id',
        'semester',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'photo' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|min:3|max:100',
        'semester' => 'in:1,2,3,4',
    ];

    public function academicYear(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\AcademicYear::class, 'academic_year_id', 'id');
    }

    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ( ' . optional($this->academicYear)->name . ' - ' . $this->semester . ' ) ';
    }

    public function books(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(\App\Models\Admin\Book::class, 'subject_id');
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
