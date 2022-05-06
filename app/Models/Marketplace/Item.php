<?php

namespace App\Models\Marketplace;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'marketplace_items';

    protected $fillable = [
        'title',
        'description',
        'price',
        'thumbnail_url',
        'highlighted',
    ];
}
