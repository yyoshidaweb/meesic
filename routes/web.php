<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController; //アーティストコントローラー

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

/**
 * ArtistControllerのルーティンググループ
 */
// 未ログインユーザー用
Route::controller(ArtistController::class)->group(function () {
    Route::get('/artists', 'index')->name('artists.index');
});

// 認証済ユーザー用
Route::controller(ArtistController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::post('/artists', 'store')->name('artists.store');
    Route::delete('/artists/{artist}', 'destroy')->name('artists.destroy');
});

require __DIR__ . '/auth.php';
