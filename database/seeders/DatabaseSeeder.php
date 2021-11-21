<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\File;
use App\Models\Ingredient;
use App\Models\Nutrient;
use App\Models\Rating;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk('public')->deleteDirectory('avatars');
        Storage::disk('public')->deleteDirectory('images');
        Storage::disk('public')->deleteDirectory('main_images');

        $users = User::factory()
            ->count(5)
            ->has(Recipe::factory()->count(3)
                ->has(Ingredient::factory()->count(7))
                ->has(Step::factory()->count(5))
                ->has(Comment::factory()->count(3))
                ->has(Nutrient::factory()->count(1))
            )
            ->create();

        $users->each(function($user)
        {
            $user->avatar()->associate(File::create(
                File::store(
                    UploadedFile::fake()->image('photo.jpg', 160, 160),
                    'public',
                    'avatars')
                ))->save();
        });

        $recipes = Recipe::all();
        $categories = Category::factory()->count(5)->create();
        $recipes->each(function($recipe) use ($users, $categories)
        {
            $recipe->images()->create(
                File::store(
                    UploadedFile::fake()->image('photo.jpg', 1280, 860),
                    'public',
                    'main_images'),
                ['main' => true]
            );

            $recipe->images()->createMany(
                File::store(
                [
                    UploadedFile::fake()->image('photo.jpg', 860, 860),
                    UploadedFile::fake()->image('photo.jpg', 860, 860),
                    UploadedFile::fake()->image('photo.jpg', 860, 860),
                    UploadedFile::fake()->image('photo.jpg', 860, 860),
                    UploadedFile::fake()->image('photo.jpg', 860, 860)
                ],
                'public',
                'images')
            );

            $users->each(function($user) use ($recipe)
            {
                $rating = Rating::factory()->makeOne();
                $rating->recipe()->associate($recipe);
                $rating->user()->associate($user);
                $rating->save();
            });
            $recipe->updateRating();

            $recipe->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());
        });
    }
}
