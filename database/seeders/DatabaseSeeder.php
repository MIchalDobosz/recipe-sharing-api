<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Ingredient;
use App\Models\Nutrient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Recipe::factory()
            ->count(10)
            ->has(Ingredient::factory()->count(rand(5, 12)))
            ->has(Step::factory()->count(rand(4, 10)))
            ->has(Comment::factory()->count(rand(0, 4)))
            ->has(Category::factory()->count(rand(1, 3)))
            ->has(Nutrient::factory()->count(1))
            ->create();
    }
}
