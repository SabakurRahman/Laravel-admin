<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogCategory>
 */
class BlogCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'name' => fake()->sentence,
            'slug' => fake()->slug,
            'status' => fake()->randomElement([1, 2]), // Adjust as needed
            'photo' => null,
            'cover_photo' => null,
            'type' => fake()->randomElement([1, 2]),
        ];
    }
}
