<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DriverManagementController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\UserController;

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
Route::get('event/{event}', [EventController::class, 'show'])->name('event.show');

Route::get('series/create', [SeriesController::class, 'create'])->name('series.create');
Route::put('series', [SeriesController::class, 'store'])->name('series.store');
Route::get('series/{series}/dropone', [SeriesController::class, 'showDropOne'])->name('series.showDropOne');
Route::get('series/{series}', [SeriesController::class, 'show'])->name('series.show');

Route::get('randomizer', [HomeController::class, 'randomizer'])->name('randomizer');

Route::get('admin/users', [UserManagementController::class, 'index'])->name('admin.users');
Route::get('admin/drivers', [DriverManagementController::class, 'index'])->name('admin.drivers');
Route::get('admin/sgptoken', [AdminController::class, 'sgpToken'])->name('admin.sgpToken');
Route::get('admin/neededtracks', [AdminController::class, 'neededTracks'])->name('admin.neededTracks');
Route::get('admin/importevent', [AdminController::class, 'importEvent'])->name('admin.importEvent');

Route::get('user', [UserController::class, 'show'])->name('user.show');

Route::get('invite', [InviteController::class, 'index'])->name('invite.index');
Route::get('invite/{invite:code}', [InviteController::class, 'show'])->name('invite.show');

Route::get('dev', [DevController::class, 'index'])->name('dev');
