<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reviewer_id' => User::factory(), // This will be overridden in the seeder
            'reviewed_user_id' => User::factory(), // This will be overridden in the seeder
            'rating' => $this->faker->numberBetween(1, 5),
            'review_text' => $this->faker->sentence,
        ];
    }
}
