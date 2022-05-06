<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\Zoom\Oauth;
use Exception;
use GuzzleHttp\Client;

class ZoomMeetingController extends Controller
{
    public static function createMeeting(Workshop $workshop)
    {
        $client = new Client(['base_uri' => 'https://api.zoom.us']);

        $arr_token = Oauth::getAccessToken();
        $accessToken = $arr_token->access_token;
        try {
            $response = $client->request('POST', '/v2/users/me/meetings', [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ],
                'json' => [
                    "topic" => $workshop->title,
                    "type" => 2,
                    "start_time" => $workshop->date,
                    "duration" => $workshop->duration,
                    "password" => $workshop->password,
                ],
            ]);

            $data = json_decode($response->getBody());
            return $data->join_url;
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                $refresh_token = Oauth::getRefreshToken();
                $client = new Client(['base_uri' => 'https://zoom.us']);
                $response = $client->request('POST', '/oauth/token', [
                    "headers" => [
                        "Authorization" => "Basic " . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'))
                    ],
                    'form_params' => [
                        "grant_type" => "refresh_token",
                        "refresh_token" => $refresh_token
                    ],
                ]);
                Oauth::updateAccessToken($response->getBody());
                self::createMeeting($workshop);
            } else {
                echo $e->getMessage();
            }
        }
    }
}
