<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Musonza\Chat\Traits\Messageable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Teacher extends  Authenticatable  implements JWTSubject
{
    use HasFactory;
    use Messageable;
    use Notifiable;
    public $table = 'teachers';

    public $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'device_token',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'photo' => 'string',
        'device_token' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|min:3|max:100',
        'email' => 'required|email|min:3|max:255|unique:teachers',
        'password' => 'required_without:id|nullable|min:6',
        'photo' => 'required_without:id'
    ];
    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
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
