<?php

use App\Http\Controllers\PublicMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicFinanceController;
use App\Http\Controllers\PublicPostController;
use App\Models\AboutPage;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::prefix('profil')->group(function () {
    Route::get('/tentang', function () {
        $about = AboutPage::where('slug', 'tentang-kdmp')->first();

        // fallback kalau record belum ada
        if (! $about) {
            $about = new AboutPage([
                'profil_singkat' => '',
                'visi' => '',
                'misi' => [],
                'nilai' => [],
            ]);
        }

        return view('public.profil.tentang-kdmp', compact('about'));
    });
    Route::get('/pengurus', [PublicController::class, 'pengurus']);
    Route::get('/pengawas', [PublicController::class, 'pengawas']);
});


Route::get('/unit-bisnis', [PublicController::class, 'businessUnits'])->name('public.business.index');
Route::get('/unit-bisnis/{slug}', [PublicController::class, 'businessDetail'])->name('public.business.detail');

Route::get('/mitra', [PublicController::class, 'partners'])->name('partners');


Route::get('/transparansi', [PublicFinanceController::class, 'index'])
    ->name('finance.public');

Route::get('/daftar', [PublicMemberController::class, 'create'])
    ->name('member.register');

Route::post('/daftar', [PublicMemberController::class, 'store'])
    ->name('member.register.store');

Route::get('/cek-saldo', [PublicMemberController::class, 'balanceForm'])
    ->name('member.balance.form');

Route::post('/cek-saldo', [PublicMemberController::class, 'checkBalance'])
    ->name('member.balance.check');

Route::get('/informasi', [PublicPostController::class, 'informasiIndex']);

Route::get('/berita', [PublicPostController::class, 'beritaIndex']);
Route::get('/berita/{slug}', [PublicPostController::class, 'beritaShow']);

Route::get('/pengumuman', [PublicPostController::class, 'pengumumanIndex']);
Route::get('/pengumuman/{slug}', [PublicPostController::class, 'pengumumanShow']);

// OPTIONAL: compatibility route lama
Route::get('/artikel', [PublicPostController::class, 'artikelRedirect']);
Route::get('/artikel/{slug}', [PublicPostController::class, 'artikelShowRedirect']);
