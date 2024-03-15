<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController; //アーティストコントローラー
use App\Http\Controllers\SpotifyArtistController;
use Faker\Guesser\Name;

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
 * SpotifyArtistControllerのルーティンググループ
 */
// ログイン済みユーザー用
Route::controller(SpotifyArtistController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::post('/spotify/store-spotify-id', 'storeSpotifyId')->name('spotify.storeSpotifyId');
    Route::delete('/spotify/{spotify_id}', 'detach')->name('spotify.detach');
});

// 未ログインユーザー用
Route::controller(SpotifyArtistController::class)->group(function () {
});

/**
 * ArtistControllerのルーティンググループ
 */
// ログイン済ユーザー用
Route::controller(ArtistController::class)->middleware(['auth', 'verified'])->group(function () {
    // アーティストリスト編集画面を表示する
    Route::get('/artists/edit-artists', 'editArtists')->name('artists.editArtists');
    // アーティストを検索する
    Route::post('/artists/edit-artists', 'searchArtists')->name('artists.searchArtists');
    // アーティスト追加を実行する
    Route::post('/artists', 'add')->name('artists.add');
    // アーティスト削除を実行する
    Route::delete('/artists/{artist}', 'detach')->name('artists.detach');
});

// auth.phpファイル内のルーティングを読み込む
require __DIR__ . '/auth.php';

// 未ログインユーザー用 (注意: 優先順位を最下位にするため最下部に記述する必要あり)
Route::controller(ArtistController::class)->group(function () {
    // アーティストリストを表示する
    Route::get('/{url_name}', 'index')->name('artists.index');
});
