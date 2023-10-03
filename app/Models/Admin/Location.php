<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Location extends Model
{
    use Searchable;
    use HasFactory;
    use Favoriteable;
    public $table = 'locations';

    public $fillable = [
        'name',
        'latitude',
        'longitude',
        'description',
        'photos',
        'score',
        'cost',
        'cost_description',
        'access',
        'icon',
        'icon_type',
        'phone',
        'address',
        'pwps_version',
        'qr_enabled',
        'poi_name',
        'parking_type_name',
        'locale',
        'opening_date',
        'hours',
        'open247',
        'coming_soon',
        'under_repair',
        'access_restrictions',
        'parking_attributes',
        'parking_level',
        'overhead_clearance_meters',
        'is_active',
        'plugshare_location_id'
    ];

    protected $casts = [
        'name' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
        'description' => 'string',
        'score' => 'string',
        'cost' => 'boolean',
        'cost_description' => 'string',
        'access' => 'integer',
        'icon' => 'string',
        'icon_type' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'pwps_version' => 'string',
        'qr_enabled' => 'boolean',
        'poi_name' => 'string',
        'parking_type_name' => 'string',
        'locale' => 'string',
        'opening_date' => 'date',
        'hours' => 'string',
        'open247' => 'boolean',
        'coming_soon' => 'boolean',
        'under_repair' => 'boolean',
//        'access_restrictions' => 'string',
//        'parking_attributes' => 'string',
        'parking_level' => 'string',
        'overhead_clearance_meters' => 'string'
    ];

    public static array $rules = [
        'name' => 'nullable',
        'latitude' => 'numeric',
        'longitude' => 'numeric',
        'description' => 'nullable',
        'photos' => 'nullable',
        'score' => 'nullable',
        'cost' => 'nullable',
        'cost_description' => 'nullable',
        'access' => 'nullable',
        'icon' => 'nullable',
        'icon_type' => 'nullable',
        'phone' => 'nullable',
        'address' => 'nullable',
        'pwps_version' => 'nullable',
        'qr_enabled' => 'nullable',
        'poi_name' => 'nullable',
        'parking_type_name' => 'nullable',
        'locale' => 'nullable',
        'opening_date' => 'nullable',
        'hours' => 'nullable',
        'open247' => 'nullable',
        'coming_soon' => 'nullable',
        'under_repair' => 'nullable',
        'access_restrictions' => 'nullable',
        'parking_attributes' => 'nullable',
        'parking_level' => 'nullable',
        'overhead_clearance_meters' => 'nullable',
        'plugshare_location_id' => 'nullable'
    ];

    public function amenities(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Admin\Amenity::class);
    }
    public function stations(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(\App\Models\Admin\Station::class,'location_id');
    }
    public function getIconAttribute($value)
    {
        return $value ? asset($value) : null;
    }
    public function getPhotos(){
        $photos=[];
        foreach ($this->photos as $index => $photo)
            $photos[$index] = asset($photo);

        return $photos;
    }

    public function update_stations($location,$data){
        foreach ($data['stations'] as $station){
            $station['location_id']=$location->id;
            $station['latitude']=$location->latitude;
            $station['longitude']=$location->longitude;
            $station['qr_enabled']=$station['qr_enabled']??0;
            $station['plugshare_location_id']=$location->plugshare_location_id;
            $station['plugshare_station_id']=$station['id'];
            foreach ($station['outlets'] as $index=>$outlet){
                $station['outlets'][$index]['connector_id']=$outlet['connector'];
            }
            $station['outlets']=json_encode($station['outlets']);
            Station::updateOrCreate([
                'plugshare_station_id' =>$station['id'],
            ], $station);
        }

    }

    public function favoriters(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            config('auth.providers.clients.model'),
            config('favorite.favorites_table'),
            'favoriteable_id',
            config('favorite.user_foreign_key')
        )
            ->where('favoriteable_type', $this->getMorphClass());
    }

    public function hasBeenFavoritedBy(\Illuminate\Database\Eloquent\Model $user): bool
    {
        if (\is_a($user, config('auth.providers.clients.model'))) {
            if ($this->relationLoaded('favoriters')) {
                return $this->favoriters->contains($user);
            }

            return ($this->relationLoaded('favorites') ? $this->favorites : $this->favorites())
                    ->where(\config('favorite.user_foreign_key'), $user->getKey())->count() > 0;
        }

        return false;
    }

//    public function toSearchableArray()
//    {
//        $array = $this->with('relations')->toArray();
//
//
//        return $array;
//    }
}
