<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-30 days', '+30 days');
        $endDate = (clone $startDate)->modify('+' . fake()->numberBetween(1, 5) . ' days');

        return [
            'student_id' => User::factory()->student(),
            'submitted_by' => User::factory()->student(),
            'approved_by' => null,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'type' => fake()->randomElement(['sick', 'permission', 'family', 'emergency']),
            'reason' => fake()->paragraph(),
            'attachment' => null,
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'admin_notes' => null,
            'submitted_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'processed_at' => null,
        ];
    }

    /**
     * Indicate that the leave request is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'approved_by' => null,
            'processed_at' => null,
        ]);
    }

    /**
     * Indicate that the leave request is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'approved_by' => User::factory()->teacher(),
            'processed_at' => fake()->dateTimeBetween('-10 days', 'now'),
        ]);
    }
}