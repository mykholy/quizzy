<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Admin\Subject;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subject = Subject::first();
        if (!$subject) {
            $subject = Subject::factory()->create();
        }

        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'photo' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
