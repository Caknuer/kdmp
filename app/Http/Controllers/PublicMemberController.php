<?php

namespace App\Http\Controllers;

use App\Mail\MemberRegistrationMail;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PublicMemberController extends Controller
{
    public function create()
    {
        return view('public.members.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'nik'         => ['required', 'string', 'max:32', 'unique:members,nik'],
            'email'       => ['required', 'email', 'max:255', 'unique:members,email'],
            'address'     => ['required', 'string'],
            'phone'       => ['required', 'string', 'max:30'],
            'gender'      => ['required', 'string', 'in:male,female,other'],
            'position'  => ['required', 'string', 'in:pengawas,pengurus,anggota'],
            'role'      => ['required', 'string', 'in:pengawas,pengurus,anggota'],
            'job'       => ['required', 'string', 'max:255'],
            'ktp_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'photo_3x4' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'position.required' => 'Posisi wajib dipilih.',
            'role.required' => 'Role wajib dipilih.',
            'job.required' => 'Pekerjaan wajib diisi.',
            'ktp_photo.required' => 'Foto KTP wajib diupload.',
            'ktp_photo.image' => 'File KTP harus berupa gambar.',
            'ktp_photo.mimes' => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 2MB.',
            'photo_3x4.required' => 'Foto 3x4 wajib diupload.',
            'photo_3x4.image' => 'File foto 3x4 harus berupa gambar.',
            'photo_3x4.mimes' => 'Format foto 3x4 harus JPG, JPEG, atau PNG.',
            'photo_3x4.max' => 'Ukuran foto 3x4 maksimal 2MB.',
        ], [
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'position.required' => 'Posisi wajib dipilih.',
            'role.required' => 'Role wajib dipilih.',
            'job.required' => 'Pekerjaan wajib diisi.',
            'ktp_photo.required' => 'Foto KTP wajib diupload.',
            'ktp_photo.image' => 'File KTP harus berupa gambar.',
            'ktp_photo.mimes' => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 2MB.',
            'photo_3x4.required' => 'Foto 3x4 wajib diupload.',
            'photo_3x4.image' => 'File foto 3x4 harus berupa gambar.',
            'photo_3x4.mimes' => 'Format foto 3x4 harus JPG, JPEG, atau PNG.',
            'photo_3x4.max' => 'Ukuran foto 3x4 maksimal 2MB.',
        ]);

        $code = $this->generateCode();
        $plainPassword = Str::random(10);

        $ktpPath = $request->file('ktp_photo')->store('ktp', 'public');
        $photo3x4Path = $request->file('photo_3x4')->store('photos_3x4', 'public');

        $member = Member::create([
            'code'            => $code,
            'name'            => $data['name'],
            'nik'             => $data['nik'],
            'email'           => $data['email'],
            'password'        => Hash::make($plainPassword),
            'address'         => $data['address'],
            'phone'           => $data['phone'],
            'gender'          => $data['gender'],
            'position'        => $data['position'],
            'role'            => $data['role'],
            'job'             => $data['job'],
            'ktp_photo_path'  => $ktpPath,
            'foto_3x4_path'   => $photo3x4Path,
            'status'          => 'pending',
            'approved_at'     => null,
            'registered_at'   => now(),
        ]);

        // Send registration email with credentials
        Mail::to($member->email)->send(new MemberRegistrationMail($member, $plainPassword));

        return redirect()
            ->back()
            ->with('success', 'Berhasil mendaftar! Silakan cek email Anda untuk menerima kredensial login.')
            ->with('code', $member->code)
            ->with('password', $plainPassword);
    }

    public function balanceForm()
    {
        return view('public.check_balance');
    }

    public function checkBalance(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $member = Member::where('code', $data['code'])->first();

        if (! $member) {
            return back()->withErrors(['code' => 'Kode tidak ditemukan.'])->withInput();
        }

        if ($member->status !== 'approved') {
            return view('public.balance_result', [
                'member'  => $member,
                'status'  => $member->status,
                'balance' => null,
                'message' => 'Akun masih menunggu konfirmasi admin.',
            ]);
        }

        return view('public.balance_result', [
            'member'  => $member,
            'status'  => $member->status,
            'balance' => $member->balance,
            'message' => null,
        ]);
    }

    public function login()
    {
        return view('public.members.login');
    }

    public function loginStore(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $member = Member::where('email', $data['email'])->first();

        if (! $member || ! Hash::check($data['password'], $member->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        if ($member->status !== 'approved') {
            return back()->withErrors(['email' => 'Akun Anda masih menunggu persetujuan admin.'])->withInput();
        }

        Auth::guard('member')->login($member, $request->boolean('remember'));

        return redirect()
            ->route('member.dashboard')
            ->with('success', 'Selamat datang, ' . $member->name . '!');
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }

    public function dashboard()
    {
        return view('public.members.dashboard');
    }

    private function generateCode(): string
    {
        $date = now()->format('Ymd');

        do {
            $suffix = strtoupper(Str::random(6));
            $code = "KDMP-{$date}-{$suffix}";
        } while (Member::where('code', $code)->exists());

        return $code;
    }
}
