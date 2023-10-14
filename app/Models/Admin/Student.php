<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Student extends Model
{
    use HasFactory;    public $table = 'students';

    public $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'photo',
        'provider_id',
        'provider_type',
        'device_token',
        'is_active'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'photo' => 'string',
        'provider_id' => 'string',
        'provider_type' => 'string',
        'device_token' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|min:3|max:100',
        'email' => 'nullable|email|min:3|max:255|unique:students',
        'phone' => 'nullable|min:6|max:20|unique:students',
        'password' => 'required_without:id|nullable|min:6',
        'photo' => 'required_without:id'
    ];

    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

}
