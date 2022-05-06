<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'job_title' => ['required', 'string', 'max:255'],
            'project_client' => ['required', 'string', 'max:255'],
            'linkedin_url' => ['string', 'max:255', 'nullable'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'job_title' => $request->job_title,
            'project_client' => $request->project_client,
            'linkedin_url' => $request->linkedin_url,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            event(new Registered($user));

            Auth::login($user);

            return response()->json(['user' => $user, 'token' => $user->createToken('Personal Access Token')->plainTextToken]);
        }
        return response()->json(['error' => 'Something went wrong...']);
    }
}
