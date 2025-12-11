<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verifikasi Disetujui — SiToko</title>
    <style>
        body{margin:0;background:#f7fafc;color:#1f2937;font-family:Arial,Helvetica,sans-serif}
        .container{max-width:640px;margin:24px auto;padding:0 16px}
        .card{background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;box-shadow:0 8px 24px rgba(0,0,0,.06)}
        .header{background:linear-gradient(90deg,#34d399,#10b981);padding:20px;color:#fff}
        .brand{font-weight:700;letter-spacing:.5px}
        .content{padding:24px}
        .title{font-size:20px;font-weight:700;margin:0 0 8px}
        .subtitle{font-size:14px;color:#6b7280;margin:0 0 16px}
        .info{background:#f9fafb;border:1px solid #eef2f7;border-radius:10px;padding:16px;margin:16px 0}
        .info p{margin:6px 0;font-size:14px}
        .btn{display:inline-block;background:#10b981;color:#fff;text-decoration:none;padding:10px 16px;border-radius:8px;font-weight:700}
        .footer{padding:16px;color:#6b7280;font-size:12px;text-align:center;border-top:1px solid #f1f5f9}
    </style>
    </head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="brand">SiToko</div>
            </div>
            <div class="content">
                <h2 class="title">Pengajuan Verifikasi Disetujui</h2>
                <p class="subtitle">Halo {{ $seller->user->name }},</p>
                <p>Selamat! Pengajuan verifikasi penjual untuk toko <strong>{{ $seller->shop_name }}</strong> telah <strong>disetujui</strong>.</p>
                <div class="info">
                    <p><strong>Status:</strong> Terverifikasi</p>
                    <p><strong>Akun:</strong> {{ $seller->user->email }}</p>
                </div>
                <p>Akun Anda sudah aktif. Silakan login untuk mulai mengelola toko:</p>
                <p style="margin-top:12px;">
                    <a class="btn" href="{{ url('/login-seller') }}">Masuk ke Seller</a>
                </p>
            </div>
            <div class="footer">
                &copy; {{ date('Y') }} SiToko — Bantuan: support@sitoko.local
            </div>
        </div>
    </div>
</body>
</html>
