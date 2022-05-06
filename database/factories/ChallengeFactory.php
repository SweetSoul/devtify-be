<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'This is a seeded course',
            'category' => $this->faker->randomElement(['Frontend', 'Backend', 'UI']),
            'skills' => $this->faker->randomElement(['React', 'Laravel', 'Figma']),
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'due_date' => $this->faker->date,
            'active' => $this->faker->boolean,
        ];
    }
}
