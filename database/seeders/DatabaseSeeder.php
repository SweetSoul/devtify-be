<?php

namespace Database\Seeders;

use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Challenge::factory(10)->create();
        \App\Models\WorkshopCategory::factory(2)->create();
        \App\Models\User::factory(10)
            ->hasWorkshops(rand(1, 2))
            ->create();

        // Get all the challenges attaching up to 3 random challenges to each user
        $challenges = \App\Models\Challenge::all();

        // Populate the pivot table
        \App\Models\User::all()->each(function ($user) use ($challenges) {
            $user->takenChallenges()->attach(
                $challenges->random(rand(1, 3))->pluck('id')->toArray()
            );
        });



        \App\Models\Marketplace\Item::factory(10)->create();
    }
}
