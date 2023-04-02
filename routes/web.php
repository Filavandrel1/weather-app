<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;

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

Route::resource('weather', WeatherController::class)->only(['index', 'create', 'store']);
Route::get('weather/{post}', [WeatherController::class, 'show'])->name('weather.show');
Route::get('weather/{post}/edit', [WeatherController::class, 'edit'])->name('weather.edit');
Route::put('weather/{post}', [WeatherController::class, 'update'])->name('weather.update');
Route::delete('weather/{post}', [WeatherController::class, 'destroy'])->name('weather.destroy');

Route::delete('image/{postimage}', [ImageController::class, 'destroy'])->name('image.destroy');
Route::put('image/{postimage}', [ImageController::class, 'update'])->name('image.update');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
Route::delete('comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

require __DIR__ . '/auth.php';
