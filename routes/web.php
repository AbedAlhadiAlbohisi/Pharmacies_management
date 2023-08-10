<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\HomeControler;
use App\Http\Controllers\nawacontroller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PharmaceuticalController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\Rolecontroller;
use App\Http\Controllers\UserController;
use App\Models\Delivery;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

/*
        |--------------------------------------------------------------------------
        | Route  Auth
        |--------------------------------------------------------------------------
        */





Route::get('/',[nawacontroller::class , 'index'])->name('home');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('cms')->middleware('guest:admin,user,pharmacist')->group(function () {
            Route::controller(AuthController::class)->group(function () {
                //**Route  Auth Login */
                Route::get('/{guard}/login', 'showLoginView')->name('auth.login');
                Route::post('/login', 'login');
                //**Route  Auth Forgot Password */
                Route::get('/{guard}/forgot-password', 'showForgotpassword')->name('auth.forgot');
                Route::post('/forgot-password', 'sendRestLink');
                //**Route  Auth Reset Password */
                Route::get('{guard}/reset-password/{token}', 'shoewResetPassword')->name('password.reset');
                Route::post('reset-password', 'resetPassword');
            });
        });

        Route::prefix('cms/admin')->middleware(['auth:admin,user,pharmacist'])->group(function () {
            Route::get('/', [HomeControler::class, 'test'])->name('dash');
            Route::resource('cities', CityController::class);
            Route::resource('/admins', AdminController::class);
            Route::resource('/pharmaceuticals', PharmaceuticalController::class);
            Route::resource('/pharmacists', PharmacistController::class);
            Route::resource('/deliveries', DeliveryController::class);
            Route::resource('/users', UserController::class);
            Route::resource('/orders', OrderController::class);
        });


        Route::prefix('cms/admin')->middleware(['auth:admin,user,pharmacist'])->group(function () {
            Route::resource('roles', Rolecontroller::class);
            Route::resource('permissions', PermissionController::class);
            Route::post('roles/permissions', [Rolecontroller::class, 'updateRolePermission']);
        });



        Route::prefix('cms/admin/')->controller(AuthController::class)->middleware(['auth:admin,user,pharmacist'])->group(function () {
            Route::get('logout', 'logout')->name('logout');
        });
    }
);
