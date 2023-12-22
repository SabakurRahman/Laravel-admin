<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        $title =  $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
            'status' => 1,
            'photo' => $this->faker->imageUrl(600, 450),
            'type' => random_int(1,2),
            'is_featured' => 1,
            'blog_category_id' =>  random_int(1,5),
            'user_id' =>  random_int(1,5),
        ];
    }
}
