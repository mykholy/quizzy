<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Ad extends Model
{
    use HasFactory;
    public $table = 'ads';

    public $fillable = [
        'title',
        'photo',
        'is_active'
    ];

    protected $casts = [
        'title' => 'string',
        'photo' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'nullable'
    ];

    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

}
