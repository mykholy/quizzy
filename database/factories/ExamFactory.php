<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Admin\Subject;
use App\Models\Admin\Book;
use App\Models\Admin\Unit;
use App\Models\Admin\Lesson;

class ExamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $lesson = Lesson::first();
        if (!$lesson) {
            $lesson = Lesson::factory()->create();
        }

        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'type' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'question_types' => $this->faker->text(500),
            'level' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'type_assessment' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'photo' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'file' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'semester' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'points' => $this->faker->numberBetween(0, 9223372036854775807),
            'time' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
