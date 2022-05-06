<?php

namespace App\Models;

use App\Models\Marketplace\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'job_title',
        'project_client',
        'linkedin_url',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profileProgression()
    {
        $progression = 0;
        if ($this->linkedin_url) {
            $progression += 5;
        }
        if ($this->image) {
            $progression += 5;
        }
        if ($this->job_title) {
            $progression += 5;
        }
        if ($this->project_client) {
            $progression += 5;
        }
        if ($this->workshops()->count() > 0) {
            $progression += 25;
        }
        if ($this->attendedWorkshops()->count() > 0) {
            $progression += 25;
        }
        if ($this->inventory()->count() > 0) {
            $progression += 15;
        }
        if ($this->rewards()->count() > 0) {
            $progression += 15;
        }
        return $progression;
    }

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }

    public function takenChallenges()
    {
        return $this->belongsToMany(Challenge::class, 'users_challenges');
    }

    public function attendedWorkshops()
    {
        return $this->belongsToMany(Workshop::class, 'workshops_attendees', 'attendee_id', 'workshop_id');
    }

    public function rewards()
    {
        return $this->belongsToMany(Reward::class, 'user_rewards');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function inventory()
    {
        return $this->belongsToMany(Item::class, 'user_inventory');
    }

    public function posts()
    {
        return $this->hasMany(OpenSourcePost::class);
    }

    public function reactions()
    {
        return $this->hasMany(OpenSourceReaction::class);
    }

    public function soldWorkshop(Workshop $workshop)
    {
        $this->balance += $workshop->price;
        $this->save();
    }

    public function buyItem(Item $item)
    {
        $this->balance -= $item->price;
        $this->save();
    }

    public function canBuy(Item $item)
    {
        return $this->balance >= $item->price;
    }

    public function profileCompleted()
    {
        if ($this->job_title && $this->project_client && $this->linkedin_url && $this->image) {
            return true;
        }
        return false;
    }
}
