<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckBalanceRequest;
use App\Http\Requests\MemberLoginRequest;
use App\Http\Requests\MemberRegistrationRequest;
use App\Http\Requests\MemberDocumentUploadRequest;
use App\Mail\MemberRegistrationMail;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class PublicMemberController extends Controller
{
    /* ==========================================================
       1. REGISTRATION
    ========================================================== */

    public function create()
    {
        return view('public.members.register', [
            'pageTitle' => 'Pendaftaran Anggota',
            'pageDescription' => 'Daftar sebagai anggota KDMP Wonokerto.',
        ]);
    }

    public function store(MemberRegistrationRequest $request)
    {
        $data = $request->validated();

        try {
            $member = DB::transaction(function () use ($data) {
                return Member::create([
                    'code'                => $this->generateUniqueCode(),
                    'name'                => $data['name'],
                    'email'               => $data['email'],
                    'password'            => Hash::make($data['password']),
                    'role'                => $data['role'],
                    'status'              => $data['role'] === 'platinum' ? 'approved' : 'pending',
                    'documents_uploaded'  => false,
                    'registered_at'       => now(),
                ]);
            });

            $message = $data['role'] === 'platinum'
                ? 'Berhasil mendaftar sebagai anggota Platinum! Silakan login dan lengkapi dokumen Anda.'
                : 'Berhasil mendaftar sebagai anggota Premium! Akun Anda akan diaktifkan setelah verifikasi dokumen.';

            return redirect()
                ->back()
                ->with('success', $message)
                ->with('code', $member->code);

        } catch (Throwable $e) {
            Log::error('Member registration failed', [
                'error' => $e->getMessage(),
                'email' => $data['email'] ?? null,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi atau hubungi admin.')
                ->withInput();
        }
    }

    /* ==========================================================
       2. LOGIN / LOGOUT
    ========================================================== */

    public function login()
    {
        return view('public.members.login', [
            'pageTitle' => 'Login Anggota',
            'pageDescription' => 'Masuk ke akun anggota KDMP Wonokerto.',
        ]);
    }

    public function loginStore(MemberLoginRequest $request)
    {
        $data = $request->validated();

        $member = Member::where('email', $data['email'])->first();

        if (! $member || ! Hash::check($data['password'], $member->password)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        if ($member->status !== 'approved') {
            return back()
                ->withErrors(['email' => 'Akun Anda masih menunggu persetujuan admin.'])
                ->withInput($request->only('email'));
        }

        Auth::guard('member')->login($member, $request->wantsRemember());

        $request->session()->regenerate();

        Log::info('Member logged in', ['member_id' => $member->id, 'email' => $member->email]);

        // Check if documents need to be uploaded
        if (!$member->documents_uploaded) {
            return redirect()
                ->route('member.upload.documents')
                ->with('info', 'Silakan lengkapi dokumen Anda untuk melanjutkan.');
        }

        return redirect()
            ->route('member.dashboard')
            ->with('success', 'Selamat datang, ' . $member->name . '!');
    }

    public function logout(Request $request)
    {
        $memberName = auth('member')->user()?->name;

        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Member logged out', ['member_name' => $memberName]);

        return redirect()
            ->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /* ==========================================================
       3. PASSWORD RESET
    ========================================================== */

    public function forgotPassword()
    {
        return view('public.members.forgot-password', [
            'pageTitle' => 'Lupa Password',
            'pageDescription' => 'Reset password akun anggota KDMP Wonokerto.',
        ]);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:members,email']
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar.',
        ]);

        $member = Member::where('email', $request->email)->first();

        // Generate reset token
        $resetToken = Str::random(64);
        
        // Store token in cache (valid for 1 hour)
        cache()->put('password_reset_' . $resetToken, $member->id, now()->addHours(1));

        // Send email with reset link
        try {
            Mail::send('emails.password-reset', [
                'member' => $member,
                'resetLink' => route('member.reset.password', ['token' => $resetToken])
            ], function ($message) use ($member) {
                $message->to($member->email)
                    ->subject('Reset Password - KDMP Wonokerto');
            });

            return redirect()
                ->back()
                ->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek email Anda.');
        } catch (Throwable $e) {
            Log::error('Failed to send password reset email', [
                'error' => $e->getMessage(),
                'email' => $member->email,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal mengirim email. Silakan coba lagi atau hubungi admin.')
                ->withInput();
        }
    }

    public function resetPassword($token)
    {
        // Check if token is valid
        $memberId = cache()->get('password_reset_' . $token);
        
        if (!$memberId) {
            return redirect()
                ->route('member.forgot.password')
                ->with('error', 'Link reset password tidak valid atau sudah expired. Silakan minta ulang.');
        }

        return view('public.members.reset-password', [
            'pageTitle' => 'Reset Password',
            'token' => $token,
        ]);
    }

    public function updatePassword(Request $request, $token)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        // Verify token
        $memberId = cache()->get('password_reset_' . $token);
        
        if (!$memberId) {
            return redirect()
                ->route('member.forgot.password')
                ->with('error', 'Link reset password tidak valid atau sudah expired.');
        }

        try {
            $member = Member::findOrFail($memberId);
            $member->update(['password' => Hash::make($request->password)]);

            // Clear the reset token
            cache()->forget('password_reset_' . $token);

            return redirect()
                ->route('login')
                ->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');

        } catch (Throwable $e) {
            Log::error('Failed to update password', [
                'error' => $e->getMessage(),
                'member_id' => $memberId,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal mereset password. Silakan coba lagi.')
                ->withInput();
        }
    }

    /* ==========================================================
       4. DOCUMENT UPLOAD
    ========================================================== */

    public function uploadDocuments()
    {
        $member = auth('member')->user();

        // Jika sudah upload dokumen, redirect ke dashboard
        if ($member->documents_uploaded) {
            return redirect()->route('member.dashboard');
        }

        return view('public.members.upload-documents', [
            'pageTitle' => 'Lengkapi Dokumen',
            'member'    => $member,
        ]);
    }

    public function storeDocuments(MemberDocumentUploadRequest $request)
    {
        $member = auth('member')->user();
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, $member) {
                $ktpPath = $data['ktp_photo']->store('ktp', 'public');
                $photo3x4Path = $data['photo_3x4']->store('photos_3x4', 'public');

                $member->update([
                    'nik'                  => $data['nik'],
                    'address'              => $data['address'],
                    'phone'                => $data['phone'],
                    'gender'               => $data['gender'],
                    'position'             => $data['position'],
                    'job'                  => $data['job'],
                    'ktp_photo_path'       => $ktpPath,
                    'foto_3x4_path'        => $photo3x4Path,
                    'documents_uploaded'   => true,
                    'documents_uploaded_at' => now(),
                    // Jika role premium, status tetap pending untuk approval admin
                    'status'               => $member->role === 'premium' ? 'pending' : 'approved',
                ]);
            });

            $message = $member->role === 'premium'
                ? 'Dokumen berhasil diupload! Akun Anda akan diaktifkan setelah verifikasi oleh admin.'
                : 'Dokumen berhasil diupload! Akun Anda sudah aktif.';

            return redirect()
                ->route('member.dashboard')
                ->with('success', $message);

        } catch (Throwable $e) {
            Log::error('Document upload failed', [
                'error' => $e->getMessage(),
                'member_id' => $member->id,
                'email' => $member->email,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat upload dokumen. Silakan coba lagi.')
                ->withInput();
        }
    }

    /* ==========================================================
       4. CHECK BALANCE (Public)
    ========================================================== */

    public function balanceForm()
    {
        return view('public.check_balance', [
            'pageTitle' => 'Cek Saldo Anggota',
            'pageDescription' => 'Cek saldo tabungan anggota KDMP Wonokerto.',
        ]);
    }

    public function checkBalance(CheckBalanceRequest $request)
    {
        $code = $request->validated('code');

        $member = Member::where('code', $code)->first();

        if (! $member) {
            return back()
                ->withErrors(['code' => 'Kode anggota tidak ditemukan.'])
                ->withInput();
        }

        return view('public.balance_result', [
            'pageTitle' => 'Hasil Cek Saldo',
            'member'    => $member,
            'status'    => $member->status,
            'balance'   => $member->status === 'approved' ? $member->balance : null,
            'message'   => $member->status !== 'approved'
                ? 'Akun masih menunggu konfirmasi admin.'
                : null,
        ]);
    }

    /* ==========================================================
       PRIVATE HELPERS
    ========================================================== */

    /**
     * Generate kode unik anggota dengan format KDMP-YYYYMMDD-XXXXXX.
     */
    private function generateUniqueCode(): string
    {
        $date = now()->format('Ymd');

        do {
            $suffix = strtoupper(Str::random(6));
            $code = "KDMP-{$date}-{$suffix}";
        } while (Member::where('code', $code)->exists());

        return $code;
    }

    /**
     * Kirim email pendaftaran dengan error handling.
     */
    /**
     * Kirim email pendaftaran dengan password.
     * Password dikirim via email (di-queue) dan tidak disimpan di log/session.
     */
    private function sendRegistrationEmail(Member $member, string $plainPassword): void
    {
        try {
            Mail::to($member->email)->queue(
                new MemberRegistrationMail($member, $plainPassword)
            );

            Log::info('Registration email queued', [
                'member_id' => $member->id,
                'email'     => $member->email,
            ]);
        } catch (Throwable $e) {
            Log::warning('Failed to queue registration email', [
                'member_id' => $member->id,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}

