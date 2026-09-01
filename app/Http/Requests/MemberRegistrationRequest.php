<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class MemberRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:members,email'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'role'        => ['required', 'string', 'in:platinum,premium'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique'            => 'Email sudah terdaftar.',
            'name.required'           => 'Nama lengkap wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Format email tidak valid.',
            'password.required'       => 'Password wajib diisi.',
            'password.min'            => 'Password minimal 8 karakter.',
            'password.confirmed'      => 'Konfirmasi password tidak sesuai.',
            'role.required'           => 'Tipe keanggotaan wajib dipilih.',
            'role.in'                 => 'Tipe keanggotaan tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'      => 'Nama Lengkap',
            'nik'       => 'NIK',
            'email'     => 'Email',
            'phone'     => 'Nomor WhatsApp',
            'gender'    => 'Jenis Kelamin',
            'position'  => 'Posisi',
            'role'      => 'Role',
            'job'       => 'Pekerjaan',
            'address'   => 'Alamat Lengkap',
            'ktp_photo' => 'Foto KTP',
            'photo_3x4' => 'Foto 3x4',
        ];
    }
}

