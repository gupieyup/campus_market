<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Login Penjual</title>
    
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
        /* Base Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            min-height: 100vh; width: 100%;
            background: linear-gradient(180deg, #FF9894 0%, #FFBFC0 35%, #FFDCDC 65%, #FFEBEB 100%);
            display: flex; flex-direction: column;
        }

        /* Navbar */
        nav {
            background-color: white; padding: 15px 50px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 18px; color: #000; text-decoration: none; }
        .nav-logo i { color: #FF8585; font-size: 24px; }
        .nav-login-text { color: #FF8585; font-weight: 500; font-size: 14px; background: #FFF0F0; padding: 5px 15px; border-radius: 20px; }
        
        /* Main Layout */
        .main-layout {
            flex: 1; display: flex; justify-content: center; align-items: center; /* Center Vertically for Login */
            padding: 40px 80px; gap: 80px; max-width: 1400px; margin: 0 auto; width: 100%;
        }
        
        /* Branding Section */
        .left-branding { text-align: center; display: flex; flex-direction: column; align-items: center; }
        .big-icon { font-size: 120px; color: white; margin-bottom: 10px; text-shadow: 0px 4px 10px rgba(0,0,0,0.1); }
        .brand-title { font-size: 36px; font-weight: 600; color: #2D3748; }

        /* Login Card - Sedikit lebih kecil dari register form agar proporsional */
        .login-card {
            background-color: white; padding: 50px 40px; border-radius: 20px; width: 550px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }
        .login-header {
            font-size: 24px; font-weight: 700; margin-bottom: 10px; color: #2D3748; text-align: center;
        }
        .login-sub {
            font-size: 14px; color: #718096; text-align: center; margin-bottom: 30px;
        }

        /* Form Elements */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 500; color: #4A5568; }
        .form-input {
            width: 100%; padding: 14px 15px; background-color: #F9FAFB; border: 1px solid #E2E8F0;
            border-radius: 10px; font-size: 14px; color: #2D3748; outline: none; transition: all 0.3s;
        }
        .form-input:focus { background-color: #fff; border-color: #FF9894; box-shadow: 0 0 0 3px rgba(255, 152, 148, 0.2); }
        
        .btn-login {
            width: 100%; padding: 15px; background-color: #FF7A7A; color: white; border: none;
            border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 122, 122, 0.3); transition: transform 0.2s, background 0.3s; margin-top: 10px;
            display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .btn-login:hover { background-color: #ff6363; transform: translateY(-2px); }
        .btn-login:disabled { background-color: #FAB2B2; cursor: not-allowed; transform: none; }
        
        .card-footer { margin-top: 30px; text-align: center; font-size: 14px; color: #718096; }
        .card-footer a { color: #FF7A7A; text-decoration: none; font-weight: 600; }
        .forgot-pass { text-align: right; margin-bottom: 20px; font-size: 13px; }
        .forgot-pass a { color: #718096; text-decoration: none; transition: color 0.2s; }
        .forgot-pass a:hover { color: #FF7A7A; }

        /* Loader Animation */
        .loader {
            border: 3px solid rgba(255, 255, 255, 0.3); border-radius: 50%; border-top: 3px solid white;
            width: 20px; height: 20px; animation: spin 1s linear infinite; display: none;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        /* Footer Styles */
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
            .main-layout { flex-direction: column; gap: 40px; padding: 20px; }
            .login-card { width: 100%; }
            .footer-content { grid-template-columns: 1fr; gap: 30px; text-align: center; }
            .left-branding { margin-bottom: 20px; }
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
        <div class="nav-login-text">Login Penjual</div>
    </nav>

    <div class="main-layout">
        
        <div class="left-branding animate-on-scroll opacity-0 transition-all duration-700 translate-y-10">
            <i class="fas fa-store big-icon"></i>
            <h1 class="brand-title">SiToko Seller</h1>
            <p class="mt-2 text-gray-700 font-medium text-lg">Kelola Bisnis Anda</p>
            <p class="mt-1 text-sm text-gray-600 max-w-xs">Masuk untuk mengelola produk, pesanan, dan melihat statistik penjualan.</p>
        </div>

        <div class="login-card animate-on-scroll opacity-0 transition-all duration-700 delay-200 translate-y-10">
            <h2 class="login-header">Selamat Datang Kembali!</h2>
            <p class="login-sub">Silakan masuk ke akun toko Anda</p>
            
            <form id="sellerLoginForm">
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-input pl-10" placeholder="nama@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" class="form-input pl-10 pr-10" placeholder="Masukkan password" required>
                        <span class="absolute inset-y-0 right-0 flex items-center px-3 cursor-pointer text-gray-500 hover:text-primary-600" onclick="togglePassword()">
                            <i class="fas fa-eye" id="icon-pass"></i>
                        </span>
                    </div>
                </div>

                <div class="forgot-pass">
                    <a href="#">Lupa Password?</a>
                </div>
                
                <button type="submit" class="btn-login" id="btn-submit">
                    <span class="loader" id="btn-loader"></span>
                    <span id="btn-text">MASUK KE DASHBOARD</span>
                </button>
            </form>

            <div class="card-footer">
                Belum terdaftar sebagai penjual? <a href="/register-seller">Daftar Toko Baru</a>
            </div>
        </div>
    </div>

    @include('components.footer')

    <button id="scrollToTop" class="fixed bottom-8 right-8 bg-primary-600 text-white p-4 rounded-full shadow-lg translate-y-20 opacity-0 transition-all duration-300 hover:bg-red-500 z-50">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <script>
        // 1. Toggle Password
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('icon-pass');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye');
            }
        }

        // 2. Submit Handler (Simulation)
        document.getElementById('sellerLoginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btnSubmit = document.getElementById('btn-submit');
            const btnLoader = document.getElementById('btn-loader');
            const btnText = document.getElementById('btn-text');
            const email = document.querySelector('input[type="email"]').value;

            // Loading UI
            btnSubmit.disabled = true;
            btnLoader.style.display = 'block';
            btnText.textContent = 'MEMPROSES...';

            setTimeout(() => {
                alert(`Login Berhasil!\nSelamat datang kembali di Dashboard Toko: ${email}`);
                // Redirect logic would go here
                // window.location.href = '/seller/dashboard';
                
                btnSubmit.disabled = false;
                btnLoader.style.display = 'none';
                btnText.textContent = 'MASUK KE DASHBOARD';
            }, 1500);
        });

        // 3. Scroll Animations
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