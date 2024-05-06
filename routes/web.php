<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/auth.php';

Route::redirect('/', '/login');

Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    return back()->with('success', __('Cache has been cleared.'));
});

// Route::get('/reset', function () {
//     Artisan::call('cache:clear');
//     Artisan::call('migrate:fresh --seed');
//     return back()->with('success', __('Restart.'));
// });
