<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Location;
use Illuminate\Database\Eloquent\Factories\Factory;


class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'latitude' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'longitude' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'photos' => $this->faker->word,
            'score' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'cost' => $this->faker->boolean,
            'cost_description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'access' => $this->faker->numberBetween(0, 999),
            'icon' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'icon_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'phone' => $this->faker->numerify('0##########'),
            'address' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'pwps_version' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'qr_enabled' => $this->faker->boolean,
            'poi_name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'parking_type_name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'locale' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'opening_date' => $this->faker->date('Y-m-d'),
            'hours' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'open247' => $this->faker->boolean,
            'coming_soon' => $this->faker->boolean,
            'under_repair' => $this->faker->boolean,
            'access_restrictions' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'parking_attributes' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'parking_level' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'overhead_clearance_meters' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'plugshare_location_id' => $this->faker->numberBetween(0, 999)
        ];
    }
}
