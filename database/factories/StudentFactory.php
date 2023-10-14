<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Student;
use Illuminate\Database\Eloquent\Factories\Factory;


class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

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
            'phone' => $this->faker->numerify('0##########'),
            'password' => $this->faker->lexify('1???@???A???'),
            'photo' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'provider_id' => $this->faker->text(500),
            'provider_type' => $this->faker->text(500),
            'device_token' => $this->faker->text(500),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
