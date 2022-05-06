<?php

use App\Http\Controllers\Auth\ZoomOauthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => "https://zoom.us/oauth/authorize?response_type=code&client_id=" . env('ZOOM_CLIENT_ID') . "&redirect_uri=" . env('ZOOM_REDIRECT_URI')];
});

Route::get('oauth/zoom', [ZoomOauthController::class, 'callback'])->name('oauth.zoom');

require __DIR__ . '/auth.php';
