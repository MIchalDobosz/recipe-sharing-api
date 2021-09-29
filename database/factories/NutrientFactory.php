<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Nutrient;

class NutrientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nutrient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $protein = $this->faker->numberBetween(5, 100);
        $fat = $this->faker->numberBetween(5, 100);
        $carbs = $this->faker->numberBetween(0, 150);
        $calories = (4 * $protein) + (9 * $fat) + (4 * $carbs);
        
        return [
            'calories' => $calories,
            'protein' => $protein,
            'fat' => $fat,
            'carbs' => $carbs
        ];
    }
}
