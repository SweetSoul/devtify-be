<?php

namespace Database\Factories\Marketplace;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Marketplace\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'highlighted' => $this->faker->boolean,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'thumbnail_url' => $this->faker->imageUrl(),
        ];
    }
}
