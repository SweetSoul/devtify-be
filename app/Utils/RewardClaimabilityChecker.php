<?php

namespace App\Utils;

use App\Models\Reward;
use App\Models\User;

class RewardClaimabilityChecker
{

  public function __construct(User $user, Reward|null $reward)
  {
    $this->user = $user;
    $this->reward = $reward;
    $this->claimable = false;
    $this->claimed = false;
  }

  public function setReward($reward)
  {
    $this->reward = $reward;
  }

  public function checkClaimability()
  {
    switch ($this->reward->code) {
      case 'WELCOME':
        $this->claimable = true;
        break;

      case 'USER_PROFILE_COMPLETED':
        $this->claimable = $this->user->profileCompleted();
        break;

      case 'FIRST_WORKSHOP':
        $this->claimable = $this->user->workshops()->count() > 0;
        break;

      case 'FIVE_WORKSHOPS':
        $this->claimable = $this->user->workshops()->count() >= 5;
        break;

      case 'TEN_WORKSHOPS':
        $this->claimable = $this->user->workshops()->count() >= 10;
        break;

      case 'FIRST_FREE_WORKSHOP':
        $this->claimable = $this->user->workshops()->where('price', 0)->count() > 0;
        break;

      case 'FIVE_FREE_WORKSHOPS':
        $this->claimable = $this->user->workshops()->where('price', 0)->count() >= 5;
        break;

      case 'TEN_FREE_WORKSHOPS':
        $this->claimable = $this->user->workshops()->where('price', 0)->count() >= 10;
        break;

      case 'FIRST_OPEN_SOURCE_POST':
        $this->claimable = $this->user->posts()->count() > 0;
        break;

      case 'FIVE_ITEMS_BOUGHT':
        $this->claimable = $this->user->inventory()->count() >= 5;
        break;

      default:
        $this->claimable = false;
        return response()->json(['error' => 'Reward not found'], 404);
        break;
    }
  }

  public function checkAlreadyClaimed()
  {
    $claimed = $this->user->rewards()->where('reward_id', $this->reward->id)->count() !== 0;
    $this->claimable = !$claimed;
    $this->claimed = $claimed;
    return $claimed;
  }
}
