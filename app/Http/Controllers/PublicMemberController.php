<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
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
        ]);

        $code = $this->generateCode();

        $ktpPath = $request->file('ktp_photo')->store('ktp', 'public');
        $photo3x4Path = $request->file('photo_3x4')->store('photos_3x4', 'public');

        $member = Member::create([
            'code'            => $code,
            'name'            => $data['name'],
            'nik'             => $data['nik'],
            'email'           => $data['email'],
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

        return redirect()
            ->back()
            ->with('success', 'Berhasil mendaftar, silakan tunggu konfirmasi admin.')
            ->with('code', $member->code);
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
