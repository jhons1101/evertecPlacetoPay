<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->text(50),
            "url" =>  $this->faker->imageUrl(),
            "currency" => 'USD',
            "cost" =>  $this->faker->randomNumber(3, false),
            "created_at" => now()
        ];
    }
}
