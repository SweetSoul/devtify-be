<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workshop>
 */
class WorkshopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => '1',
            'title' => 'Laravel Workshop',
            'description' => 'Laravel Workshop',
            'duration' => '30',
            'price' => '100',
            'date' => '2020-02-12 14:00:00',
            'skills' => 'Laravel',
            'likes' => '0',
            'meeting_link' => 'https://meet.jit.si/laravel-workshop',
            'thumbnail_url' => 'https://picsum.photos/200/300',
            'user_id' => \App\Models\User::all()->random(),
        ];
    }
}
