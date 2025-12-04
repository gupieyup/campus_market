<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Produk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], poppins: ['Poppins', 'sans-serif'] },
                    colors: { primary: { 500: '#FF9894', 600: '#FF7A7A' } }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        .tokped-container { max-width:1200px; margin-left:auto; margin-right:auto; padding-left:1rem; padding-right:1rem }
        @media (min-width:768px){ .tokped-container{ padding-left:1.5rem; padding-right:1.5rem }}
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased pb-20">

    {{-- NAVBAR (copied from home) --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm transition-all duration-300" id="navbar">
        <div class="tokped-container h-16 flex items-center justify-between gap-6">
            <a href="/" class="flex items-center gap-2 text-[#FF9894] hover:text-pink-600 transition group">
                <div class="bg-pink-50 p-2 rounded-lg group-hover:bg-pink-100 transition">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                </div>
                <span class="font-bold text-xl tracking-tight hidden md:block">SiToko</span>
            </a>

            <div class="hidden md:flex flex-1 max-w-2xl relative">
                <form action="/products" method="get" class="w-full">
                    <input name="q" value="{{ old('q', request('q', $q ?? '')) }}" type="text" placeholder="Cari barang di SiToko..." class="w-full border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:border-[#FF9894] focus:ring-1 focus:ring-[#FF9894] transition-all text-sm">
                    <button type="submit" class="absolute left-0 top-0 h-full pl-3 pr-3 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="/login-seller" class="text-sm font-semibold text-gray-600 hover:text-[#FF7A7A] transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-store"></i> Masuk Toko
                </a>
                <a href="/register-seller" class="bg-[#FF7A7A] text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-[#ff6363] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Buka Toko
                </a>
            </div>
        </div>
    </nav>

    <main class="tokped-container mt-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-2xl font-bold text-gray-800">
                @if(!empty($q))
                    Hasil pencarian untuk: "{{ e($q) }}"
                @else
                    Semua Produk
                @endif
            </h3>
            <a href="/products" class="text-[#FF9894] font-semibold text-sm hover:underline">Lihat Semua</a>
        </div>

        @if(!empty($categories) && $categories->count())
            <div class="mb-4 flex items-center gap-2 overflow-x-auto py-2">
                <a href="{{ route('products.index', array_merge(request()->query(), ['category' => null])) }}" class="text-sm px-3 py-1 rounded-full border border-gray-200 bg-white text-gray-700 hover:bg-pink-50">Semua</a>
                @foreach($categories as $cat)
                    @php $isActive = (string)($activeCategory ?? '') === (string)$cat->id; @endphp
                    <a href="{{ route('products.index', array_merge(request()->query(), ['category' => $cat->id])) }}" class="text-sm px-3 py-1 rounded-full border {{ $isActive ? 'border-pink-300 bg-[#FF9894] text-white' : 'border-gray-200 bg-white text-gray-700' }} hover:{{ $isActive ? '' : 'bg-pink-50' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        @endif

        @if(empty($products) || $products->total() == 0)
            <div class="bg-white rounded-lg p-8 text-center border border-gray-100 shadow-sm">
                <p class="text-gray-600 font-medium">Produk tidak ditemukan.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                @foreach($products as $index => $item)
                <a href="{{ $item['url'] }}" class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-[0_4px_12px_rgba(0,0,0,0.1)] transition-all duration-300 cursor-pointer group overflow-hidden animate-on-scroll flex flex-col h-full no-underline text-inherit">
                    <div class="relative aspect-square bg-gray-100 overflow-hidden">
                        <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <button id="scrollToTop" class="fixed bottom-8 right-8 bg-primary-600 text-white p-4 rounded-full shadow-lg translate-y-20 opacity-0 transition-all duration-300 hover:bg-red-500 z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        const scrollBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', () => { if (window.scrollY > 300) { scrollBtn.classList.remove('translate-y-20','opacity-0'); } else { scrollBtn.classList.add('translate-y-20','opacity-0'); } });
        scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    </script>

</body>
</html>