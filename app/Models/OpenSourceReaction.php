<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpenSourceReaction extends Model
{
    protected $primaryKey = 'reaction_id';
    protected $fillable = ['user_id', 'open_source_post_id'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(OpenSourcePost::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
