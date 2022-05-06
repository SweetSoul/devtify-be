<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'workshop_id'];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
