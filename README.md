# Recipe Sharing API

## Functionality
This api provides functionality necessary to build your own recipe sharing application.

### Users
API provides you with all necessary user management features. It uses Laravel Sanctum for authentication.
 
### Recipes
Users can create complex cooking recipes that include: images, description, ingredients, steps, categories, nutrients, servings, difficulty, etc.

### Ratings and comments
Users can rate and comment on recipes.

### Recipes catalog
Recipes catalog supports filtering and sorting. Every recipe title is sluggable which provides pretty URLs.

## Requirements
- PHP 8.0
- Laravel 8.6.5
- MySql 8.0

## Installation 
 - Make sure that you meet technological requirements
 - Fill up your `.env`
 - Start local server with `php artisan serve`
 - Run migration with `php artisan migrate`
 - Run seeder with `php artisan seed`
 
