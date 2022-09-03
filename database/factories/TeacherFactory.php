<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'lastname' => $this->faker->lastName(),
            'gender' => $this->faker->boolean(),
            'dateOfBirth' => $this->faker->date('Y-m-d'),
            'registered' => $this->faker->date('Y-m-d'),
            'avatar' => $this->faker->image(null, 640, 480),
            'email' => $this->faker->unique()->safeEmail(),
            'fiscalCode' => $this->faker->isbn13(),
            'telephone' => $this->faker->phoneNumber(),
            'paid' => $this->faker->boolean(),
        ];
    }
}
