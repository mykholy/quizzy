<?php

namespace Database\Seeders;

use App\Models\Admin\Amenity;
use Illuminate\Database\Seeder;

class AmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $list = [
            'Lodging',
            'Dining',
            'Restrooms',
            'EV Parking',
            'Valet Parking',
            'Park',
            'WiFi',
            'Shopping',
            'Grocery',
        ];
        foreach ($list as $item) {
            Amenity::updateOrCreate([
                'name' => $item,
            ], ['name' => $item]);
        }
    }
}
