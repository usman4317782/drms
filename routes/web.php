<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ProfileController;

/** Admin Controllers */

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CampController as AdminCampController;
use App\Http\Controllers\Admin\UrgentNeedController as AdminUrgentNeedController;

/** Manager Controllers */

use App\Http\Controllers\Manager\CampController as ManagerCampController;
use App\Http\Controllers\Manager\UrgentNeedController as ManagerUrgentNeedController;
use App\Http\Controllers\Manager\TaskController as ManagerTaskController;

/** Supporter Controllers */

use App\Http\Controllers\Supporter\ProfileController as SupporterProfileController;
use App\Http\Controllers\Supporter\TaskController as SupporterTaskController;

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

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/blank', 'blank')->name('blank');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN MODULE
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function () {
        Route::resource('users', AdminUserController::class);
        Route::resource('supporters', \App\Http\Controllers\Admin\SupporterController::class);
        Route::resource('camps', AdminCampController::class);
        Route::resource('urgent-needs', AdminUrgentNeedController::class)->only(['index', 'edit', 'update', 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | CAMP MANAGER MODULE
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:camp_manager')->prefix('manager')->as('manager.')->group(function () {
        // Camps (Assigned only)
        Route::controller(ManagerCampController::class)->prefix('camps')->as('camps.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{camp}/edit', 'edit')->name('edit');
            Route::put('/{camp}', 'update')->name('update');
        });

        // Urgent Needs & Tasks
        Route::resource('urgent-needs', ManagerUrgentNeedController::class);
        Route::resource('tasks', ManagerTaskController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | SUPPORTER MODULE
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:supporter,donor,volunteer')->prefix('supporter')->as('supporter.')->group(function () {
        // Profile
        Route::controller(SupporterProfileController::class)->group(function () {
            Route::get('profile', 'edit')->name('profile.edit');
            Route::patch('profile', 'update')->name('profile.update');
        });

        // Marketplace & Task Management
        Route::controller(SupporterTaskController::class)->prefix('tasks')->as('tasks.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/my', 'myTasks')->name('my');
            Route::post('/{task}/accept', 'accept')->name('accept');
            Route::post('/{task}/complete', 'complete')->name('complete');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
