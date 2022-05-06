<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class OpenSourcePost extends Model
{
    protected $fillable = ['open_source_category_id', 'title', 'description', 'repository_url', 'site_url', 'image_url'];
    protected $appends = ['liked'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(OpenSourceReaction::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(OpenSourceCategory::class);
    }

    public function getLikedAttribute(): bool
    {
        return $this->reactions()->where('user_id', '=', Auth::id())->count() > 0;
    }
}
