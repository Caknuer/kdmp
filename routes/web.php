<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/profil/{slug}', [PublicController::class, 'profile'])->name('profile');
Route::get('/profil/tentang', [PublicController::class, 'tentang']);

Route::get('/unit-bisnis', [PublicController::class, 'businessUnits'])->name('business.units');
Route::get('/unit-bisnis/{slug}', [PublicController::class, 'businessDetail'])->name('business.unit.detail');

Route::get('/mitra', [PublicController::class, 'partners'])->name('partners');

Route::get('/berita', [PublicController::class, 'articles'])->name('articles');
Route::get('/berita/{slug}', [PublicController::class, 'articleDetail'])->name('articles.detail');

Route::get('/transparansi', [PublicController::class, 'finance'])->name('finance');
