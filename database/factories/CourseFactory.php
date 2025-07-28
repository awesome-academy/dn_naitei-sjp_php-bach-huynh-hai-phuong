<?php

namespace Database\Factories;

use App\Models\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(array_map(fn($case) => $case->value, CourseStatus::cases())),
            'started_at' => $this->faker->optional()->dateTimeThisYear(),
            'finished_at' => $this->faker->optional()->dateTimeThisYear(),
            'featured_image' => '/courses/wallhaven-3q9qky.png',
        ];
    }
}
