<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    use HasFactory;

    protected $table = 'recipes_categories';
    protected $guarded = ['id'];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
