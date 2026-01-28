<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicMemberController extends Controller
{
    public function create()
    {
        return view('public.register'); // form daftar
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'nik' => ['required','string','max:32','unique:members,nik'],
            'address' => ['required','string'],
            'phone' => ['required','string','max:30'],
            'ktp_photo' => ['required','image','mimes:jpg,jpeg,png','max:2048'],
        ]);

        $code = $this->generateCode();

        $path = $request->file('ktp_photo')->store('ktp', 'public');

        $member = Member::create([
            'code' => $code,
            'name' => $data['name'],
            'nik' => $data['nik'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'ktp_photo_path' => $path,
            'status' => 'pending',
        ]);

        return view('public.register_success', [
            'code' => $member->code,
        ]);
    }

    public function balanceForm()
    {
        return view('public.check_balance'); // form input code
    }

    public function checkBalance(Request $request)
    {
        $data = $request->validate([
            'code' => ['required','string'],
        ]);

        $member = Member::where('code', $data['code'])->first();

        if (! $member) {
            return back()->withErrors(['code' => 'Kode tidak ditemukan.']);
        }

        if ($member->status !== 'approved') {
            return view('public.balance_result', [
                'status' => $member->status,
                'message' => 'Akun masih menunggu konfirmasi admin.',
                'balance' => null,
                'member' => $member,
            ]);
        }

        return view('public.balance_result', [
            'status' => $member->status,
            'message' => null,
            'balance' => $member->balance, // dari accessor
            'member' => $member,
        ]);
    }

    private function generateCode(): string
    {
        // contoh: KDMP-20260128-AB12CD
        $date = now()->format('Ymd');
        do {
            $suffix = strtoupper(Str::random(6));
            $code = "KDMP-{$date}-{$suffix}";
        } while (Member::where('code', $code)->exists());

        return $code;
    }
}

