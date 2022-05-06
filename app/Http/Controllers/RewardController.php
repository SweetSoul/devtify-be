<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Utils\RewardClaimabilityChecker;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reward::all();
    }

    /**
     * Claims the reward for the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function claim(Request $request, Reward $reward)
    {
        $claimableChecker = new RewardClaimabilityChecker($request->user(), $reward);
        if (is_object($claimableChecker->checkClaimability())) {
            return $claimableChecker->checkClaimability();
        }

        if ($claimableChecker->checkAlreadyClaimed($request->user, $reward)) {
            return response()->json([
                'message' => 'You have already claimed this reward.',
            ], 400);
        }

        if ($claimableChecker->claimable) {
            $request->user()->rewards()->attach([$reward->id => ['claimed_at' => now()]]);
            $request->user()->balance += $reward->value;
            $request->user()->save();
            return response()->json(['message' => 'Reward claimed successfully.', 'balance' => $request->user()->balance]);
        }
        return response()->json(['message' => 'You are not eligible to claim this reward at this moment.'], 422);
    }
}
