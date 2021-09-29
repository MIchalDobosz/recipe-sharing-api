<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(8);
        $slug = Str::slug($title, '-');

        return [
            'title' => $title,
            'slug' => $slug,
            'description' => $this->faker->sentence(25),
            'content' => $this->faker->sentence(70),
            'servings' => $this->faker->numberBetween(1, 8),
            'preparation_time' => $this->faker->numberBetween(300, 7200),
            'difficulty' => array_rand(config('properties.difficulty'), 1)
        ];
    }
}
