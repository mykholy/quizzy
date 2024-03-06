<?php

namespace App\Models\Admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Musonza\Chat\Traits\Messageable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends  Authenticatable  implements JWTSubject , MustVerifyEmail
{
    use HasFactory;
    use Messageable;
    use Notifiable;

    public $table = 'students';

    public $fillable = [
        'name',
        'username',
        'location_area',
        'email',
        'phone',
        'password',
        'photo',
        'provider_id',
        'provider_type',
        'governorate',
        'area',
        'residence_area',
        'specialization',
        'academic_year_id',
        'date_of_birth',
        'device_token',
        'phone_verified',
        'balance',
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
        'balance' => 'integer',
        'is_active' => 'boolean',
        'phone_verified' => 'boolean'
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
    public function academicYear(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\AcademicYear::class, 'academic_year_id', 'id');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
