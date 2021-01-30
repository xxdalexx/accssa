<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminGivePenaltiesController;
use App\Http\Controllers\Admin\AdminManageUsersController;
use App\Http\Controllers\Admin\AdminManageDriversController;
use App\Http\Controllers\Admin\AdminManageSeriesController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('open/randomizer', [HomeController::class, 'randomizer'])->name('randomizer');
Route::get('open/practice-config', [HomeController::class, 'practiceConfig'])->name('practiceConfig');
Route::get('open/add-driver', [HomeController::class, 'addDriver'])->name('addDriver');
Route::get('invite', [InviteController::class, 'index'])->name('invite.index');
Route::get('invite/{invite:code}', [InviteController::class, 'show'])->name('invite.show');
Route::get('reset-password/{reset:code}', [InviteController::class, 'showReset'])->name('password-reset.show');

Route::middleware('auth')->group(function () {
    Route::get('new', [HomeController::class, 'new']);
    Route::get('event/{event}', [EventController::class, 'show'])->name('event.show');
    Route::get('series/create', [SeriesController::class, 'create'])->name('series.create');
    Route::put('series', [SeriesController::class, 'store'])->name('series.store');
    Route::get('series/{series}/dropone', [SeriesController::class, 'showDropOne'])->name('series.showDropOne');
    Route::get('series/{series}', [SeriesController::class, 'show'])->name('series.show');

    Route::get('admin/users', [AdminManageUsersController::class, 'index'])->name('admin.users');
    Route::get('admin/drivers', [AdminManageDriversController::class, 'index'])->name('admin.drivers');
    Route::get('admin/sgp-token', [AdminController::class, 'sgpToken'])->name('admin.sgpToken');
    Route::get('admin/needed-tracks', [AdminManageSeriesController::class, 'neededTracks'])->name('admin.neededTracks');
    Route::get('admin/import-event', [AdminManageSeriesController::class, 'importEvent'])->name('admin.importEvent');
    Route::get('admin/lock-override', [AdminManageSeriesController::class, 'lockOverride'])->name('admin.lockOverride');
    Route::get('admin/pre-event', [AdminManageSeriesController::class, 'preEvent'])->name('admin.preEvent');
    Route::get('admin/incident-settings', [AdminGivePenaltiesController::class, 'incidentSettings'])->name('admin.incidents');

    Route::get('admin/permissions', [AdminController::class, 'permissions'])->name('admin.permissions');
    Route::get('admin/discord/message-everyone', [AdminController::class, 'discordMassMessage'])->name('admin.discordMassMessage');
    Route::get('admin/discord', [AdminController::class, 'discord'])->name('admin.discord');

    Route::get('user', [UserController::class, 'show'])->name('user.show');

    Route::get('dev/login/{user}', [DevController::class, 'loginAs'])->name('dev.loginAs');
    Route::get('dev', [DevController::class, 'index'])->name('dev');
});
