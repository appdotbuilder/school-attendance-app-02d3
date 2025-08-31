<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => User::factory()->student(),
            'class_id' => Classes::factory(),
            'subject_id' => Subject::factory(),
            'teacher_id' => User::factory()->teacher(),
            'date' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'time' => fake()->time('H:i'),
            'status' => fake()->randomElement(['present', 'absent', 'late', 'excused', 'sick']),
            'notes' => fake()->optional()->sentence(),
            'session' => fake()->randomElement(['morning', 'afternoon', 'full_day']),
        ];
    }

    /**
     * Indicate that the attendance is present.
     */
    public function present(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'present',
        ]);
    }

    /**
     * Indicate that the attendance is absent.
     */
    public function absent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'absent',
        ]);
    }
}