<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SeriesController;

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
Route::get('series/{series}/dropone', [SeriesController::class, 'showDropOne'])->name('series.showDropOne');
Route::get('series/{series}', [SeriesController::class, 'show'])->name('series.show');
Route::get('randomizer', [HomeController::class, 'randomizer'])->name('randomizer');

Route::get('dev', [DevController::class, 'index'])->name('dev');
