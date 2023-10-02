<?php

use App\Http\Controllers\Authorization\AuthController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\SubscriberController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['locale'])->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/section', SectionController::class);
        Route::apiResource('/post', PostController::class);
        Route::apiResource('/banner', BannerController::class);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('/contact_message', ContactMessageController::class);
        Route::apiResource('/user', UserController::class);
        Route::get('/sectiontypes', [SectionController::class, 'types']);
        Route::apiResource('/subscriber', SubscriberController::class);
        Route::put('/subscribe/{subscriber}', [SubscriberController::class, 'subscribe']);
        Route::put('/unsubscribe/{subscriber}', [SubscriberController::class, 'unsubscribe']);
    });
});