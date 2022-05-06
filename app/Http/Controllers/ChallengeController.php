<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index(Request $request)
    {
        return Challenge::orderBy('due_date')->all();
    }

    public function fetchDailyChallenges()
    {
        return Challenge::where('active', true)
            ->whereDate('due_date', '>=', date('Y-m-d'))
            ->inRandomOrder()
            ->get();
    }

    public function fetchActiveChallenges()
    {
        $challenges = Challenge::where('active', true)
            ->get();
        return $challenges;
    }
}
