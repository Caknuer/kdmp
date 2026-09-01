<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .email-content {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            color: #b91c1c;
            margin-bottom: 20px;
        }
        .reset-button {
            display: inline-block;
            background: #b91c1c;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 10px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-content">
            <div class="header">
                <h1>Reset Password - KDMP Wonokerto</h1>
            </div>

            <p>Halo {{ $member->name }},</p>

            <p>Kami menerima permintaan untuk mereset password akun Anda di KDMP Wonokerto. Silakan klik tombol di bawah untuk melanjutkan proses reset password.</p>

            <a href="{{ $resetLink }}" class="reset-button">Reset Password</a>

            <p>Atau copy-paste link berikut ke browser Anda:</p>
            <p style="word-break: break-all; background: #f5f5f5; padding: 10px; border-radius: 4px;">{{ $resetLink }}</p>

            <div class="warning">
                <strong>⚠️ Penting:</strong> Link ini hanya berlaku selama 1 jam. Jika link sudah expired, silakan minta reset password baru melalui halaman login.
            </div>

            <p>Jika Anda tidak melakukan permintaan ini, silakan abaikan email ini dan password Anda tetap aman.</p>

            <div class="footer">
                <p>Email ini dikirimkan ke {{ $member->email }}</p>
                <p>© 2026 KDMP Wonokerto. Semua hak dilindungi.</p>
                <p>Jangan balas ke email ini. Untuk bantuan, hubungi admin kami.</p>
            </div>
        </div>
    </div>
</body>
</html>
