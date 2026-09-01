@extends('layouts.public')

@section('content')
<section class="container" style="padding: 60px 0;">
    <div style="max-width: 900px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <h1 style="margin: 0; font-size: 32px; font-weight: 800;">Dashboard Anggota</h1>
            <form method="POST" action="{{ route('member.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: #b91c1c; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    Logout
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert success" style="margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Nama Lengkap</div>
                <div style="font-size: 20px; font-weight: 700; color: #111827;">{{ auth('member')->user()->name }}</div>
            </div>

            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Email</div>
                <div style="font-size: 18px; font-weight: 600; color: #111827;">{{ auth('member')->user()->email }}</div>
            </div>

            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Kode Anggota</div>
                <div style="font-size: 18px; font-weight: 700; color: #b91c1c;">{{ auth('member')->user()->code }}</div>
            </div>

            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="color: #6b7280; font-size: 14px; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">Status Akun</div>
                <div style="font-size: 16px; font-weight: 700;">
                    @if(auth('member')->user()->status === 'approved')
                        <span style="color: #10b981; background: #ecfdf5; padding: 4px 12px; border-radius: 6px; display: inline-block;">✓ Disetujui</span>
                    @elseif(auth('member')->user()->status === 'pending')
                        <span style="color: #f59e0b; background: #fffbeb; padding: 4px 12px; border-radius: 6px; display: inline-block;">⏳ Menunggu</span>
                    @else
                        <span style="color: #ef4444; background: #fef2f2; padding: 4px 12px; border-radius: 6px; display: inline-block;">✕ Ditolak</span>
                    @endif
                </div>
            </div>
        </div>

        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h2 style="margin: 0 0 16px; font-size: 22px; font-weight: 700;">Informasi Akun</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
                <div>
                    <p style="margin: 0 0 8px; color: #6b7280; font-weight: 600;">NIK</p>
                    <p style="margin: 0; color: #111827; font-size: 16px; font-weight: 500;">{{ auth('member')->user()->nik }}</p>
                </div>
                <div>
                    <p style="margin: 0 0 8px; color: #6b7280; font-weight: 600;">No WhatsApp</p>
                    <p style="margin: 0; color: #111827; font-size: 16px; font-weight: 500;">{{ auth('member')->user()->phone }}</p>
                </div>
                <div>
                    <p style="margin: 0 0 8px; color: #6b7280; font-weight: 600;">Pekerjaan</p>
                    <p style="margin: 0; color: #111827; font-size: 16px; font-weight: 500;">{{ auth('member')->user()->job }}</p>
                </div>
                <div>
                    <p style="margin: 0 0 8px; color: #6b7280; font-weight: 600;">Jenis Kelamin</p>
                    <p style="margin: 0; color: #111827; font-size: 16px; font-weight: 500;">
                        @if(auth('member')->user()->gender === 'male')
                            Laki-laki
                        @elseif(auth('member')->user()->gender === 'female')
                            Perempuan
                        @else
                            Lainnya
                        @endif
                    </p>
                </div>
                <div>
                    <p style="margin: 0 0 8px; color: #6b7280; font-weight: 600;">Tanggal Pendaftaran</p>
                    <p style="margin: 0; color: #111827; font-size: 16px; font-weight: 500;">{{ auth('member')->user()->registered_at->format('d M Y') }}</p>
                </div>
                <div>
                    <p style="margin: 0 0 8px; color: #6b7280; font-weight: 600;">Alamat</p>
                    <p style="margin: 0; color: #111827; font-size: 16px; font-weight: 500;">{{ auth('member')->user()->address }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
