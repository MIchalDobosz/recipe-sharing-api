<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    use HasSlug;

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

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
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
        return $this->belongsToMany(Category::class, 'categories_recipes');
    }

    public function nutrient()
    {
        return $this->hasOne(Nutrient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->belongsToMany(File::class, 'files_recipes');
    }

    public function getMainImageAttribute()
    {
        return $this->images()->wherePivot('main', true)->first();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function updateRating()
    {
        $this->update(['rating' => $this->ratings()->avg('score')], ['timestamps' => false]);
    }
}
