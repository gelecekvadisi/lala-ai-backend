<?php

use App\Http\Controllers\Api as Api;
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

Route::prefix('v1')->group(function (){
    Route::post('/sign-in', [Api\Auth\AuthController::class, 'login']);
    Route::post('/sign-up', [Api\Auth\AuthController::class, 'registration']);

    Route::post('/send-reset-code',[Api\Auth\AcnooForgotPasswordController::class, 'sendResetCode']);
    Route::post('/verify-reset-code',[Api\Auth\AcnooForgotPasswordController::class, 'verifyResetCode']);
    Route::post('/password-reset',[Api\Auth\AcnooForgotPasswordController::class, 'resetPassword']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::apiResource('banners', Api\AcnooBannerController::class)->only('index');
        Route::apiResource('terms', Api\AcnooTermsController::class)->only('index');
        Route::apiResource('privacy', Api\AcnooPrivacyController::class)->only('index');
        Route::apiResource('faqs', Api\AcnooFaqsController::class)->only('index');
        Route::apiResource('categories', Api\AcnooCategoryController::class)->only('index');
        Route::apiResource('lang', Api\AcnooLanguageController::class)->only('index', 'store');
        Route::apiResource('profile', Api\AcnooProfileController::class)->only('index', 'store');
        Route::apiResource('suggestions', Api\AcnooSuggestionsController::class)->only('index');
        Route::apiResource('plans', Api\AcnooSubscriptionsController::class)->only('index');
        Route::apiResource('subscribes', Api\AcnooSubscribesController::class)->only('index', 'store');
        Route::apiResource('texts', Api\TextsController::class)->only('index', 'store');
        Route::apiResource('images', Api\ImagesController::class)->only('index', 'store');
        Route::apiResource('gateways', Api\AcnooGatewaysController::class)->only('index');
        Route::apiResource('credits', Api\CreditController::class)->only('index', 'store');
        Route::apiResource('buy-credits', Api\AcnooBuyCreditsContrller::class)->only('index', 'show');
        Route::apiResource('favorite-assistant', Api\FavoriteAssistantController::class);
        Route::post('favorite-assistant/delete', [Api\FavoriteAssistantController::class, 'destroyByUserAndAssistant']);
        Route::post('change-password', [Api\AcnooProfileController::class, 'changePassword']);
        Route::get('subscription/cancel', [Api\AcnooSubscribesController::class, 'cancel']);
        Route::post('thread', [Api\ThreadController::class, 'createThread']);
        Route::post('thread/add-message', [Api\ThreadController::class, 'addMessage']);
        Route::post('thread/runs', [Api\ThreadController::class, 'runs']);
        
        Route::get('adnetworks', [Api\AcnooAdnetworksController::class, 'index']);
        Route::get('api-keys', [Api\AcnooApiKeyController::class, 'index']);
        Route::get('/sign-out', [Api\Auth\AuthController::class, 'maanSignOut']);
        Route::get('/refresh-token', [Api\Auth\AuthController::class, 'refreshToken']);
    });
});
