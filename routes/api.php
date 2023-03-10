<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['cors', 'json.response', 'api']], function () {
    Route::post('/register',[AuthController::class, 'register'])->name('auth.register');
    Route::post('/login',[AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout',[AuthController::class, 'logout'])->name('auth.logout');

});

Route::middleware(['cors', 'json.response', 'auth:api'])->group(function () {
    // our routes to be protected will go in here
    Route::prefix('profile')->group(function(){
        Route::get('/{id?}',[ProfileController::class,'index'])->name('profile.index');
        Route::put('/{id}',[ProfileController::class,'update'])->name('profile.update');
    });
});
