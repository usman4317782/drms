<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/** Admin Controllers */

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CampController as AdminCampController;
use App\Http\Controllers\Admin\UrgentNeedController as AdminUrgentNeedController;
use App\Http\Controllers\Admin\SupporterController as AdminSupporterController;
use App\Http\Controllers\Admin\OversightController as AdminOversightController;
use App\Http\Controllers\Admin\DonationOverviewController as AdminDonationOverviewController;

/** Manager Controllers */

use App\Http\Controllers\Manager\CampController as ManagerCampController;
use App\Http\Controllers\Manager\UrgentNeedController as ManagerUrgentNeedController;
use App\Http\Controllers\Manager\TaskController as ManagerTaskController;
use App\Http\Controllers\Manager\DonationDistributionController as ManagerDonationDistributionController;

/** Supporter Controllers */

use App\Http\Controllers\Supporter\ProfileController as SupporterProfileController;
use App\Http\Controllers\Supporter\TaskController as SupporterTaskController;
use App\Http\Controllers\Supporter\DonationController as SupporterDonationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');

/*
|--------------------------------------------------------------------------
| Authenticated & Verified Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * Common Core Routes
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/blank', 'blank')->name('blank');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    /**
     * ADMIN MODULE: System Management & Monitoring
     */
    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function () {
        // Resources
        Route::resource('users', AdminUserController::class);
        Route::resource('supporters', AdminSupporterController::class);
        Route::resource('camps', AdminCampController::class);
        Route::resource('urgent-needs', AdminUrgentNeedController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::get('donations', [AdminDonationOverviewController::class, 'index'])->name('donations.index');
        Route::get('donations/{donation}', [AdminDonationOverviewController::class, 'show'])->name('donations.show');

        // Oversight & Audit
        Route::controller(AdminOversightController::class)->prefix('oversight')->as('oversight.')->group(function () {
            Route::get('/tasks', 'tasks')->name('tasks');
            Route::get('/tasks/{task}', 'show')->name('show');
        });
    });

    /**
     * CAMP MANAGER MODULE: Operational Management
     */
    Route::middleware('role:camp_manager')->prefix('manager')->as('manager.')->group(function () {
        // Camps (Assigned limited access)
        Route::controller(ManagerCampController::class)->prefix('camps')->as('camps.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{camp}/edit', 'edit')->name('edit');
            Route::put('/{camp}', 'update')->name('update');
        });

        // Resources
        Route::resource('urgent-needs', ManagerUrgentNeedController::class);
        Route::resource('tasks', ManagerTaskController::class);
        Route::get('donations', [ManagerDonationDistributionController::class, 'index'])->name('donations.index');
        Route::patch('donations/{donation}/status', [ManagerDonationDistributionController::class, 'updateStatus'])->name('donations.update_status');
    });

    /**
     * SUPPORTER MODULE: Engagement & Execution
     */
    Route::middleware('role:supporter,donor,volunteer')->prefix('supporter')->as('supporter.')->group(function () {
        // Supporter Profile
        Route::controller(SupporterProfileController::class)->group(function () {
            Route::get('profile', 'edit')->name('profile.edit');
            Route::patch('profile', 'update')->name('profile.update');
        });

        // Task Marketplace & Management
        Route::controller(SupporterTaskController::class)->prefix('tasks')->as('tasks.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/my', 'myTasks')->name('my');
            Route::post('/{task}/accept', 'accept')->name('accept');
            Route::post('/{task}/complete', 'complete')->name('complete');
        });

        // Donations
        Route::controller(SupporterDonationController::class)->prefix('donations')->as('donations.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create-bulk', 'bulkCreate')->name('bulk');
            Route::post('/', 'store')->name('store');
            Route::post('/bulk', 'bulkStore')->name('bulk_store');
            Route::patch('/{donation}', 'update')->name('update');
            Route::delete('/{donation}', 'destroy')->name('destroy');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Authentication Layer
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
