<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            ['name' => 'Matematika', 'code' => 'MTK'],
            ['name' => 'Bahasa Indonesia', 'code' => 'BID'],
            ['name' => 'Bahasa Inggris', 'code' => 'BIG'],
            ['name' => 'Fisika', 'code' => 'FIS'],
            ['name' => 'Kimia', 'code' => 'KIM'],
            ['name' => 'Biologi', 'code' => 'BIO'],
            ['name' => 'Sejarah', 'code' => 'SEJ'],
            ['name' => 'Geografi', 'code' => 'GEO'],
            ['name' => 'Ekonomi', 'code' => 'EKO'],
            ['name' => 'Sosiologi', 'code' => 'SOS'],
        ];

        $subject = fake()->randomElement($subjects);

        return [
            'name' => $subject['name'],
            'code' => $subject['code'],
            'description' => fake()->sentence(),
            'credit_hours' => fake()->numberBetween(2, 4),
            'type' => fake()->randomElement(['mandatory', 'elective', 'local_content']),
            'is_active' => true,
        ];
    }
}