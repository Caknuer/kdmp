<?php

use App\Http\Controllers\PublicMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicFinanceController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminPartnerController;
use App\Http\Controllers\Admin\AdminBusinessUnitController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminPengurusController;
use App\Http\Controllers\Admin\AdminPengawasController;


Route::get('/', [PublicController::class, 'home'])->name('home');

Route::prefix('profil')->group(function () {
    Route::get('/tentang', [PublicController::class, 'tentang']);
    Route::get('/pengurus', [PublicController::class, 'pengurus']);
    Route::get('/pengawas', [PublicController::class, 'pengawas']);
});


Route::get('/unit-bisnis', [PublicController::class, 'businessUnits'])->name('public.business.index');
Route::get('/unit-bisnis/{slug}', [PublicController::class, 'businessDetail'])->name('public.business.detail');

Route::get('/mitra', [PublicController::class, 'partners'])->name('partners');

// TODO: Fix transparansi page - temporarily disabled
// Route::get('/transparansi', [PublicFinanceController::class, 'index'])
//     ->name('finance.public');
Route::redirect('/transparansi', '/')->name('finance.public');

Route::redirect('/daftar', '/')->name('register');
Route::redirect('/cek-saldo', '/')->name('member.balance.form');

Route::get('/login', [PublicMemberController::class, 'login'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [PublicMemberController::class, 'loginStore'])
    ->name('member.login.store')
    ->middleware('guest');

Route::get('/forgot-password', [PublicMemberController::class, 'forgotPassword'])
    ->name('member.forgot.password')
    ->middleware('guest');

Route::post('/forgot-password', [PublicMemberController::class, 'sendResetLink'])
    ->name('member.send.reset.link')
    ->middleware('guest');

Route::get('/reset-password/{token}', [PublicMemberController::class, 'resetPassword'])
    ->name('member.reset.password')
    ->middleware('guest');

Route::post('/reset-password/{token}', [PublicMemberController::class, 'updatePassword'])
    ->name('member.update.password')
    ->middleware('guest');

Route::post('/logout', [PublicMemberController::class, 'logout'])
    ->name('member.logout')
    ->middleware('auth:member');

Route::get('/dashboard', [PublicMemberController::class, 'dashboard'])
    ->name('member.dashboard')
    ->middleware('auth:member');

Route::get('/upload-documents', [PublicMemberController::class, 'uploadDocuments'])
    ->name('member.upload.documents')
    ->middleware('auth:member');

Route::post('/upload-documents', [PublicMemberController::class, 'storeDocuments'])
    ->name('member.upload.documents.store')
    ->middleware('auth:member');

Route::get('/informasi', [PublicPostController::class, 'informasiIndex']);
Route::get('/informasi/{slug}', [PublicPostController::class, 'informasiShow']);

Route::get('/berita', [PublicPostController::class, 'beritaIndex']);
Route::get('/berita/{slug}', [PublicPostController::class, 'beritaShow']);

Route::get('/pengumuman', [PublicPostController::class, 'pengumumanIndex']);
Route::get('/pengumuman/{slug}', [PublicPostController::class, 'pengumumanShow']);

// OPTIONAL: compatibility route lama
Route::get('/artikel', [PublicPostController::class, 'artikelRedirect']);
Route::get('/artikel/{slug}', [PublicPostController::class, 'artikelShowRedirect']);

// ============================================================
// ADMIN PANEL ROUTES (Manual Admin System)
// ============================================================
Route::prefix('admin')->group(function () {
    
    // Admin Authentication Routes (Guest only)
    Route::middleware('guest.admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'loginStore'])->name('admin.login.store');
    });

    // Admin Protected Routes (Authenticated admin only)
    Route::middleware('auth.admin')->group(function () {
        
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Admin Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        
        // ========== PENGURUS MANAGEMENT ==========
        Route::prefix('pengurus')->name('admin.pengurus.')->group(function () {
            Route::get('/', [AdminPengurusController::class, 'index'])->name('index');
            Route::get('/create', [AdminPengurusController::class, 'create'])->name('create');
            Route::post('/', [AdminPengurusController::class, 'store'])->name('store');
            Route::get('/{pengurus}/edit', [AdminPengurusController::class, 'edit'])->name('edit');
            Route::put('/{pengurus}', [AdminPengurusController::class, 'update'])->name('update');
            Route::delete('/{pengurus}', [AdminPengurusController::class, 'destroy'])->name('destroy');
        });

        // ========== PENGAWAS MANAGEMENT ==========
        Route::prefix('pengawas')->name('admin.pengawas.')->group(function () {
            Route::get('/', [AdminPengawasController::class, 'index'])->name('index');
            Route::get('/create', [AdminPengawasController::class, 'create'])->name('create');
            Route::post('/', [AdminPengawasController::class, 'store'])->name('store');
            Route::get('/{pengawas}/edit', [AdminPengawasController::class, 'edit'])->name('edit');
            Route::put('/{pengawas}', [AdminPengawasController::class, 'update'])->name('update');
            Route::delete('/{pengawas}', [AdminPengawasController::class, 'destroy'])->name('destroy');
        });

        // ========== MEMBERS MANAGEMENT ==========
        Route::prefix('members')->name('admin.members.')->group(function () {
            Route::get('/', [AdminMemberController::class, 'index'])->name('index');
            Route::get('/create', [AdminMemberController::class, 'create'])->name('create');
            Route::post('/', [AdminMemberController::class, 'store'])->name('store');
            Route::get('/{member}', [AdminMemberController::class, 'show'])->name('show');
            Route::get('/{member}/edit', [AdminMemberController::class, 'edit'])->name('edit');
            Route::put('/{member}', [AdminMemberController::class, 'update'])->name('update');
            Route::patch('/{member}/approve', [AdminMemberController::class, 'approve'])->name('approve');
            Route::delete('/{member}', [AdminMemberController::class, 'destroy'])->name('destroy');
        });

        // ========== ARTICLES MANAGEMENT ==========
        Route::prefix('articles')->name('admin.articles.')->group(function () {
            Route::get('/', [AdminArticleController::class, 'index'])->name('index');
            Route::get('/create', [AdminArticleController::class, 'create'])->name('create');
            Route::post('/', [AdminArticleController::class, 'store'])->name('store');
            Route::get('/{article}', [AdminArticleController::class, 'show'])->name('show');
            Route::get('/{article}/edit', [AdminArticleController::class, 'edit'])->name('edit');
            Route::put('/{article}', [AdminArticleController::class, 'update'])->name('update');
            Route::delete('/{article}', [AdminArticleController::class, 'destroy'])->name('destroy');
        });

        // ========== TRANSACTIONS MANAGEMENT ==========
        Route::prefix('transactions')->name('admin.transactions.')->group(function () {
            Route::get('/', [AdminTransactionController::class, 'index'])->name('index');
            Route::get('/create', [AdminTransactionController::class, 'create'])->name('create');
            Route::post('/', [AdminTransactionController::class, 'store'])->name('store');
            Route::get('/{transaction}', [AdminTransactionController::class, 'show'])->name('show');
            Route::get('/{transaction}/edit', [AdminTransactionController::class, 'edit'])->name('edit');
            Route::put('/{transaction}', [AdminTransactionController::class, 'update'])->name('update');
            Route::delete('/{transaction}', [AdminTransactionController::class, 'destroy'])->name('destroy');
        });

        // ========== PARTNERS MANAGEMENT ==========
        Route::prefix('partners')->name('admin.partners.')->group(function () {
            Route::get('/', [AdminPartnerController::class, 'index'])->name('index');
            Route::get('/create', [AdminPartnerController::class, 'create'])->name('create');
            Route::post('/', [AdminPartnerController::class, 'store'])->name('store');
            Route::get('/{partner}', [AdminPartnerController::class, 'show'])->name('show');
            Route::get('/{partner}/edit', [AdminPartnerController::class, 'edit'])->name('edit');
            Route::put('/{partner}', [AdminPartnerController::class, 'update'])->name('update');
            Route::delete('/{partner}', [AdminPartnerController::class, 'destroy'])->name('destroy');
        });

        // ========== BUSINESS UNITS MANAGEMENT ==========
        Route::prefix('business-units')->name('admin.business-units.')->group(function () {
            Route::get('/', [AdminBusinessUnitController::class, 'index'])->name('index');
            Route::get('/create', [AdminBusinessUnitController::class, 'create'])->name('create');
            Route::post('/', [AdminBusinessUnitController::class, 'store'])->name('store');
            Route::get('/{businessUnit}', [AdminBusinessUnitController::class, 'show'])->name('show');
            Route::get('/{businessUnit}/edit', [AdminBusinessUnitController::class, 'edit'])->name('edit');
            Route::put('/{businessUnit}', [AdminBusinessUnitController::class, 'update'])->name('update');
            Route::delete('/{businessUnit}', [AdminBusinessUnitController::class, 'destroy'])->name('destroy');
        });

        // ========== PROFILE MANAGEMENT ==========
        Route::prefix('profile')->name('admin.profile.')->group(function () {
            // Profile Dashboard
            Route::get('/', [AdminProfileController::class, 'index'])->name('index');

            // About Page
            Route::get('/about', [AdminProfileController::class, 'about'])->name('about');
            Route::post('/about', [AdminProfileController::class, 'aboutUpdate'])->name('about.update');

            // Organization Members
            Route::get('/members', [AdminProfileController::class, 'members'])->name('members');
            Route::get('/members/create', [AdminProfileController::class, 'membersCreate'])->name('members.create');
            Route::post('/members', [AdminProfileController::class, 'membersStore'])->name('members.store');
            Route::get('/members/{member}/edit', [AdminProfileController::class, 'membersEdit'])->name('members.edit');
            Route::put('/members/{member}', [AdminProfileController::class, 'membersUpdate'])->name('members.update');
            Route::delete('/members/{member}', [AdminProfileController::class, 'membersDestroy'])->name('members.destroy');
        });

        // ========== SETTINGS ==========
        Route::prefix('settings')->name('admin.settings.')->group(function () {
            Route::get('/', [AdminSettingController::class, 'index'])->name('index');
            Route::post('/', [AdminSettingController::class, 'store'])->name('store');
        });
    });
});
