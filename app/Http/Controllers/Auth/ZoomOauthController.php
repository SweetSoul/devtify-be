<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Zoom\Oauth;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ZoomOauthController extends Controller
{
    public function callback()
    {
        try {
            $client = new Client(['base_uri' => 'https://zoom.us']);
            $headers = [
                "Authorization" => "Basic " . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'))
            ];
            $form_params = [
                "grant_type" => "authorization_code",
                "code" => $_GET['code'],
                "redirect_uri" => env('ZOOM_REDIRECT_URI')
            ];
            $response = $client->request('POST', '/oauth/token', [
                "headers" => $headers,
                'form_params' => $form_params,
            ]);

            $token = json_decode($response->getBody()->getContents(), true);

            Oauth::updateAccessToken(json_encode($token));
            echo "Access token inserted successfully.";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
