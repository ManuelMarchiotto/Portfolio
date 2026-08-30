<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Dev', 'Economia', 'Sport'];

        return [
            'title' => fake()->sentence(3),
            'category' => $categories[rand(0, 2)],
            // 'category' => fake()->word(),
            'body' => fake()->sentence(100),
        ];
    }
}
