<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserChallengeController extends Controller
{
    public function index()
    {
        return User::with('takenChallenges')->find(Auth::id())->takenChallenges;
    }
}
