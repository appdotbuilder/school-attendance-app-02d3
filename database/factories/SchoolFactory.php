<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' School',
            'npsn' => fake()->numerify('20######'),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'principal_name' => fake()->name(),
            'level' => fake()->randomElement(['sd', 'smp', 'sma', 'smk']),
            'start_time' => '07:00:00',
            'end_time' => '15:00:00',
            'is_active' => true,
        ];
    }
}