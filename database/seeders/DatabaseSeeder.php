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
        $recipes = Recipe::factory()
            ->count(10)
            ->has(Ingredient::factory()->count(rand(5, 12)))
            ->has(Step::factory()->count(rand(4, 10)))
            ->has(Comment::factory()->count(rand(0, 4)))
            ->has(Nutrient::factory()->count(1))
            ->create();

        $categories = Category::factory()->count(5)->create();
        
        $recipes->each(function($recipe) use ($categories)
        {
            $recipe->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
