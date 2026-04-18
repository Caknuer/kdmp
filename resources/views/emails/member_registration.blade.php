<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f9fafb;
        }
        .header {
            background: #b91c1c;
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: white;
            padding: 30px 20px;
        }
        .content h2 {
            margin: 0 0 16px;
            color: #111;
            font-size: 22px;
        }
        .credential-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #b91c1c;
            padding: 16px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .credential-item {
            margin: 12px 0;
        }
        .credential-label {
            font-weight: 700;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .credential-value {
            color: #111;
            font-size: 16px;
            font-family: monospace;
            margin-top: 4px;
            background: white;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        .button {
            display: inline-block;
            background: #b91c1c;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
        }
        .footer {
            background: #f3f4f6;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            border-radius: 0 0 8px 8px;
        }
        .warning {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            padding: 12px 16px;
            border-radius: 4px;
            margin: 16px 0;
            color: #78350f;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 28px;">Selamat Datang!</h1>
        </div>

        <div class="content">
            <h2>Halo {{ $member->name }},</h2>

            <p>Terima kasih telah mendaftar sebagai anggota Koperasi Desa Merah Putih (KDMP). Akun Anda telah berhasil dibuat dan siap untuk digunakan.</p>

            <p>Gunakan kredensial di bawah untuk login ke akun Anda:</p>

            <div class="credential-box">
                <div class="credential-item">
                    <div class="credential-label">Kode Anggota</div>
                    <div class="credential-value">{{ $member->code }}</div>
                </div>
                <div class="credential-item">
                    <div class="credential-label">Email</div>
                    <div class="credential-value">{{ $member->email }}</div>
                </div>
                <div class="credential-item">
                    <div class="credential-label">Password Sementara</div>
                    <div class="credential-value">{{ $password }}</div>
                </div>
            </div>

            <div class="warning">
                <strong>⚠️ Penting:</strong> Simpan password ini dengan aman. Anda dapat mengubahnya setelah login pertama kali.
            </div>

            <p>Akun Anda masih dalam status <strong>"Menunggu Konfirmasi Admin"</strong>. Admin akan melakukan verifikasi data Anda. Anda akan menerima notifikasi ketika akun Anda disetujui.</p>

            <a href="{{ route('member.login') }}" class="button">Login ke Akun Saya</a>

            <hr style="margin: 24px 0; border: none; border-top: 1px solid #e5e7eb;">

            <p style="font-size: 13px; color: #6b7280;">
                <strong>Data Pendaftaran:</strong><br>
                Nama: {{ $member->name }}<br>
                NIK: {{ $member->nik }}<br>
                Email: {{ $member->email }}<br>
                No WhatsApp: {{ $member->phone }}<br>
                Tanggal Pendaftaran: {{ $member->registered_at->format('d M Y') }}
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0;">Jika Anda mengalami kesulitan, hubungi admin melalui WhatsApp: {{ setting('whatsapp') ?? '+62-xxx' }}</p>
            <p style="margin: 8px 0 0;">&copy; 2026 Koperasi Desa Merah Putih. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
