<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Marketplace untuk Semua</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style type="text/tailwindcss">
        @layer utilities {
            @keyframes fadeInUp {
                0% { opacity: 0; transform: translateY(20px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            .animate-on-scroll {
                opacity: 0; 
            }
            .is-visible {
                animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
        }

        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        .hero-pattern {
            background-color: #FF9894;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Container Tokopedia Style: Max width 1200px dan centered */
        .tokped-container {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem; /* px-4 */
            padding-right: 1rem; /* px-4 */
        }
        
        @media (min-width: 768px) {
            .tokped-container {
                padding-left: 1.5rem; /* px-6 */
                padding-right: 1.5rem;
            }
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            500: '#FF9894', 
                            600: '#FF9894',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased selection:bg-pink-200 selection:text-pink-900 pb-20">

    {{-- DATA DUMMY --}}
    @php
        $categories = [
            ['name' => 'Elektronik & Gadget', 'icon' => 'fa-laptop', 'color' => 'bg-blue-100 text-blue-600'],
            ['name' => 'Pakaian & Aksesoris', 'icon' => 'fa-shirt', 'color' => 'bg-pink-100 text-pink-600'],
            ['name' => 'Perabot Rumah & Dapur', 'icon' => 'fa-bed', 'color' => 'bg-emerald-100 text-emerald-600'],
            ['name' => 'Buku & Media', 'icon' => 'fa-book', 'color' => 'bg-yellow-100 text-yellow-600'],
            ['name' => 'Makanan & Minuman', 'icon' => 'fa-utensils', 'color' => 'bg-orange-100 text-orange-600'],
            ['name' => 'Kendaraan & Aksesoris', 'icon' => 'fa-bicycle', 'color' => 'bg-indigo-100 text-indigo-600'],
            ['name' => 'Kesehatan & Kecantikan', 'icon' => 'fa-heart', 'color' => 'bg-rose-100 text-rose-600'],
            ['name' => 'Jasa & Layanan', 'icon' => 'fa-briefcase', 'color' => 'bg-purple-100 text-purple-600'],
        ];

        $products = [
            ['name' => 'Laptop Gaming ASUS ROG Bekas Mulus', 'price' => 'Rp 8.500.000', 'location' => 'Jakarta Selatan', 'rating' => '4.8', 'sold' => '12', 'img' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=500&q=80'],
            ['name' => 'Kemeja Flannel Uniqlo Size L', 'price' => 'Rp 150.000', 'location' => 'Bandung', 'rating' => '4.9', 'sold' => '5', 'img' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&q=80'],
            ['name' => 'Kalkulus Jilid 1 Purcell Edisi 9', 'price' => 'Rp 80.000', 'location' => 'Semarang', 'rating' => '5.0', 'sold' => '30', 'img' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&q=80'],
            ['name' => 'Sepatu Converse Chuck Taylor 70s', 'price' => 'Rp 450.000', 'location' => 'Surabaya', 'rating' => '4.7', 'sold' => '8', 'img' => 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500&q=80'],
            ['name' => 'Headphone Sony WH-1000XM4', 'price' => 'Rp 3.200.000', 'location' => 'Jakarta Barat', 'rating' => '4.9', 'sold' => '42', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=500&q=80'],
            ['name' => 'Skincare Bundle Somethinc', 'price' => 'Rp 199.000', 'location' => 'Yogyakarta', 'rating' => '4.8', 'sold' => '150+', 'img' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=500&q=80'],
            ['name' => 'Totebag Kanvas Aesthetics', 'price' => 'Rp 35.000', 'location' => 'Malang', 'rating' => '4.6', 'sold' => '88', 'img' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=500&q=80'],
            ['name' => 'Mouse Logitech G304 Wireless', 'price' => 'Rp 400.000', 'location' => 'Medan', 'rating' => '4.9', 'sold' => '200+', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&q=80'],
            ['name' => 'Keyboard Keychron K2 V2', 'price' => 'Rp 1.100.000', 'location' => 'Jakarta Pusat', 'rating' => '4.8', 'sold' => '15', 'img' => 'https://images.unsplash.com/photo-1587829741301-dc798b91a603?w=500&q=80'],
            ['name' => 'Meja Belajar Minimalis Ikea', 'price' => 'Rp 250.000', 'location' => 'Bogor', 'rating' => '4.5', 'sold' => '3', 'img' => 'https://images.unsplash.com/photo-1519947486511-4639940be43a?w=500&q=80'],
        ];
    @endphp

    {{-- NAVBAR SECTION --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm transition-all duration-300" id="navbar">
        <div class="tokped-container h-16 flex items-center justify-between gap-6">
            <a href="/" class="flex items-center gap-2 text-[#FF9894] hover:text-pink-600 transition group">
                <div class="bg-pink-50 p-2 rounded-lg group-hover:bg-pink-100 transition">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                </div>
                <span class="font-bold text-xl tracking-tight hidden md:block">SiToko</span>
            </a>

            {{-- Search Bar Added to match "Marketplace Feel" --}}
            <div class="hidden md:flex flex-1 max-w-2xl relative">
                <input type="text" placeholder="Cari barang di SiToko..." class="w-full border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:border-[#FF9894] focus:ring-1 focus:ring-[#FF9894] transition-all text-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-sm"></i>
            </div>

            <div class="flex items-center gap-4 shrink-0">
                <a href="/login" class="text-sm font-medium text-gray-700 hover:text-[#FF9894] transition">Masuk</a>
                <a href="/register" class="bg-[#FF9894] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-pink-600 transition">Daftar</a>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="tokped-container mt-6">
        <div class="hero-pattern rounded-xl p-8 md:p-12 text-center relative overflow-hidden shadow-sm animate-on-scroll">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-300 opacity-20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

            <div class="relative z-10 max-w-2xl mx-auto">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight drop-shadow-md">
                    Belanja Hemat <br> untuk Semua
                </h1>
                <p class="text-white/90 text-lg mb-8 font-medium">
                    Marketplace untuk semua. Jual barang bekasmu, temukan kebutuhanmu.
                </p>
                
                <div class="flex justify-center gap-3">
                    <span class="w-2 h-2 bg-white rounded-full"></span>
                    <span class="w-2 h-2 bg-white/50 rounded-full"></span>
                    <span class="w-2 h-2 bg-white/50 rounded-full"></span>
                </div>
            </div>
        </div>
    </section>

    {{-- KATEGORI PILIHAN --}}
    <section class="tokped-container mt-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                Kategori Pilihan
            </h3>
            <a href="#" class="text-[#FF9894] font-semibold text-sm hover:underline">Lihat Semua</a>
        </div>
        
        {{-- Grid 5 kolom di Desktop, 10 kolom di Large Desktop agar mirip Tokped baris icon --}}
        <div class="grid grid-cols-5 md:grid-cols-10 gap-y-6 gap-x-2 animate-on-scroll bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            @foreach($categories as $cat)
            <div class="group cursor-pointer flex flex-col items-center gap-2 transition hover:-translate-y-1">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl {{ $cat['color'] }} flex items-center justify-center text-lg shadow-sm border border-white group-hover:shadow-md transition-all duration-300">
                    <i class="fa-solid {{ $cat['icon'] }}"></i>
                </div>
                <span class="text-[10px] md:text-xs font-medium text-gray-600 text-center group-hover:text-pink-600 leading-tight max-w-[60px]">{{ $cat['name'] }}</span>
            </div>
            @endforeach
        </div>
    </section>

    {{-- PRODUK TERLARIS (GRID SYSTEM) --}}
    <section class="tokped-container mt-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                Sedang Hangat
            </h3>
            <a href="#" class="text-[#FF9894] font-semibold text-sm hover:underline">Lihat Semua</a>
        </div>

        {{-- 2 Kolom (HP), 3 (Tablet), 5 (Desktop - Mirip Tokped) --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
            @foreach($products as $index => $item)
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-[0_4px_12px_rgba(0,0,0,0.1)] transition-all duration-300 cursor-pointer group overflow-hidden animate-on-scroll flex flex-col h-full" style="animation-delay: {{ $index * 50 }}ms">
                
                <div class="relative aspect-square bg-gray-100 overflow-hidden">
                    <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                         <p class="text-white text-[10px] font-medium flex items-center gap-1">
                            <i class="fa-solid fa-location-dot"></i> {{ $item['location'] }}
                        </p>
                    </div>
                </div>

                <div class="p-3 flex flex-col flex-1">
                    <h4 class="text-xs md:text-sm text-gray-700 font-normal leading-snug line-clamp-2 mb-1 group-hover:text-pink-600 transition-colors">
                        {{ $item['name'] }}
                    </h4>

                    <div class="mt-1 mb-2">
                        <p class="text-sm md:text-base font-bold text-slate-900">{{ $item['price'] }}</p>
                    </div>

                    {{-- Info Bawah (Rating & Terjual) --}}
                    <div class="flex items-center gap-1 mt-auto text-[10px] text-gray-500">
                        <i class="fa-solid fa-star text-yellow-400"></i>
                        <span class="font-medium text-gray-600">{{ $item['rating'] }}</span>
                        <span class="text-gray-300 mx-1">|</span>
                        <span>Terjual {{ $item['sold'] }}</span>
                    </div>

                    <div class="flex items-center gap-1 mt-1 text-[10px] text-gray-400">
                         <i class="fa-solid fa-shop"></i>
                         <span class="truncate max-w-[100px]">{{ $item['location'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <button class="bg-white border border-[#FF9894] text-[#FF9894] px-8 py-2 rounded-lg font-bold text-sm hover:bg-pink-50 transition shadow-sm">
                Muat Lebih Banyak
            </button>
        </div>
    </section>

    {{-- FOOTER: use shared component only --}}
    <x-footer />
    <button id="scrollToTop" class="fixed bottom-6 right-6 bg-pink-500 text-white w-10 h-10 rounded-full shadow-lg flex items-center justify-center translate-y-20 opacity-0 transition-all duration-300 hover:bg-pink-600 hover:-translate-y-1 z-40">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    {{-- JAVASCRIPT LOGIC --}}
    <script>
        // 1. Animation on Scroll
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target); 
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // 2. Scroll to Top
        const scrollBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.remove('translate-y-20', 'opacity-0');
            } else {
                scrollBtn.classList.add('translate-y-20', 'opacity-0');
            }
        });

        scrollBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // 3. Navbar Shadow
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-md');
            } else {
                navbar.classList.remove('shadow-md');
            }
        });
    </script>
</body>
</html>