<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Kantin Digital</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 36px 40px; text-align: center; }
        .header-icon { width: 56px; height: 56px; background: rgba(255,255,255,0.2); border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin: 0; }
        .header p { color: rgba(255,255,255,0.8); font-size: 13px; margin: 6px 0 0; }
        .body { padding: 36px 40px; }
        .body p { color: #475569; font-size: 14px; line-height: 1.7; margin: 0 0 16px; }
        .body .name { color: #1e293b; font-weight: 600; }
        .btn-wrap { text-align: center; margin: 28px 0; }
        .btn { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff !important; text-decoration: none; font-weight: 700; font-size: 15px; padding: 14px 36px; border-radius: 12px; letter-spacing: 0.3px; }
        .notice { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 10px; padding: 14px 18px; margin: 20px 0; }
        .notice p { color: #92400e; font-size: 13px; margin: 0; }
        .divider { border: none; border-top: 1px solid #e2e8f0; margin: 28px 0; }
        .url-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; word-break: break-all; }
        .url-box a { color: #6366f1; font-size: 12px; text-decoration: none; }
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { color: #94a3b8; font-size: 12px; margin: 0; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <div style="text-align:center; margin-bottom:12px;">
                <span style="font-size:28px;">🔐</span>
            </div>
            <h1>Reset Password</h1>
            <p>Kantin Digital SMKN 20 Jakarta</p>
        </div>

        <!-- Body -->
        <div class="body">
            <p>Halo, <span class="name">{{ $name }}</span>!</p>
            <p>Kami menerima permintaan untuk mereset password akun kamu. Klik tombol di bawah ini untuk membuat password baru:</p>

            <div class="btn-wrap">
                <a href="{{ $resetUrl }}" class="btn">Reset Password Sekarang</a>
            </div>

            <div class="notice">
                <p>⏱ Link ini akan <strong>kadaluarsa dalam {{ $expiry }} menit</strong>. Jika kamu tidak meminta reset password, abaikan email ini — akun kamu tetap aman.</p>
            </div>

            <hr class="divider">

            <p style="font-size:13px; color:#64748b;">Jika tombol di atas tidak berfungsi, salin dan tempelkan URL berikut ke browser kamu:</p>
            <div class="url-box">
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem.<br>Kantin Digital SMKN 20 Jakarta &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
