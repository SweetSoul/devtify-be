<?php

namespace App\Models\Zoom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oauth extends Model
{
    use HasFactory;
    protected $table = 'zoom_oauths';
    protected $fillable = ['provider', 'provider_value'];

    public static function isTableEmpty()
    {
        return is_null(self::first());
    }

    public static function getAccessToken()
    {
        return json_decode(self::where('provider', 'zoom')->first()->provider_value);
    }

    public static function getRefreshToken()
    {
        $result = self::getAccessToken();
        return $result->refresh_token;
    }

    public static function updateAccessToken($token)
    {
        if (self::isTableEmpty()) {
            self::create([
                'provider' => 'zoom',
                'provider_value' => $token,
            ]);
        } else {
            self::where('provider', 'zoom')->update([
                'provider_value' => $token,
            ]);
        }
    }
}
