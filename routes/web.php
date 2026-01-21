<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\GoogleCallbackController;
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
        Route::get('/user/profile', 'profile');
        Route::post('/logout', 'logout');
    });

    Route::middleware(['ifAdmin'])->group(function() {
        Route::prefix('admin')->controller(\App\Http\Controllers\Admin\DashboardController::class)->group(function(){
            Route::get('/', 'index');
            Route::get('/cutting-permit', 'pendingCuttingPermit');
            Route::get('/number-donors', 'getNumberOfDonors');
        });

        Route::prefix('admin')->controller(\App\Http\Controllers\Admin\AdminCuttingPermitController::class)->group(function(){
            // Route::get('/', 'index');
            Route::get('/permit/view/{cuttingPermit}', 'show');
        });
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

    Route::prefix('/admin/applicants')->controller(\App\Http\Controllers\Admin\DonorController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/register', 'addDonor');
        Route::get('/{donor}/edit', 'edit');
        Route::get('/{donor}/donate-page', 'donatePage');
        Route::post('/{donor}/edit-confirm', 'editConfirm');
        Route::post('/{donor}/update', 'update');
        Route::delete('/{donor}/delete', 'delete');
        Route::delete('/{donor}/approved', 'approved');
        Route::get('/{donor}/view', 'donor');
        Route::get('/{donor}/show', 'show');
        Route::get('/{donation_id}/donation', 'getDonationHistory');
        Route::post('/{donor}/confirm-donate', 'confirmDondate');
        Route::post('/store', 'store');
        Route::post('/store-confirm', 'confirm');
    });

    Route::prefix('donor-page')->controller(\App\Http\Controllers\Admin\DonorController::class)->group(function(){
        Route::get('/', 'donorUser');
        Route::get('/requests', 'donorRequest');
    });


    Route::prefix('departments')->controller(\App\Http\Controllers\Admin\DepartmentConroller::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/{department}', 'show');
        Route::get('/head-history/{department}', 'headHistories');
        Route::post('/store', 'store');
        Route::delete('/delete/{department}', 'delete');
        Route::post('/update/{department}', 'update');
    });

    Route::prefix('inventory')->controller(\App\Http\Controllers\Admin\BloodInventoryController::class)->group(function(){
        Route::get('/', 'index');
    });

    Route::prefix('events')->controller(\App\Http\Controllers\Admin\EventController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/{event}', 'show');
        Route::post('/store', 'store');
        Route::delete('/delete/{event}', 'delete');
        Route::post('/update/{event}', 'update');
    });

    Route::prefix('blood-issuance')->controller(\App\Http\Controllers\Admin\BloodIssuanceController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/history', 'history');
        Route::get('/get-serial-number', 'getSerialNumber');
        Route::post('/store', 'store');
        Route::post('/store-confirm', 'confirm');
    });

    Route::prefix('/admin/app-review')->controller(\App\Http\Controllers\Admin\PatientController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/register', 'create');
        Route::get('/{patient}/show', 'show');
        Route::get('/{patient}/edit', 'edit');
        Route::post('/store', 'store');
        Route::post('/{patient}/update', 'store');
        Route::post('/store-confirm', 'confirm');
        Route::delete('/{patient}/delete', 'delete');
    });

    Route::prefix('/admin/reports')->controller(\App\Http\Controllers\Admin\ReportController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/export', 'export');
    });

    Route::prefix('notifications')->controller(\App\Http\Controllers\NotificationController::class)->group(function(){
        Route::get('/clear', 'destroy');
        Route::get('/request/{donor}', 'request');
    });

    Route::middleware(['ifAdmin'])->prefix('audit-trails')->controller(\App\Http\Controllers\AuditTrailController::class)->group(function(){
        Route::get('/', 'index');
    });

    Route::middleware(['ifAdmin'])->prefix('settings')->controller(\App\Http\Controllers\SettingsController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/update', 'update');
    });

    Route::prefix('/applicant')->controller(\App\Http\Controllers\ApplicantController::class)->group(function(){
        Route::get('/dashboard', 'index');
        Route::get('/chainsaw', 'chainsaw');
        Route::get('/cutting', 'cutting');
        Route::get('/permit', 'permit');
        Route::get('/requirements', 'requirements');
        Route::get('/treeRegistration', 'treeRegistration');
        Route::get('/settings', 'settings');
    });

    Route::prefix('/applicant/trees')->controller(\App\Http\Controllers\TreeController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/view/{tree}', 'show');
        Route::get('/edit/{tree}', 'edit');
        Route::get('/trees-list', 'treesList');
        Route::post('/store', 'store');
        Route::post('/update/{tree}', 'update');
        Route::post('/cancel/{tree}', 'cancel');
        Route::post('/store/chainsaw', 'storeChainsaw');
    });

    Route::prefix('/applicant/chainsaw')->controller(\App\Http\Controllers\ChainsawController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/view/{chainsaw}', 'show');
        Route::get('/edit/{chainsaw}', 'edit');
        Route::get('/register', 'create');
        Route::get('/list', 'list');
        Route::post('/store', 'store');
        Route::post('/update/{chainsaw}', 'update');
        Route::post('/cancel/{chainsaw}', 'cancel');
    });

    Route::prefix('/applicant/cutting-permit')->controller(\App\Http\Controllers\CuttingPermitController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/register', 'create');
        Route::get('/view/{cutting_permit}', 'show');
        Route::get('/list', 'list');
        Route::post('/store', 'store');
        Route::post('/cancel/{cuttingPermit}', 'cancel');
    });

    Route::prefix('/applicant/profile')->controller(\App\Http\Controllers\ProfileSettingController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/change-password', 'changePassword');
        Route::post('/update', 'update');
        Route::post('/update-image', 'updateProfileImage');
    });
});

Route::controller(\App\Http\Controllers\Client\AuthController::class)->group(function(){
    Route::post('/login', 'login');
    Route::get('/', 'index')->name('login');
    Route::get('/register', 'create')->name('register');
    Route::get('/register/account-setup/{donor}', 'setup')->name('setup');
    Route::post('/register/account-setup/{donor}', 'setupStore')->name('setup-store');
    Route::post('/store', 'store')->name('user.store');
    Route::post('/store/confirm', 'confirm')->name('user.confirm');
});

Route::controller(AddressController::class)->group(function () {
    Route::get('/province', 'province');
    Route::get('/city', 'city');
    Route::get('/barangay', 'barangay');
});

Route::prefix('/auth/google')->controller(GoogleCallbackController::class)->group(function () {
    Route::get('/', 'redirectToGoogle');
    Route::get('/callback', 'handleGoogleCallback');
});
