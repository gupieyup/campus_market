<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verifikasi Ditolak — SiToko</title>
    <style>
        body{margin:0;background:#f7fafc;color:#1f2937;font-family:Arial,Helvetica,sans-serif}
        .container{max-width:640px;margin:24px auto;padding:0 16px}
        .card{background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;box-shadow:0 8px 24px rgba(0,0,0,.06)}
        .header{background:linear-gradient(90deg,#fca5a5,#ef4444);padding:20px;color:#fff}
        .brand{font-weight:700;letter-spacing:.5px}
        .content{padding:24px}
        .title{font-size:20px;font-weight:700;margin:0 0 8px}
        .subtitle{font-size:14px;color:#6b7280;margin:0 0 16px}
        .info{background:#fff7f7;border:1px solid #fee2e2;border-radius:10px;padding:16px;margin:16px 0}
        .info p{margin:6px 0;font-size:14px}
        .btn{display:inline-block;background:#ef4444;color:#fff;text-decoration:none;padding:10px 16px;border-radius:8px;font-weight:700}
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
                <h2 class="title">Pengajuan Verifikasi Ditolak</h2>
                <p class="subtitle">Halo {{ $seller->user->name }},</p>
                <p>Mohon maaf, pengajuan verifikasi penjual untuk toko <strong>{{ $seller->shop_name }}</strong> <strong>ditolak</strong>.</p>
                <div class="info">
                    <p><strong>Alasan Penolakan:</strong> {{ $seller->rejection_reason ?? ($reason ?? '-') }}</p>
                </div>
                <p>Silakan perbaiki kelengkapan dokumen sesuai alasan di atas, lalu ajukan kembali verifikasi. Jika membutuhkan bantuan, hubungi tim kami.</p>
                <p style="margin-top:12px;">
                    <a class="btn" href="{{ url('/support') }}">Hubungi Dukungan</a>
                </p>
            </div>
            <div class="footer">
                &copy; {{ date('Y') }} SiToko — Bantuan: support@sitoko.local
            </div>
        </div>
    </div>
</body>
</html>
