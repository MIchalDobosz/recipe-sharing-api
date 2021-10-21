<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'servings' => 'integer',
        'difficulty' => 'integer',
        'preparation_time' => 'integer'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'recipes_categories');
    }

    public function nutrient()
    {
        return $this->hasOne(Nutrient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
