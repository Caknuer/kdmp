<?php

use App\Http\Controllers\PublicMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicFinanceController;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::prefix('profil')->group(function () {
    Route::get('/tentang', fn () => view('public.profil.tentang'));
    Route::get('/pengurus', [PublicController::class, 'pengurus']);
    Route::get('/pengawas', [PublicController::class, 'pengawas']);
});


Route::get('/unit-bisnis', [PublicController::class, 'businessUnits'])->name('business.units');
Route::get('/unit-bisnis/{slug}', [PublicController::class, 'businessDetail'])->name('business.unit.detail');

Route::get('/mitra', [PublicController::class, 'partners'])->name('partners');

Route::get('/berita', [PublicController::class, 'articles'])->name('articles');
Route::get('/berita/{slug}', [PublicController::class, 'articleDetail'])->name('articles.detail');

Route::get('/transparansi', [PublicFinanceController::class, 'index'])
    ->name('finance.public');

Route::get('/daftar', [PublicMemberController::class, 'create']);
Route::post('/daftar', [PublicMemberController::class, 'store']);

Route::get('/cek-saldo', [PublicMemberController::class, 'balanceForm']);
Route::post('/cek-saldo', [PublicMemberController::class, 'checkBalance']);