<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Admin\Subject;
use App\Models\Admin\Teacher;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $teacher = Teacher::first();
        if (!$teacher) {
            $teacher = Teacher::factory()->create();
        }

        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'photo' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
