<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Client;
use Illuminate\Database\Eloquent\Factories\Factory;


class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'email' => $this->faker->email,
            'password' => $this->faker->lexify('1???@???A???'),
            'photo' => $this->faker->text(5),
            'device_token' => $this->faker->text(100),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
