<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends  Authenticatable  implements JWTSubject
{
    use HasFactory;
    use Favoriter;
    public $table = 'clients';

    public $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'car_id',
        'provider_id',
        'provider_type',
        'car_model',
        'phone',
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
        'password' => 'string',
        'photo' => 'string',
        'device_token' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|min:3|max:100',
        'email' => 'required|email|min:3|max:255|unique:users',
        'password' => 'required_without:id|nullable|min:6',
        'photo' => 'nullable'
    ];
    public function car(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Car::class,'car_id');
    }
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
