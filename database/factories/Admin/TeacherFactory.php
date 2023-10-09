<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;


class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->lexify('1???@???A???'),
            'photo' => $this->faker->text($this->faker->numberBetween(5, 10)),
            'device_token' => $this->faker->text(10),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
