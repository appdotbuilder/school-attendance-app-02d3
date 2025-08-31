<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $grade = fake()->randomElement(['X', 'XI', 'XII']);
        $major = fake()->randomElement(['IPA', 'IPS', 'Bahasa']);
        $classNumber = fake()->numberBetween(1, 3);

        return [
            'name' => $grade . ' ' . $major . ' ' . $classNumber,
            'grade' => $grade,
            'major' => $major,
            'academic_year_id' => AcademicYear::factory(),
            'homeroom_teacher_id' => User::factory()->teacher(),
            'capacity' => fake()->numberBetween(25, 35),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}