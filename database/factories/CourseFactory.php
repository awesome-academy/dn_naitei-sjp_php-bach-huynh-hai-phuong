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
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(array_map(fn($case) => $case->value, CourseStatus::cases())),
            'started_at' => fake()->optional()->dateTimeThisYear(),
            'finished_at' => fake()->optional()->dateTimeThisYear(),
            'featured_image' => '/courses/wallhaven-3q9qky.png',
        ];
    }
}
