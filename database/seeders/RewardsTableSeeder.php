<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reward::create([
            'code' => 'WELCOME',
            'name' => 'Welcome!',
            'description' => 'You joined BairesDev!',
            'value' => 100,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIRST_REFERRAL',
            'name' => 'Bring your friends in!',
            'description' => 'You referred 1 person',
            'value' => 500,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIVE_REFERRALS',
            'name' => 'Talent Magnet',
            'description' => 'You referred 5 people',
            'value' => 1000,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'USER_PROFILE_COMPLETED',
            'name' => 'Who are you?',
            'description' => 'Completed your user profile',
            'value' => 50,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIRST_WORKSHOP',
            'name' => 'Contributor',
            'description' => 'Created and gave a workshop',
            'value' => 30,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIRST_FREE_WORKSHOP',
            'name' => 'Generous',
            'description' => 'Created and gave a FREE workshop',
            'value' => 150,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIVE_WORKSHOPS',
            'name' => 'Teacher',
            'description' => 'Create and give 5 workshops',
            'value' => 200,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIVE_FREE_WORKSHOPS',
            'name' => 'Giver',
            'description' => 'Create and give 5 FREE workshops',
            'value' => 300,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'TEN_WORKSHOPS',
            'name' => 'Dalai Lama',
            'description' => 'Create and give 10 workshops',
            'value' => 300,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'TEN_FREE_WORKSHOPS',
            'name' => 'Selfless',
            'description' => 'Create and give 10 FREE workshops',
            'value' => 500,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIRST_CHALLENGE',
            'name' => 'Challenge Accepted',
            'description' => 'Finish a daily challenge',
            'value' => 20,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'TEN_CHALLENGES',
            'name' => 'Is this even a challenge?',
            'description' => 'Finish 10 daily challenges',
            'value' => 50,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIRST_OPEN_SOURCE_POST',
            'name' => 'Did you do that all by yourself?',
            'description' => 'Create your first Open Source post',
            'value' => 50,
            'active' => true,
        ]);

        Reward::create([
            'code' => 'FIVE_ITEMS_BOUGHT',
            'name' => 'Shopping spree',
            'description' => 'Buy 5 items from the marketplace',
            'value' => 50,
            'active' => true,
        ]);
    }
}
