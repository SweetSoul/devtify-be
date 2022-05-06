<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'user_inventory';
    protected $fillable = ['user_id', 'item_id', 'purchased_at'];
}
