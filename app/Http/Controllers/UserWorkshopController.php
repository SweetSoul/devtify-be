<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserWorkshopController extends Controller
{
  public function authoredWorkshops()
  {
    return User::with('workshops')->find(Auth::id())->workshops;
  }

  public function attendedWorkshops()
  {
    return User::with('attendedWorkshops')->find(Auth::id())->attendedWorkshops;
  }
}
