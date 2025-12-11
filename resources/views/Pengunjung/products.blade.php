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
<body class="bg-gray-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">

    {{-- NAVBAR (copied from home) --}}
    <x-navbar />
    @include('components.toast')

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

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Sidebar Filters -->
            <aside class="md:col-span-3">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="p-4 border-b">
                        <h4 class="font-semibold text-gray-800">Filter</h4>
                    </div>
                    <form method="GET" action="{{ route('products.index') }}" class="p-4 space-y-4">
                        <!-- Keep existing query params except the ones we'll override -->
                        @foreach(request()->except(['product','shop','category','province','city','page']) as $key => $val)
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}" />
                        @endforeach

                        <!-- Product name removed per request -->

                        <!-- Shop name -->
                        <div>
                            <label class="text-sm text-gray-600">Nama toko</label>
                            <input type="text" name="shop" value="{{ old('shop', $shop ?? '') }}" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-pink-300" placeholder="Contoh: Gramedia" />
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="text-sm text-gray-600">Kategori</label>
                            <select name="category" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-pink-300">
                                <option value="">Semua kategori</option>
                                @if(!empty($categories) && $categories->count())
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ (string)($activeCategory ?? '') === (string)$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Location: Province (dropdown) -->
                        <div>
                            <label class="text-sm text-gray-600">Provinsi</label>
                            <select id="province-select" name="province" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-pink-300">
                                <option value="">Semua provinsi</option>
                                @foreach(($provinceList ?? collect()) as $prov)
                                    <option value="{{ $prov }}" {{ (string)($province ?? '') === (string)$prov ? 'selected' : '' }}>{{ $prov }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location: City/Kabupaten (dropdown) -->
                        <div>
                            <label class="text-sm text-gray-600">Kota/Kabupaten</label>
                            <select id="city-select" name="city" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-pink-300">
                                <option value="">Semua kota/kabupaten</option>
                                @foreach(($cityList ?? collect()) as $c)
                                    <option value="{{ $c }}" {{ (string)($city ?? '') === (string)$c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="flex-1 bg-primary-600 text-white px-3 py-2 rounded-md text-sm font-semibold hover:bg-pink-500">Terapkan</button>
                            <a href="{{ route('products.index') }}" class="flex-1 text-center border border-gray-300 px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">Reset</a>
                        </div>
                    </form>
                </div>

                <!-- Optional: category chips remain under grid in mobile; hidden here -->
            </aside>

            <!-- Results -->
            <section class="md:col-span-9">
                <!-- Category chips removed per request -->

                @if(empty($products) || $products->total() == 0)
                    <div class="bg-white rounded-lg p-8 text-center border border-gray-100 shadow-sm">
                        <p class="text-gray-600 font-medium">Produk tidak ditemukan.</p>
                    </div>
                    <script>notify({ message: 'Produk tidak ditemukan untuk filter saat ini.', variant: 'warn', timeout: 2500 });</script>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-4">
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
            </section>
        </div>
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

        // Dependent city dropdown
        const provinceSelect = document.getElementById('province-select');
        const citySelect = document.getElementById('city-select');
        async function loadCitiesByProvince(province) {
            citySelect.innerHTML = '<option value="">Semua kota/kabupaten</option>';
            if (!province) return;
            try {
                const res = await fetch(`{{ route('regions.cities') }}?province=${encodeURIComponent(province)}`);
                const data = await res.json();
                data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c;
                    opt.textContent = c;
                    citySelect.appendChild(opt);
                });
            } catch (e) { /* ignore */ }
        }
        provinceSelect?.addEventListener('change', (e) => loadCitiesByProvince(e.target.value));
        // If province already selected but city list empty (first load), fetch cities
        if (provinceSelect && provinceSelect.value && (!citySelect || citySelect.options.length <= 1)) {
            loadCitiesByProvince(provinceSelect.value);
        }
    </script>

</body>
</html>