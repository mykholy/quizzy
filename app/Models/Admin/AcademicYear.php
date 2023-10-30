<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class AcademicYear extends Model
{
    use HasFactory;    public $table = 'academic_years';

    public $fillable = [
        'name',
        'photo',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'photo' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|min:3|max:100'
    ];
    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }


}
