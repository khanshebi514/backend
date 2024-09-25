<?php

namespace Database\Factories;
use App\Models\Products;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), 
            'description' => $this->faker->sentence(10), 
            'price' => $this->faker->randomFloat(2, 1 , 2), 
            'quantity'=> $this->faker->numberBetween(1,10),
            'sku'=> $this->faker->unique()->numberBetween(1,100),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'category' => $this->faker->randomElement(['men', 'women', 'kids']), 
        ];
    }
}
