<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Admin Authentication Controller
 * 
 * Handles admin login and logout operations.
 * Uses the 'admin' guard for authentication.
 * 
 * @package App\Http\Controllers\Admin
 */
class AdminAuthController extends Controller
{
    /**
     * Show the admin login form
     * 
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login request
     * 
     * Validates email and password, then authenticates the admin.
     * If authentication fails, redirects back with error message.
     * If successful, redirects to admin dashboard.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginStore(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $adminEmail = config('admin.email');
        $adminPassword = config('admin.password');

        // If the admin account has not been created yet, create it automatically
        if ($credentials['email'] === $adminEmail) {
            User::firstOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => 'Admin KDMP',
                    'password' => Hash::make($adminPassword),
                    'role' => 'admin',
                    'is_active' => true,
                ]
            );
        }

        // Attempt authentication using 'admin' guard and require the admin role
        if (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'admin',
        ])) {
            // Regenerate session for security
            $request->session()->regenerate();

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Berhasil login! Selamat datang di admin panel.');
        }

        // Authentication failed
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password salah. Pastikan akun Anda sudah terdaftar.',
            ])
            ->with('error', 'Login gagal. Silakan coba lagi.');
    }

    /**
     * Handle admin logout
     * 
     * Logs out the authenticated admin and destroys the session.
     * Redirects to login page with success message.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
