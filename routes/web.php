<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'PreventBackHistory'])->group(function(){
    Route::controller(\App\Http\Controllers\Client\AuthController::class)->group(function(){
        Route::get('/user', 'user');
        Route::post('/logout', 'logout');
    });

    Route::prefix('admin')->controller(\App\Http\Controllers\Admin\DashboardController::class)->group(function(){
        Route::get('/', 'index');
    });

    Route::prefix('users')->controller(\App\Http\Controllers\Admin\UsersController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/register', 'addUser');
        Route::post('/store', 'store');
        Route::delete('/delete/{user}', 'delete');
        Route::post('/deactivate/{user}', 'deactivate');
        Route::get('/edit/{user}', 'editUser');
        Route::post('/update/{user}', 'update');
    });

    Route::prefix('donors')->controller(\App\Http\Controllers\Admin\DonorController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/register', 'addDonor');
        Route::get('/{donor}/edit', 'edit');
        Route::get('/{donor}/donate-page', 'donatePage');
        Route::post('/{donor}/edit-confirm', 'editConfirm');
        Route::post('/{donor}/update', 'update');
        Route::delete('/{donor}/delete', 'delete');
        Route::get('/{donor}/view', 'donor');
        Route::get('/{donation_id}/donation', 'getDonationHistory');
        Route::post('/{donor}/confirm-donate', 'confirmDondate');
        Route::post('/store', 'store');
        Route::post('/store-confirm', 'confirm');
    });

    Route::prefix('departments')->controller(\App\Http\Controllers\Admin\DepartmentConroller::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/{department}', 'show');
        Route::post('/store', 'store');
        Route::delete('/delete/{department}', 'delete');
        Route::post('/update/{department}', 'update');
    });

    Route::prefix('inventory')->controller(\App\Http\Controllers\Admin\BloodInventoryController::class)->group(function(){
        Route::get('/', 'index');
        // Route::get('/{department}', 'show');
        // Route::post('/store', 'store');
        // Route::delete('/delete/{department}', 'delete');
        // Route::post('/update/{department}', 'update');
    });

    Route::prefix('events')->controller(\App\Http\Controllers\Admin\EventController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/{event}', 'show');
        Route::post('/store', 'store');
        Route::delete('/delete/{event}', 'delete');
        Route::post('/update/{event}', 'update');
    });
});

Route::controller(\App\Http\Controllers\Client\AuthController::class)->group(function(){
    Route::post('/login', 'login');
    Route::get('/', 'index')->name('login');
});

Route::controller(AddressController::class)->group(function () {
    Route::get('/province', 'province');
    Route::get('/city', 'city');
    Route::get('/barangay', 'barangay');
});
