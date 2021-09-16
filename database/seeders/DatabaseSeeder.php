<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Ingredient;
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
            ->create();
    }
}
