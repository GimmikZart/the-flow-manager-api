<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
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
            'avatar' => 'https://picsum.photos/200',
            'email' => $this->faker->unique()->safeEmail(),
            'fiscalCode' => $this->faker->isbn13(),
            'telephone' => $this->faker->phoneNumber(),
        ];
    }
}
