<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Connector;
use Illuminate\Database\Eloquent\Factories\Factory;


class ConnectorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Connector::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'power' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'power' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'kilowatts' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'photo' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
