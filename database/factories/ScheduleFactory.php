<?php

namespace Database\Factories;

use App\Models\ClassSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startHour = fake()->numberBetween(7, 14);
        $endHour = $startHour + fake()->numberBetween(1, 2);

        return [
            'class_subject_id' => ClassSubject::factory(),
            'day' => fake()->randomElement(['monday', 'tuesday', 'wednesday', 'thursday', 'friday']),
            'start_time' => sprintf('%02d:00:00', $startHour),
            'end_time' => sprintf('%02d:00:00', $endHour),
            'room' => fake()->optional()->bothify('Room ##?'),
            'is_active' => true,
        ];
    }
}