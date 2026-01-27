<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Str;

class MemberRegistrationController extends Controller
{
    public function create()
    {
        return view('public.members.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'nik'     => 'required|digits:16|unique:members,nik',
            'address' => 'required|string',
            'phone'   => 'required|string|max:20',
            'ktp_file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // simpan file KTP
        $ktpPath = $request->file('ktp_file')->store('ktp', 'public');

        // kode akses unik
        $accessCode = strtoupper(Str::random(8));

        Member::create([
            'name'        => $validated['name'],
            'nik'         => $validated['nik'],
            'address'     => $validated['address'],
            'phone'       => $validated['phone'],
            'ktp_file'    => $ktpPath,
            'access_code' => $accessCode,
            'is_active'   => false,
        ]);

        return redirect()
        ->route('member.register')
        ->with('success', 'Pendaftaran berhasil. Silakan tunggu konfirmasi admin.');
    }
}
