<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class MemberDocumentUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nik'         => ['required', 'string', 'max:32', 'unique:members,nik,' . auth()->id()],
            'address'     => ['required', 'string'],
            'phone'       => ['required', 'string', 'max:30'],
            'gender'      => ['required', 'string', 'in:male,female,other'],
            'position'    => ['required', 'string', 'in:pengawas,pengurus,anggota'],
            'job'         => ['required', 'string', 'max:255'],
            'ktp_photo'   => ['required', File::image()->types(['jpg', 'jpeg', 'png'])->max(2048)],
            'photo_3x4'   => ['required', File::image()->types(['jpg', 'jpeg', 'png'])->max(2048)],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required'          => 'NIK wajib diisi.',
            'nik.unique'            => 'NIK sudah terdaftar.',
            'address.required'      => 'Alamat lengkap wajib diisi.',
            'phone.required'        => 'Nomor WhatsApp wajib diisi.',
            'gender.required'       => 'Jenis kelamin wajib dipilih.',
            'position.required'     => 'Posisi wajib dipilih.',
            'job.required'          => 'Pekerjaan wajib diisi.',
            'ktp_photo.required'    => 'Foto KTP wajib diupload.',
            'ktp_photo.image'       => 'File KTP harus berupa gambar.',
            'ktp_photo.mimes'       => 'Format foto KTP harus JPG, JPEG, atau PNG.',
            'ktp_photo.max'         => 'Ukuran foto KTP maksimal 2MB.',
            'photo_3x4.required'    => 'Foto 3x4 wajib diupload.',
            'photo_3x4.image'       => 'File foto 3x4 harus berupa gambar.',
            'photo_3x4.mimes'       => 'Format foto 3x4 harus JPG, JPEG, atau PNG.',
            'photo_3x4.max'         => 'Ukuran foto 3x4 maksimal 2MB.',
        ];
    }
}
