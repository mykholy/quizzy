<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Admin\Location;

class StationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Station::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $location = Location::first();
        if (!$location) {
            $location = Location::factory()->create();
        }

        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'latitude' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'longitude' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'cost' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'cost_description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'manufacturer' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'model' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'pwps_version' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'qr_enabled' => $this->faker->boolean,
            'outlets' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'hours' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'pre_charge_instructions' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'available' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'plugshare_location_id' => $this->faker->numberBetween(0, 999),
            'plugshare_station_id' => $this->faker->numberBetween(0, 999)
        ];
    }
}
