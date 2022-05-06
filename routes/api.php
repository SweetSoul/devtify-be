<?php

use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\OpenSourceCategoryController;
use App\Http\Controllers\OpenSourceController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\Marketplace\ItemController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\UserChallengeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserWorkshopController;
use App\Http\Controllers\WorkshopCategoryController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\ZoomMeetingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(WorkshopController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/workshops', 'index');
    Route::get('/workshops/featured', 'featured');
    Route::get('/workshops/{workshop}', 'show');
    Route::post('/workshops', 'store');
    Route::post('/workshops/{workshop}/join', 'join');
    Route::post('/workshops/{workshop}/like', 'like');
    Route::delete('/workshops/{workshop}/like', 'unlike');
});

Route::controller(RewardController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/rewards', 'index');
    Route::post('/rewards/{reward}/claim', 'claim');
});

Route::controller(ChallengeController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/challenges', 'index');
    Route::get('/challenges/daily', 'fetchDailyChallenges');
});

Route::controller(WorkshopCategoryController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/workshop-categories', 'index');
});

Route::controller(ItemController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/marketplace', 'index');
    Route::get('/marketplace/highlights', 'highlights');
    Route::post('/marketplace', 'store');
    Route::post('/marketplace/{item}/buy', 'buy');
});

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'userData']);
    Route::put('/', [UserController::class, 'update']);
    Route::get('/challenges', [UserChallengeController::class, 'index']);
    Route::get('/workshops', [UserWorkshopController::class, 'authoredWorkshops']);
    Route::get('/attended-workshops', [UserWorkshopController::class, 'attendedWorkshops']);
    Route::get('/transactions', [UserController::class, 'transactions']);
    Route::get('/rewards', [UserController::class, 'rewards']);
    Route::get('/inventory', [UserController::class, 'inventory']);
});

Route::post('/signup', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth:sanctum', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::controller(OpenSourceController::class)->group(function () {
    Route::get('opensource/posts/{currentPage}/{itemsQty}', 'posts');
    Route::get('/opensource/posts/{category}/{page}/{itemsQty}', 'postsByCategory');
    Route::post('/opensource/posts/create', 'createPost');
    Route::post('/opensource/posts/edit/{id}', 'editPost');
    Route::post('/opensource/posts/delete', 'deletePost');
    Route::post('/opensource/posts/like', 'createPostLike');
    Route::post('/opensource/posts/unlike', 'deletePostLike');
});

Route::controller(FeedBackController::class)->group(function () {
    Route::post('feedback/send', 'send');
});

Route::controller(OpenSourceCategoryController::class)->group(function () {
    Route::get('opensource/categories/{currentPage}/{itemsQty}', 'categories');
    Route::post('opensource/category/create', 'createCategory');
    Route::post('opensource/category/delete', 'deleteCategory');
});
