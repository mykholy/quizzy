<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Station extends Model
{
    use HasFactory;
    public $table = 'stations';

    public $fillable = [
        'name',
        'latitude',
        'longitude',
        'cost',
        'cost_description',
        'manufacturer',
        'model',
        'pwps_version',
        'qr_enabled',
        'outlets',
        'hours',
        'pre_charge_instructions',
        'available',
        'location_id',
        'plugshare_location_id',
        'plugshare_station_id'
    ];

    protected $casts = [
        'name' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
        'cost' => 'string',
        'cost_description' => 'string',
        'manufacturer' => 'string',
        'model' => 'string',
        'pwps_version' => 'string',
        'qr_enabled' => 'boolean',
        'outlets' => 'string',
        'hours' => 'string',
        'pre_charge_instructions' => 'string',
        'available' => 'string'
    ];

    public static array $rules = [
        'name' => 'nullable',
        'latitude' => 'numeric',
        'longitude' => 'numeric',
        'cost' => 'nullable',
        'cost_description' => 'nullable',
        'manufacturer' => 'nullable',
        'model' => 'nullable',
        'pwps_version' => 'nullable',
        'qr_enabled' => 'nullable',
        'outlets' => 'nullable',
        'hours' => 'nullable',
        'pre_charge_instructions' => 'nullable',
        'available' => 'nullable',
        'location_id' => 'nullable',
        'plugshare_location_id' => 'nullable',
        'plugshare_station_id' => 'nullable'
    ];

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Location::class, 'location_id', 'id');
    }
}
