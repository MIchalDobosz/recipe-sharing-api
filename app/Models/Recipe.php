<?php

namespace App\Models;

use App\Http\Requests\RecipeIndexRequest;
use Illuminate\Database\Eloquent\Builder;
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

    public const DEFAULT_SORT_FIELD = 'created_at';
    public const DEFAULT_ORDER_TYPE = 'desc';
    public const DEFAULT_PER_PAGE = 10;

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

    public static function getRecipes(RecipeIndexRequest $request)
    {
        $query = self::with('categories');
        $query = self::getFilters($query, $request);
        $query = self::getSort($query, $request);

        return $query->paginate(self::DEFAULT_PER_PAGE);
    }

    private static function getSort(Builder $query, RecipeIndexRequest $request)
    {
        $sort = $request->has('sort') && !empty($request->sort) ? $request->sort : self::DEFAULT_SORT_FIELD;
        $order = $request->has('order') && !empty($request->order) ? $request->order : self::DEFAULT_ORDER_TYPE;
        $query->orderBy($sort, $order);

        return $query;
    }

    private static function getFilters(Builder $query, RecipeIndexRequest $request)
    {
        // Categories
        if ($request->has('categories') && !empty($request->categories))
        {
            foreach ($request->categories as $category)
            {
                $query->whereHas('categories', function($query) use ($category)
                {
                    $query->where('category_id', $category);
                });
            }
        }

        // Servings
        if ($request->has('servings') && !empty($request->servings))
        {
            $query->where('servings', $request->servings);
        }

        // Difficulty
        if ($request->has('difficulty') && !empty($request->difficulty))
        {
            $query->where('difficulty', $request->difficulty);
        }

        // Preparation Time
        if ($request->has('preparation_time') && !empty($request->preparation_time))
        {
            $query->where('preparation_time', '<=', $request->preparation_time);
        }

        // Title
        if ($request->has('title') && !empty($request->title))
        {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        return $query;
    }
}
