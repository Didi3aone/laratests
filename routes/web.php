<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ProduserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\NegaraController;
use App\Http\Controllers\ArtisController;

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

Route::resource('film', FilmController::class);
Route::resource('produser', ProduserController::class);
Route::resource('genre', GenreController::class);
Route::resource('negara', NegaraController::class);
Route::resource('artis', ArtisController::class);
