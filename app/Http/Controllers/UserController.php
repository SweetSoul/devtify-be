<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\User;
use App\Utils\RewardClaimabilityChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userData()
    {
        $user = User::with(['workshops', 'attendedWorkshops', 'takenChallenges', 'transactions', 'inventory'])->find(Auth::id());
        return response()->json(['user' => $user, 'progression' => $user->profileProgression()]);
    }

    public function transactions()
    {
        return User::with('transactions')->find(Auth::id())->transactions;
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'project_client' => ['string', 'max:255'],
            'linkedin_url' => ['string', 'max:255', 'nullable'],
        ]);

        $user = User::find(Auth::id());
        $user->update($request->all());
        return $user;
    }

    public function rewards()
    {
        $rewards = Reward::all();
        $claimabilityChecker = new RewardClaimabilityChecker(Auth::user(), null);
        foreach ($rewards as $key => $value) {
            $claimabilityChecker->setReward($value);
            $claimabilityChecker->checkAlreadyClaimed();
            $claimabilityChecker->checkClaimability();
            $rewards[$key]->claimed = $claimabilityChecker->claimed;
            $rewards[$key]->claimable = $claimabilityChecker->claimable && !$claimabilityChecker->claimed;
        }
        return $rewards;
    }

    public function inventory()
    {
        return response()->json(['items' => Auth::user()->inventory, 'count' => Auth::user()->inventory->count()]);
    }
}
