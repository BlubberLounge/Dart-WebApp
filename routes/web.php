<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtillityController;
use App\Http\Controllers\GameController;

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
    return view('index');
});

Auth::routes(['verify' => true]);

/*
 * email verification routes 
 */
// Route::get('/email', function () {
//     return view('auth.verify');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return redirect('/home');
// })->middleware(['auth'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
 
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/* 
 * protected routes
 */

Route::middleware(['auth'])->group(function ()
{
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('checkouts')->group(function ()
    {
        Route::get('/dartboard', [UtillityController::class, 'viewDartboard'])->name('utillity.viewDartboard');
        Route::get('/{score?}', [UtillityController::class, 'viewCheckouts'])->name('utillity.viewCheckouts');
    });

});

Route::middleware(['auth', 'verified'])->group(function ()
{
    Route::resource('/user', UserController::class);
    
    Route::resource('/game', GameController::class);

});
