<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Admin\Question;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $question = Question::first();
        if (!$question) {
            $question = Question::factory()->create();
        }

        return [
            'title' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'question_type' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'answer_two_gap_match' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'answer_view_format' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'answer_order' => $this->faker->randomDigitNotNull,
            'answer_settings' => $this->faker->text(500),
            'photo' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'is_correct' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
