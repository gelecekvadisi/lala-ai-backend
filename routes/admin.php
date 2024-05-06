<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as ADMIN;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [ADMIN\DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/get-dashboard', [Admin\DashboardController::class, 'getDashboardData'])->name('dashboard.data');
    Route::get('/yearly-generates', [Admin\DashboardController::class, 'yearlyGenerates'])->name('dashboard.generates');
    Route::get('/users-overview', [ADMIN\DashboardController::class, 'userOverview'])->name('dashboard.user-overview');

    Route::resource('users', ADMIN\UserController::class);
    Route::post('users/status/{id}', [ADMIN\UserController::class,'status'])->name('users.status');
    Route::post('users/delete-all', [ADMIN\UserController::class,'deleteAll'])->name('users.delete-all');

    Route::resource('banners', ADMIN\AcnooBannerController::class);
    Route::post('banners/status/{id}', [ADMIN\AcnooBannerController::class,'status'])->name('banners.status');
    Route::post('banners/delete-all', [ADMIN\AcnooBannerController::class,'deleteAll'])->name('banner.delete-all');

    Route::resource('categories', ADMIN\AcnooCategoryController::class)->except('show');
    Route::post('categories/status/{id}', [ADMIN\AcnooCategoryController::class,'status'])->name('categories.status');
    Route::post('categories/delete-all', [ADMIN\AcnooCategoryController::class,'deleteAll'])->name('categories.delete-all');

    Route::resource('plans', ADMIN\AcnooPlanController::class);
    Route::post('plans/status/{id}', [ADMIN\AcnooPlanController::class,'status'])->name('plans.status');
    Route::post('plans/delete-all', [ADMIN\AcnooPlanController::class,'deleteAll'])->name('plans.delete-all');

    Route::resource('buy-credits', ADMIN\AcnooBuyCreditsContrller::class);
    Route::post('buy-credits/status/{id}', [ADMIN\AcnooBuyCreditsContrller::class, 'status'])->name('buy-credits.status');
    Route::post('buy-credits/delete-all', [ADMIN\AcnooBuyCreditsContrller::class, 'deleteAll'])->name('buy-credits.delete-all');

    Route::resource('subscribers', ADMIN\SubscriberController::class)->only('index', 'destroy');
    Route::post('subscribers/delete-all', [ADMIN\SubscriberController::class, 'deleteAll'])->name('subscribers.delete-all');

    Route::resource('generates', ADMIN\GenerateController::class)->only('index', 'show', 'destroy');
    Route::post('generates/delete-all', [ADMIN\GenerateController::class, 'deleteAll'])->name('generates.delete-all');

    Route::resource('suggestions', ADMIN\AcnooSuggestionController::class)->except('show');
    Route::post('suggestions/status/{id}',[ADMIN\AcnooSuggestionController::class,'status'])->name('suggestions.status');
    Route::post('suggestions/delete-all',[ADMIN\AcnooSuggestionController::class,'deleteAll'])->name('suggestions.delete-all');

    Route::resource('faqs', ADMIN\AcnooFaqController::class)->except('show');
    Route::post('faqs/status/{id}',[ADMIN\AcnooFaqController::class,'status'])->name('faqs.status');
    Route::post('faqs/delete-all',[ADMIN\AcnooFaqController::class,'deleteAll'])->name('faqs.delete-all');

    Route::get('/policies',[ADMIN\AcnooPolicyController::class,'index'])->name('policies.index');
    Route::put('/policies-update',[ADMIN\AcnooPolicyController::class,'update'])->name('policies.update');

    Route::get('/terms',[ADMIN\AcnooTermController::class,'index'])->name('terms.index');
    Route::put('/terms-update',[ADMIN\AcnooTermController::class,'update'])->name('terms.update');

    Route::get('/adnetworks',[ADMIN\AcnooAdnetworkController::class,'index'])->name('adnetworks.index');
    Route::put('/adnetworks-update',[ADMIN\AcnooAdnetworkController::class,'update'])->name('adnetworks.update');

    Route::resource('api-keys',ADMIN\AcnooApiKeyController::class)->except('show');
    Route::post('api-keys/status/{id}',[ADMIN\AcnooApiKeyController::class,'status'])->name('api-keys.status');
    Route::post('api-keys/delete-all',[ADMIN\AcnooApiKeyController::class,'deleteAll'])->name('api-keys.delete-all');

    Route::get('/text-generates',[ADMIN\AcnooTextController::class,'index'])->name('text-generates.index');
    Route::put('/text-generates',[ADMIN\AcnooTextController::class,'update'])->name('text-generates.update');

    Route::get('/image-generates',[ADMIN\AcnooImageController::class,'index'])->name('image-generates.index');
    Route::put('/image-generates',[ADMIN\AcnooImageController::class,'update'])->name('image-generates.update');

    Route::resource('profiles', ADMIN\ProfileController::class)->only('index', 'update');

    // Roles & Permissions
    Route::resource('roles', ADMIN\RoleController::class)->except('show');
    Route::resource('permissions', ADMIN\PermissionController::class)->only('index', 'store');

    // Gateway
    Route::resource('gateways', ADMIN\AcnooGatewayController::class)->only('index', 'store');

    // General Setting
    Route::resource('settings', ADMIN\SettingController::class)->only('index', 'update');

    // System Settings
    Route::resource('system-settings', ADMIN\SystemSettingController::class)->only('index', 'store');

    // Buy / Earned Credits
    Route::resource('credits-earning', ADMIN\AcnooCreditEarningController::class)->only('index', 'show', 'destroy');
    Route::post('credits-earning/delete-all', [ADMIN\AcnooCreditEarningController::class, 'deleteAll'])->name('credits-earning.delete-all');

    //Notifications manager
    Route::prefix('notifications')->controller(ADMIN\NotificationController::class)->name('notifications.')->group(function () {
        Route::get('/', 'mtIndex')->name('index');
        Route::post('/filter', 'maanFilter')->name('filter');
        Route::get('/{id}', 'mtView')->name('mtView');
        Route::get('view/all/', 'mtReadAll')->name('mtReadAll');
    });

});

