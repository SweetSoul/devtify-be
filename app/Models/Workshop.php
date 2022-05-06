<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'duration', 'price', 'date', 'skills', 'thumbnail_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attend(User $user)
    {
        $this->attendees()->attach($user->id);
        $user->balance -= $this->price;
        $user->save();
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'workshops_attendees', 'workshop_id', 'attendee_id');
    }

    public function category()
    {
        return $this->belongsTo(WorkshopCategory::class);
    }

    public function like(User $user)
    {
        $this->likes()->attach($user->id);
        $this->likes += 1;
        $this->save();
    }

    public function unlike(User $user)
    {
        $this->likes()->detach($user->id);
        $this->likes -= 1;
        $this->save();
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'workshop_likes', 'workshop_id', 'user_id');
    }
}
