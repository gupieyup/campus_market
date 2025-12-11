<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Marketplace untuk Semua</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            500: '#FF9894', 
                            600: '#FF7A7A', // Warna tombol utama disamakan
                        }
                    }
                }
            }
        }
    </script>

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

        .tokped-container {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        @media (min-width: 768px) {
            .tokped-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased selection:bg-pink-200 selection:text-pink-900 min-h-screen flex flex-col">
    
    <main class="flex-grow">
        @include('components.toast')
        {{-- Data now provided by `HomeController@index` (DB-driven) --}}

        {{-- NAVBAR SECTION --}}
        <x-navbar />

        {{-- HERO SECTION --}}
        <section class="tokped-container mt-6">
            <div class="hero-pattern rounded-xl p-0 md:p-0 text-center relative overflow-hidden shadow-sm animate-on-scroll">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-300 opacity-20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
                <!-- Carousel wrapper -->
                <div class="relative z-10 max-w-4xl mx-auto">
                    <div id="hero-carousel" class="overflow-hidden relative" style="min-height: 280px;">
                        <!-- Slides -->
                        <div class="carousel-slide p-8 md:p-12 min-h-[280px] absolute inset-0 transition-opacity duration-700 ease-out opacity-100 pointer-events-auto" data-index="0">
                            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight drop-shadow-md">Belanja Hemat<br>untuk Semua</h1>
                            <p class="text-white/90 text-lg mb-8 font-medium">Marketplace untuk semua. Jual barang bekasmu, temukan kebutuhanmu.</p>
                        </div>
                        <div class="carousel-slide p-8 md:p-12 min-h-[280px] absolute inset-0 transition-opacity duration-700 ease-out opacity-0 pointer-events-none" data-index="1">
                               <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight drop-shadow-md">Jual & Belanja<br>Dengan Nyaman</h1>
                               <p class="text-white/90 text-lg mb-8 font-medium">Unggah produkmu dengan mudah, temukan pembeli dengan cepat.</p>
                        </div>
                        <div class="carousel-slide p-8 md:p-12 min-h-[280px] absolute inset-0 transition-opacity duration-700 ease-out opacity-0 pointer-events-none" data-index="2">
                            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight drop-shadow-md">Temukan Deals<br>Terbaik Setiap Hari</h1>
                            <p class="text-white/90 text-lg mb-8 font-medium">Diskon, bundling, dan penawaran lokal dari penjual tepercaya.</p>
                        </div>
                    </div>

                    <!-- Controls -->
                    <div class="absolute inset-y-0 left-0 flex items-center">
                        <button id="hero-prev" class="m-2 p-2 bg-white/20 hover:bg-white/30 text-white rounded-full">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        <button id="hero-next" class="m-2 p-2 bg-white/20 hover:bg-white/30 text-white rounded-full">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
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
                
            </div>
            
            <div class="grid grid-cols-5 md:grid-cols-10 gap-y-6 gap-x-2 animate-on-scroll bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                @foreach(($categories ?? []) as $cat)
                    @php $hasId = isset($cat['id']) && !empty($cat['id']); @endphp
                    @if($hasId)
                    <a href="{{ route('products.index', ['category' => $cat['id']]) }}" class="group flex flex-col items-center gap-2 transition hover:-translate-y-1">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl {{ $cat['color'] }} flex items-center justify-center text-lg shadow-sm border border-white group-hover:shadow-md transition-all duration-300">
                            <i class="fa-solid {{ $cat['icon'] }}"></i>
                        </div>
                        <span class="text-[10px] md:text-xs font-medium text-gray-600 text-center group-hover:text-pink-600 leading-tight max-w-[60px]">{{ $cat['name'] }}</span>
                    </a>
                    @else
                    <div class="group cursor-default flex flex-col items-center gap-2 opacity-80">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl {{ $cat['color'] }} flex items-center justify-center text-lg shadow-sm border border-white transition-all duration-300">
                            <i class="fa-solid {{ $cat['icon'] }}"></i>
                        </div>
                        <span class="text-[10px] md:text-xs font-medium text-gray-600 text-center leading-tight max-w-[60px]">{{ $cat['name'] }}</span>
                    </div>
                    @endif
                @endforeach
            </div>
        </section>

        {{-- PRODUK TERLARIS --}}
        <section class="tokped-container mt-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    Sedang Hangat
                </h3>
                <a href="{{ route('products.index') }}" class="text-[#FF9894] font-semibold text-sm hover:underline">Lihat Semua</a>
            </div>

            @if(empty($products) || count($products) == 0)
                <div class="bg-white rounded-lg p-8 text-center border border-gray-100 shadow-sm">
                    <p class="text-gray-600 font-medium">Produk tidak ditemukan.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                    @foreach(($products ?? []) as $index => $item)
                    <a href="{{ $item['url'] }}" class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-[0_4px_12px_rgba(0,0,0,0.1)] transition-all duration-300 group overflow-hidden animate-on-scroll flex flex-col h-full no-underline text-inherit" style="animation-delay: {{ $index * 50 }}ms">
                        
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
                    </a>
                    @endforeach
                </div>

                <div class="text-center mt-10">
                    {{ $products->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            @endif
        </section>

    </main>

    {{-- FOOTER --}}
    <x-footer />
    
    <button id="scrollToTop" class="fixed bottom-8 right-8 bg-primary-600 text-white p-4 rounded-full shadow-lg translate-y-20 opacity-0 transition-all duration-300 hover:bg-red-500 z-50">
        <i class="fas fa-arrow-up"></i>
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

        // 4. Simple Carousel (3 slides)
        const slides = Array.from(document.querySelectorAll('#hero-carousel .carousel-slide'));
        let current = 0;
        const prevBtn = document.getElementById('hero-prev');
        const nextBtn = document.getElementById('hero-next');
        let autoTimer = null;
        const INTERVAL_MS = 5000; // ganti tiap 5 detik

        function renderCarousel(){
            slides.forEach((s, i) => {
                const active = i === current;
                s.style.opacity = active ? '1' : '0';
                s.style.zIndex = active ? '1' : '0';
                s.classList.toggle('pointer-events-none', !active);
                s.classList.toggle('pointer-events-auto', active);
            });
        }
        function next(){ current = (current + 1) % slides.length; renderCarousel(); }
        function prev(){ current = (current - 1 + slides.length) % slides.length; renderCarousel(); }
        function startAuto(){ stopAuto(); autoTimer = setInterval(next, INTERVAL_MS); }
        function stopAuto(){ if (autoTimer) { clearInterval(autoTimer); autoTimer = null; } }

        prevBtn?.addEventListener('click', () => { prev(); startAuto(); });
        nextBtn?.addEventListener('click', () => { next(); startAuto(); });
        // Ensure first paint shows the card
        renderCarousel();
        setTimeout(startAuto, 500);
    </script>
</body>
</html>