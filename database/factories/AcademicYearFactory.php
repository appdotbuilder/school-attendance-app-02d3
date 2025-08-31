<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicYear>
 */
class AcademicYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = fake()->numberBetween(2020, 2024);
        
        return [
            'name' => $startYear . '/' . ($startYear + 1),
            'start_date' => $startYear . '-07-01',
            'end_date' => ($startYear + 1) . '-06-30',
            'is_active' => fake()->boolean(20),
        ];
    }

    /**
     * Indicate that the academic year is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
}