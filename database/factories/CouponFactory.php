<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Admin\Student;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $student = Student::first();
        if (!$student) {
            $student = Student::factory()->create();
        }

        return [
            'title' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'code' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'value' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
