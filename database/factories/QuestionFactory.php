<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Admin\Lesson;
use App\Models\Admin\AcademicYear;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $academicYear = AcademicYear::first();
        if (!$academicYear) {
            $academicYear = AcademicYear::factory()->create();
        }

        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'type' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'photo' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'semester' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'points' => $this->faker->numberBetween(0, 9223372036854775807),
            'time' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
