<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Registrasi Penjual</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: { 500: '#FF9894', 600: '#FF8585' },
                        dark: '#2D3748'
                    }
                }
            }
        }
    </script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            min-height: 100vh; width: 100%;
            background: linear-gradient(180deg, #FF9894 0%, #FFBFC0 35%, #FFDCDC 65%, #FFEBEB 100%);
            display: flex; flex-direction: column;
        }
        nav {
            background-color: white; padding: 15px 50px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 18px; color: #000; text-decoration: none; }
        .nav-logo i { color: #FF8585; font-size: 24px; }
        .nav-login-text { color: #FF8585; font-weight: 500; font-size: 14px; background: #FFF0F0; padding: 5px 15px; border-radius: 20px; }
        
        .main-layout {
            flex: 1; display: flex; justify-content: center; align-items: flex-start;
            padding: 40px 80px; gap: 80px; max-width: 1400px; margin: 0 auto; width: 100%;
        }
        .left-branding { text-align: center; display: flex; flex-direction: column; align-items: center; position: sticky; top: 120px; }
        .big-icon { font-size: 120px; color: white; margin-bottom: 10px; text-shadow: 0px 4px 10px rgba(0,0,0,0.1); }
        .brand-title { font-size: 36px; font-weight: 600; color: #2D3748; }

        .login-card {
            background-color: white; padding: 40px; border-radius: 20px; width: 700px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08); margin-bottom: 40px;
        }
        .login-header {
            font-size: 22px; font-weight: 700; margin-bottom: 25px; color: #2D3748;
            text-align: center; border-bottom: 2px solid #FFEBEB; padding-bottom: 20px;
        }
        .section-title {
            font-size: 15px; font-weight: 600; color: #FF8585; margin-top: 30px; margin-bottom: 15px;
            display: flex; align-items: center; gap: 10px; background: #FFF5F5; padding: 8px 12px; border-radius: 8px;
        }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 500; color: #4A5568; }
        .form-input {
            width: 100%; padding: 12px 15px; background-color: #F9FAFB; border: 1px solid #E2E8F0;
            border-radius: 8px; font-size: 14px; color: #2D3748; outline: none; transition: all 0.3s;
        }
        .form-input:focus { background-color: #fff; border-color: #FF9894; box-shadow: 0 0 0 3px rgba(255, 152, 148, 0.2); }
        .form-input:disabled { background-color: #E2E8F0; cursor: not-allowed; }
        
        .btn-register {
            width: 100%; padding: 15px; background-color: #FF7A7A; color: white; border: none;
            border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 122, 122, 0.3); transition: transform 0.2s, background 0.3s; margin-top: 30px;
            display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .btn-register:hover { background-color: #ff6363; transform: translateY(-2px); }
        .btn-register:disabled { background-color: #FAB2B2; cursor: not-allowed; transform: none; }
        
        .btn-cancel { background-color: transparent; color: #718096; border: 1px solid #E2E8F0; box-shadow: none; margin-top: 15px; }
        .btn-cancel:hover { background-color: #F7FAFC; color: #4A5568; transform: none; }
        
        .card-footer { margin-top: 25px; text-align: center; font-size: 13px; color: #718096; }
        .card-footer a { color: #FF7A7A; text-decoration: none; font-weight: 600; }

        /* Loader Icon Animation */
        .loader {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: none; /* Hidden by default */
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        footer { background-color: white; padding: 60px 80px 30px; border-top: 1px solid #FFEBEB; margin-top: auto; }
        .footer-content { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; }
        .footer-brand p { font-size: 14px; color: #718096; margin-top: 15px; line-height: 1.6; max-width: 300px; }
        .footer-heading { font-size: 16px; font-weight: 700; color: #2D3748; margin-bottom: 20px; }
        .footer-links ul { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { text-decoration: none; color: #718096; font-size: 14px; transition: color 0.3s; }
        .footer-links a:hover { color: #FF7A7A; }
        .social-icons a {
            display: inline-flex; justify-content: center; align-items: center; width: 36px; height: 36px;
            background-color: #FFF5F5; color: #FF7A7A; border-radius: 50%; margin-right: 10px; transition: all 0.3s;
        }
        .social-icons a:hover { background-color: #FF7A7A; color: white; }
        .footer-bottom { max-width: 1400px; margin: 50px auto 0; padding-top: 30px; border-top: 1px solid #EDF2F7; text-align: center; font-size: 13px; color: #A0AEC0; }

        @media (max-width: 900px) {
            .main-layout { flex-direction: column; align-items: center; gap: 40px; padding: 20px; }
            .left-branding { position: static; margin-bottom: 20px; }
            .login-card { width: 100%; }
            .footer-content { grid-template-columns: 1fr; gap: 30px; text-align: center; }
        }
    </style>
</head>
<body>

    <nav id="navbar">
        <div class="nav-left">
            <a href="/" class="nav-logo">
                <i class="fas fa-shopping-cart"></i>
                <span>SiToko</span>
            </a>
        </div>
        <div class="nav-login-text">Registrasi Penjual</div>
    </nav>

    <div class="main-layout">
        
        <div class="left-branding animate-on-scroll opacity-0 transition-all duration-700 translate-y-10">
            <i class="fas fa-store big-icon"></i>
            <h1 class="brand-title">SiToko Seller</h1>
            <p class="mt-2 text-gray-700 font-medium">Platform Terpercaya untuk Bisnis Anda</p>
            <div class="mt-6 space-y-2 text-sm text-gray-600 hidden md:block">
                <p><i class="fas fa-check-circle text-primary-600 mr-2"></i>Jangkauan Luas</p>
                <p><i class="fas fa-check-circle text-primary-600 mr-2"></i>Pembayaran Aman</p>
                <p><i class="fas fa-check-circle text-primary-600 mr-2"></i>Layanan 24/7</p>
            </div>
        </div>

        <div class="login-card animate-on-scroll opacity-0 transition-all duration-700 delay-200 translate-y-10">
            <h2 class="login-header">Formulir Registrasi Toko Baru</h2>
            
            <form id="sellerRegisterForm" enctype="multipart/form-data">
                
                <div class="section-title"><i class="fas fa-store"></i> Data Toko</div>
                <div class="form-group">
                    <label class="form-label">Nama Toko*</label>
                    <input type="text" name="nama_toko" class="form-input" placeholder="Contoh: Toko Berkah Jaya" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="deskripsi_toko" class="form-input" placeholder="Jelaskan produk unggulan toko Anda..." style="min-height: 80px; resize: vertical;"></textarea>
                </div>

                <div class="section-title"><i class="fas fa-user-tie"></i> Data Penanggung Jawab (PIC)</div>
                <div class="form-group">
                    <label class="form-label">Nama Lengkap PIC*</label>
                    <input type="text" name="nama_pic" class="form-input" placeholder="Sesuai KTP" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">No. Handphone*</label>
                        <input type="tel" name="no_hp_pic" class="form-input" placeholder="08xxxxxxxxxx" pattern="[0-9]{10,15}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Aktif*</label>
                        <input type="email" name="email_pic" class="form-input" placeholder="nama@email.com" required>
                    </div>
                </div>

                <div class="section-title"><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</div>
                <div class="form-group">
                    <label class="form-label">Nama Jalan / Gedung*</label>
                    <input type="text" name="jalan" class="form-input" placeholder="Jl. Merdeka No. 45" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">RT*</label>
                        <input type="number" name="rt" class="form-input" placeholder="001" min="0" step="1" inputmode="numeric" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">RW*</label>
                        <input type="number" name="rw" class="form-input" placeholder="005" min="0" step="1" inputmode="numeric" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kelurahan/Desa*</label>
                    <input type="text" name="kelurahan" class="form-input" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Provinsi*</label>
                        <div class="relative">
                            <select id="select-provinsi" class="form-input cursor-pointer appearance-none" required>
                                <option value="">Pilih Provinsi...</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                            <input type="hidden" name="provinsi" id="input-provinsi-nama">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kabupaten/Kota*</label>
                        <div class="relative">
                            <select name="kota" id="select-kota" class="form-input cursor-pointer appearance-none" disabled required>
                                <option value="">Pilih Provinsi Dulu</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-title"><i class="fas fa-id-card"></i> Dokumen Legalitas</div>
                <div class="form-group">
                    <label class="form-label">No. KTP PIC*</label>
                    <input type="text" name="no_ktp" class="form-input" placeholder="16 digit NIK" pattern="[0-9]{16}" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label class="form-label">Foto Diri PIC (Max 2MB)*</label>
                        <input type="file" name="foto_pic" class="form-input" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Scan KTP (Max 5MB)*</label>
                        <input type="file" name="file_ktp" class="form-input" accept=".jpg,.jpeg,.png,.pdf" required>
                    </div>
                </div>

                <div class="section-title"><i class="fas fa-shield-alt"></i> Keamanan Akun</div>
                
                <div class="form-group">
                    <label class="form-label">Password*</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="form-input pr-10" placeholder="Min. 8 karakter" required>
                        <span class="absolute inset-y-0 right-0 flex items-center px-3 cursor-pointer text-gray-500 hover:text-primary-600" onclick="togglePassword('password', 'icon-pass')">
                            <i class="fas fa-eye" id="icon-pass"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password*</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input pr-10" placeholder="Ulangi Password" required>
                        <span class="absolute inset-y-0 right-0 flex items-center px-3 cursor-pointer text-gray-500 hover:text-primary-600" onclick="togglePassword('password_confirmation', 'icon-confirm')">
                            <i class="fas fa-eye" id="icon-confirm"></i>
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 flex items-start gap-2">
                    <input type="checkbox" id="agree" required class="mt-1">
                    <label for="agree" class="text-xs text-gray-600">Saya menyetujui <a href="#" class="text-primary-600 hover:underline">Syarat & Ketentuan</a>.</label>
                </div>

                <button type="submit" class="btn-register" id="btn-submit">
                    <span class="loader" id="btn-loader"></span>
                    <span id="btn-text">DAFTAR SEKARANG</span>
                </button>
                <button type="button" class="btn-register btn-cancel" onclick="window.location.href='/'">Batalkan</button>
            </form>

            <div class="card-footer">
                Sudah punya akun? <a href="/login-seller">Masuk di sini</a>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <div class="nav-logo">
                    <i class="fas fa-shopping-cart"></i>
                    <span>SiToko</span>
                </div>
                <p>Platform marketplace terdepan yang menghubungkan penjual berkualitas dengan jutaan pelanggan di seluruh Indonesia.</p>
                <div class="social-icons mt-4">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h3 class="footer-heading">SiToko</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3 class="footer-heading">Bantuan</h3>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Panduan Penjual</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3 class="footer-heading">Kontak</h3>
                <ul>
                    <li class="flex items-start gap-2 text-sm text-gray-500">
                        <i class="fas fa-map-marker-alt mt-1 text-primary-600"></i>
                        <span>Jl. Pemuda No. 123, Semarang</span>
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-envelope text-primary-600"></i>
                        <span>support@sitoko.id</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">&copy; 2025 SiToko Marketplace. All rights reserved.</div>
    </footer>

    <button id="scrollToTop" class="fixed bottom-8 right-8 bg-primary-600 text-white p-4 rounded-full shadow-lg translate-y-20 opacity-0 transition-all duration-300 hover:bg-red-500 z-50">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <script>
        // 1. Toggle Password
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye');
            }
        }

        // 2. Dropdown Wilayah (API)
        const apiBaseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';
        const selectProvinsi = document.getElementById('select-provinsi');
        const selectKota = document.getElementById('select-kota');
        const inputProvinsiNama = document.getElementById('input-provinsi-nama');

        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch(`${apiBaseUrl}/provinces.json`);
                const provinces = await response.json();
                provinces.forEach(prov => {
                    const option = document.createElement('option');
                    option.value = prov.id; option.text = prov.name; option.setAttribute('data-name', prov.name);
                    selectProvinsi.appendChild(option);
                });
            } catch (error) { console.error('Error:', error); }
        });

        selectProvinsi.addEventListener('change', async function() {
            const provId = this.value;
            const provName = this.options[this.selectedIndex].getAttribute('data-name');
            if(provName) inputProvinsiNama.value = provName;

            selectKota.innerHTML = '<option value="">Memuat...</option>';
            selectKota.disabled = true;

            if (!provId) { selectKota.innerHTML = '<option value="">Pilih Provinsi Dulu</option>'; return; }

            try {
                const response = await fetch(`${apiBaseUrl}/regencies/${provId}.json`);
                const regencies = await response.json();
                selectKota.innerHTML = '<option value="">Pilih Kota/Kabupaten...</option>';
                regencies.forEach(kota => {
                    const option = document.createElement('option');
                    option.value = kota.name; option.text = kota.name;
                    selectKota.appendChild(option);
                });
                selectKota.disabled = false;
            } catch (error) { selectKota.innerHTML = '<option value="">Gagal memuat data</option>'; }
        });

        // 3. SUBMIT HANDLER (Updated for SRS-MartPlace-02)
        document.getElementById('sellerRegisterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validasi Password
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            if (pass !== confirm) { alert('Password dan Konfirmasi Password tidak cocok!'); return; }

            // Validasi RT / RW: boleh 0 atau angka positif (>= 0)
            const rtInput = document.querySelector('input[name="rt"]');
            const rwInput = document.querySelector('input[name="rw"]');
            const rtVal = rtInput ? parseInt(rtInput.value, 10) : NaN;
            const rwVal = rwInput ? parseInt(rwInput.value, 10) : NaN;
            if (isNaN(rtVal) || rtVal < 0) { alert('RT harus berupa angka (>= 0).'); rtInput && rtInput.focus(); return; }
            if (isNaN(rwVal) || rwVal < 0) { alert('RW harus berupa angka (>= 0).'); rwInput && rwInput.focus(); return; }

            // Validasi File
            const fotoPic = document.querySelector('input[name="foto_pic"]').files[0];
            const fileKtp = document.querySelector('input[name="file_ktp"]').files[0];
            if(fotoPic && fotoPic.size > 2 * 1024 * 1024) { alert('Ukuran Foto PIC terlalu besar (Max 2MB).'); return; }
            if(fileKtp && fileKtp.size > 5 * 1024 * 1024) { alert('Ukuran File KTP terlalu besar (Max 5MB).'); return; }

            // Loading Effect
            const btnSubmit = document.getElementById('btn-submit');
            const btnLoader = document.getElementById('btn-loader');
            const btnText = document.getElementById('btn-text');
            
            btnSubmit.disabled = true;
            btnLoader.style.display = 'block';
            btnText.textContent = 'MENGIRIM DATA...';

            // Simulate Server Process Delay
            setTimeout(() => {
                // PESAN ALERT SESUAI SRS-MartPlace-02
                alert(
                    "REGISTRASI BERHASIL DIKIRIM!\n\n" +
                    "Data Anda sedang dalam proses VERIFIKASI oleh Admin untuk pengecekan kelengkapan administrasi.\n\n" +
                    "Mohon tunggu notifikasi DITERIMA atau DITOLAK melalui EMAIL.\n" +
                    "Jika diterima, email akan berisi link aktivasi akun Anda."
                );

                // Reset Button & Form
                btnSubmit.disabled = false;
                btnLoader.style.display = 'none';
                btnText.textContent = 'DAFTAR SEKARANG';
                document.getElementById('sellerRegisterForm').reset();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                
            }, 2000); // Delay 2 detik
        });

        // Scroll Animation
        const navbar = document.getElementById('navbar');
        const scrollBtn = document.getElementById('scrollToTop');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { entry.target.classList.remove('opacity-0', 'translate-y-10'); observer.unobserve(entry.target); }
            });
        });
        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) navbar.classList.add('shadow-md'); else navbar.classList.remove('shadow-md');
            if (window.scrollY > 300) scrollBtn.classList.remove('translate-y-20', 'opacity-0'); else scrollBtn.classList.add('translate-y-20', 'opacity-0');
        });
        scrollBtn.addEventListener('click', () => { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    </script>
</body>
</html>