<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Connector extends Model
{
    use HasFactory;    public $table = 'connectors';

    public $fillable = [
        'name',
        'description',
        'power',
        'kilowatts',
        'photo',
        'plugshar_connector_id',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'power' => 'string',
        'kilowatts' => 'string',
        'photo' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'nullable',
        'description' => 'nullable',
        'power' => 'nullable',
        'kilowatts' => 'nullable'
    ];

    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
