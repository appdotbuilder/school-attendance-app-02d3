<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassSubject>
 */
class ClassSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_id' => Classes::factory(),
            'subject_id' => Subject::factory(),
            'teacher_id' => User::factory()->teacher(),
            'credit_hours' => fake()->numberBetween(2, 4),
        ];
    }
}