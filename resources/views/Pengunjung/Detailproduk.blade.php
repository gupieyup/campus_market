<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Data diambil penuh dari Controller. Tanpa fallback di Blade. --}}
    @php
        $avgRating = isset($reviews) && $reviews instanceof \Illuminate\Support\Collection && $reviews->count() > 0 
            ? $reviews->avg('rating') 
            : 0;
        $totalReviews = isset($reviews) && $reviews instanceof \Illuminate\Support\Collection ? $reviews->count() : 0;
        $starCounts = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0];
        if (isset($reviews) && $reviews instanceof \Illuminate\Support\Collection) {
            foreach($reviews as $r) { 
                if(isset($starCounts[$r->rating])) $starCounts[$r->rating]++; 
            }
        }
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; color: #334155; } 

        :root { 
            --primary: #FF7A7A; 
            --primary-hover: #ff6363;
        }

        /* Scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        
        /* Animation */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .email-toast { animation: slideInRight 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
    </style>
    
    <style type="text/tailwindcss">
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
        .form-input {
            @apply w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:bg-white focus:border-[#FF7A7A] transition-colors placeholder-gray-400;
        }
    </style>

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
                            600: '#FF7A7A',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen flex flex-col">

    <div id="notification-area" class="fixed top-24 right-5 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <x-navbar />

    <main class="tokped-container py-8 grid grid-cols-1 md:grid-cols-12 gap-10">
        
        <div class="md:col-span-5 lg:col-span-4">
            <div class="sticky top-24 space-y-4">
                <div class="aspect-square bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm relative group cursor-pointer">
                    @php
                        $imgUrl = $product->image_url ?? $product->image ?? 'placeholder.png';
                        if (!filter_var($imgUrl, FILTER_VALIDATE_URL)) {
                            if (\Str::startsWith($imgUrl, 'storage/')) {
                                $imgUrl = asset($imgUrl);
                            } elseif (\Str::startsWith($imgUrl, '/storage/')) {
                                $imgUrl = asset($imgUrl);
                            } elseif (\Str::startsWith($imgUrl, 'images/')) {
                                $imgUrl = asset($imgUrl);
                            } else {
                                $imgUrl = asset('storage/' . ltrim($imgUrl, '/'));
                            }
                        }
                    @endphp
                    <img src="{{ $imgUrl }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
                         onerror="this.onerror=null; this.src='https://placehold.co/600x600/png?text=Produk+Image';">
                </div>
            </div>
        </div>

        <div class="md:col-span-7 lg:col-span-8 space-y-5">
            <nav class="flex text-xs text-gray-500 font-medium mb-4">
                <a href="/" class="hover:text-[#FF7A7A] transition">Home</a>
                <span class="mx-2">/</span>
                <span>{{ $product->category->name ?? 'Kategori' }}</span>
                <span class="mx-2">/</span>
                <span class="text-[#FF7A7A] truncate">{{ $product->name }}</span>
            </nav>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h1 class="text-2xl font-bold text-slate-900 leading-tight mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 text-sm mb-5 pb-5 border-b border-gray-100">
                    <div class="flex items-center gap-1 text-yellow-400">
                        <i class="fa-solid fa-star"></i>
                        <span class="font-bold text-slate-900 ml-1">{{ number_format($avgRating, 1) }}</span>
                    </div>
                    <div class="w-px h-4 bg-gray-200"></div>
                    <div class="text-slate-600">{{ $totalReviews }} ulasan</div>
                </div>

                <div class="mb-6">
                    <div class="text-3xl font-bold text-[#FF7A7A]">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>

                <div class="prose prose-sm max-w-none text-slate-600">
                    <h3 class="font-bold text-slate-900 text-base mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-[#FF7A7A]"></i> Detail Produk
                    </h3>
                    
                    @php
                        $descLines = preg_split('/\r\n|\r|\n/', trim($product->description ?? '')) ?: [];
                        $paras = array_values(array_filter($descLines, function($l){ return trim($l) !== '' && substr(trim($l),0,1) !== '-'; }));
                        $bullets = array_values(array_filter($descLines, function($l){ return substr(trim($l),0,1) === '-'; }));
                    @endphp

                    <div class="space-y-3">
                        @foreach($paras as $p) <p class="leading-relaxed text-sm">{{ $p }}</p> @endforeach
                        @if(count($bullets))
                            <div class="mt-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <h4 class="font-semibold text-xs text-gray-600 uppercase mb-3 tracking-wide">Spesifikasi</h4>
                                <ul class="space-y-2">
                                    @foreach($bullets as $b) 
                                        <li class="flex items-start gap-2 text-sm">
                                            <i class="fa-solid fa-circle-check text-[#FF7A7A] text-xs mt-0.5"></i>
                                            <span>{{ ltrim($b, "- ") }}</span>
                                        </li> 
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-8">
                <h3 class="font-bold text-slate-900 text-base mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-store text-[#FF7A7A]"></i> Informasi Penjual
                </h3>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#FF7A7A] to-red-400 text-white flex items-center justify-center text-xl font-bold shadow-md flex-shrink-0">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-slate-900 flex items-center gap-2 mb-1">
                            {{ $product->shop->name }}
                            <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-[#FF7A7A]">
                                <i class="fa-solid fa-circle-check text-white text-[10px]"></i>
                            </span>
                        </div>
                        @if($product->seller && $product->seller->region)
                            <div class="text-sm text-gray-600 flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-xs text-[#FF7A7A]"></i> 
                                <span>{{ $product->seller->region->name }}</span>
                            </div>
                        @elseif($product->seller && $product->seller->region_id)
                            <div class="text-sm text-gray-500">Region ID: {{ $product->seller->region_id }} (Region belum di-load)</div>
                        @else
                            <div class="text-sm text-gray-500 italic">Lokasi tidak tersedia</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        </main>

    <section class="tokped-container mt-1 pt-4">
        <div class="mt-2 border-t-2 border-gray-200">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-2 mb-2 mt-8">
                <i class="fa-solid fa-star text-yellow-400"></i> Ulasan Pengunjung
            </h2>
            <p class="text-gray-600 text-sm">Lihat apa yang dikatakan pelanggan tentang produk ini</p>
        </div>
        
        @if(session('success'))
            <div class="tokped-container mb-6">
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl mb-7">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="tokped-container mb-6">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-7">{{ session('error') }}</div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
            
            <div class="md:col-span-4 lg:col-span-4">
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 p-8 rounded-3xl border border-yellow-200 shadow-sm sticky top-24">
                    <div class="flex items-end gap-3 mb-5">
                        <span class="text-6xl font-extrabold text-slate-900 leading-none">{{ number_format($avgRating, 1) }}</span>
                        <div class="pb-1">
                            <span class="text-gray-500 text-sm font-medium">/ 5</span>
                        </div>
                    </div>
                    <div class="flex gap-1 text-yellow-400 text-lg mb-3">
                        @for($i=1; $i<=5; $i++) 
                            <i class="{{ $i <= round($avgRating) ? 'fa-solid' : 'fa-regular' }} fa-star"></i> 
                        @endfor
                    </div>
                    <div class="text-sm font-semibold text-slate-700 mb-8">
                        <span class="text-[#FF5C5C]">{{ $totalReviews }}</span> ulasan dari pembeli
                    </div>
                    
                    <div class="space-y-3 mb-8 bg-white/60 p-4 rounded-2xl">
                        @for($i=5; $i>=1; $i--)
                            @php $pct = $totalReviews > 0 ? ($starCounts[$i] / $totalReviews) * 100 : 0; @endphp
                            <div class="flex items-center gap-3 text-xs">
                                <span class="font-bold text-slate-600 w-4">{{ $i }}★</span>
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="text-gray-500 w-6 text-right font-semibold">{{ $starCounts[$i] }}</span>
                            </div>
                        @endfor
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-200 mb-6">
                        <p class="text-sm text-gray-600 mb-4 text-center font-medium">Punya pengalaman dengan produk ini?</p>
                        <button id="open-review-form-desktop" class="w-full bg-gradient-to-r from-[#FF5C5C] to-red-400 text-white font-bold py-3.5 rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 shadow-md">
                            <i class="fa-regular fa-pen-to-square text-lg"></i> Bagikan Ulasan Kamu
                        </button>
                    </div>
                </div>
            </div>

            <div class="md:col-span-8 lg:col-span-8">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                    <div class="font-bold text-slate-800">Ulasan Pilihan</div>
                    <div class="text-sm text-gray-500">Menampilkan {{ $reviews->count() }} ulasan</div>
                </div>
                
                <div id="reviews-list" class="space-y-5">
                    @forelse($reviews as $review)
                        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-[#FF5C5C]/20 transition-all duration-300 group">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#FF5C5C] to-red-400 flex items-center justify-center text-sm font-bold text-white shadow-md">
                                        {{ strtoupper(substr(trim($review->user_name ?? 'U'),0,1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-bold text-sm text-slate-900">{{ $review->user_name ?? 'Pembeli' }}</div>
                                        <div class="text-[11px] text-gray-500">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="flex gap-0.5 text-yellow-400 text-sm bg-yellow-50 px-2.5 py-1.5 rounded-lg border border-yellow-100 flex-shrink-0">
                                    @for($i=0; $i<5; $i++)
                                        @if($i < $review->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed pl-14">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200 text-center">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm text-gray-300 text-2xl">
                                <i class="fa-regular fa-comments"></i>
                            </div>
                            <h4 class="font-bold text-slate-700">Belum ada ulasan</h4>
                            <p class="text-sm text-gray-500 mt-1">Jadilah yang pertama memberikan ulasan untuk produk ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 lg:hidden z-40 shadow-[0_-4px_20px_rgba(0,0,0,0.1)]">
         <button id="open-review-form-mobile" class="w-full bg-[#FF7A7A] text-white font-bold py-3.5 rounded-xl text-sm hover:bg-[#ff6363] shadow-lg shadow-pink-200">
            Tulis Ulasan
        </button>
    </div>

    <div id="review-form-modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" id="close-modal-bg"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden animate-fade-up flex flex-col max-h-[90vh]">
                
                <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0 z-10">
                    <div>
                        <h4 class="font-bold text-xl text-slate-900">Beri Ulasan</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Bagikan pengalaman belanja kamu</p>
                    </div>
                    <button id="close-modal" class="w-9 h-9 rounded-full bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                </div>
                
                <form id="rating-form" action="{{ route('ratings.store') }}" method="POST" class="p-8 overflow-y-auto custom-scroll space-y-6">
                    @csrf
                    <input type="hidden" name="product_detail_id" value="{{ $firstDetailId ?? ($product->productDetails->first()->id ?? '') }}">
                    @error('product_detail_id')
                        <div class="bg-red-50 text-red-500 text-xs p-2 rounded-lg border border-red-100 text-center">
                            Produk ini belum memiliki varian/detail, sehingga belum bisa dirating.
                        </div>
                    @enderror

                    <div class="text-center bg-yellow-50/30 p-6 rounded-3xl border border-dashed border-yellow-200">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Rating Kamu</label>
                        <div id="form-star-rating" class="flex justify-center text-4xl gap-3 cursor-pointer">
                            <i class="fa-regular fa-star form-star text-gray-300 hover:text-yellow-400 transition transform hover:scale-110" data-value="1"></i>
                            <i class="fa-regular fa-star form-star text-gray-300 hover:text-yellow-400 transition transform hover:scale-110" data-value="2"></i>
                            <i class="fa-regular fa-star form-star text-gray-300 hover:text-yellow-400 transition transform hover:scale-110" data-value="3"></i>
                            <i class="fa-regular fa-star form-star text-gray-300 hover:text-yellow-400 transition transform hover:scale-110" data-value="4"></i>
                            <i class="fa-regular fa-star form-star text-gray-300 hover:text-yellow-400 transition transform hover:scale-110" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="rating-value" value="{{ old('rating') }}">
                        @error('rating') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        <div id="rating-text" class="text-sm font-bold text-[#FF7A7A] mt-3 h-5 tracking-wide uppercase"></div>
                    </div>

                    <div class="space-y-5">
                        <div class="group">
                            <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">Nama Lengkap</label>
                            <input type="text" id="review-name" name="name" class="form-input @error('name') border-red-500 @enderror" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                            @error('name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">No. HP</label>
                                <input type="tel" id="review-phone" name="no_telp" class="form-input @error('no_telp') border-red-500 @enderror" placeholder="0812..." value="{{ old('no_telp') }}">
                                @error('no_telp') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">Provinsi</label>
                                <div class="relative">
                                    <select id="review-provinsi" name="provinsi" class="form-input appearance-none text-gray-600">
                                        <option value="">Pilih...</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-xs text-gray-400 pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">Email (Untuk Notifikasi)</label>
                            <input type="email" id="review-email" name="email" class="form-input @error('email') border-red-500 @enderror" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                            @error('email') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">Ulasan Kamu</label>
                            <textarea id="review-comment" name="review" rows="3" class="form-input resize-none @error('review') border-red-500 @enderror" placeholder="Ceritakan detail kualitas barang...">{{ old('review') }}</textarea>
                            @error('review') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </form>

                <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-4">
                    <button id="cancel-review" type="button" class="flex-1 py-3.5 text-sm font-bold text-gray-500 hover:bg-gray-200 rounded-2xl transition">Batal</button>
                    <button id="submit-review" type="submit" form="rating-form" class="flex-[2] py-3.5 text-sm font-bold bg-[#FF7A7A] hover:bg-[#ff6363] text-white rounded-2xl shadow-lg shadow-pink-200 hover:shadow-pink-300 transition transform active:scale-[0.98]">Kirim Ulasan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qs = (sel) => document.querySelector(sel);
            const qsa = (sel) => document.querySelectorAll(sel);

            const modal = qs('#review-form-modal');
            const openBtns = [qs('#open-review-form-desktop'), qs('#open-review-form-mobile')];
            const closeBtn = qs('#close-modal');
            const closeBg = qs('#close-modal-bg');
            const cancelBtn = qs('#cancel-review');

            function toggleModal(show) {
                if(show) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }

            openBtns.forEach(btn => { if(btn) btn.addEventListener('click', () => toggleModal(true)); });
            [closeBtn, cancelBtn, closeBg].forEach(btn => { if(btn) btn.addEventListener('click', () => toggleModal(false)); });

            @if($errors->any())
                toggleModal(true);
            @endif

            const provSelect = qs('#review-provinsi');
            if (provSelect) {
                fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                    .then(r => r.json()).then(list => {
                        list.forEach(p => {
                            const opt = document.createElement('option'); opt.value = p.name; opt.textContent = p.name; provSelect.appendChild(opt);
                        });
                    }).catch(()=>{});
            }

            let formSelected = 0;
            const formStars = qsa('.form-star');
            const ratingText = qs('#rating-text');
            const ratingInput = qs('#rating-value');
            const ratingLabels = ["Sangat Buruk", "Buruk", "Cukup", "Bagus", "Sangat Bagus"];

            function setFormStars(n) {
                formStars.forEach(s => {
                    const v = parseInt(s.dataset.value);
                    if (v <= n) {
                        s.classList.remove('fa-regular', 'text-gray-300');
                        s.classList.add('fa-solid', 'text-yellow-400');
                    } else {
                        s.classList.add('fa-regular', 'text-gray-300');
                        s.classList.remove('fa-solid', 'text-yellow-400');
                    }
                });
                if(n > 0) ratingText.textContent = ratingLabels[n-1];
                if(ratingInput) ratingInput.value = n || '';
            }

            formStars.forEach(s => {
                s.addEventListener('mouseenter', () => setFormStars(parseInt(s.dataset.value)));
                s.addEventListener('mouseleave', () => setFormStars(formSelected));
                s.addEventListener('click', () => { 
                    formSelected = parseInt(s.dataset.value); 
                    setFormStars(formSelected); 
                });
            });

            // LocalStorage Logic
            const storageKey = 'cm_reviews_product_{{ $product->id }}';
            const reviewsList = qs('#reviews-list');
            let storedReviews = [];
            try { storedReviews = JSON.parse(localStorage.getItem(storageKey) || '[]'); } catch(e) { storedReviews = []; }

            if (reviewsList && storedReviews.length) {
                storedReviews.slice().reverse().forEach(r => renderReview(r));
            }

            function renderReview(r) {
                const starHtml = Array.from({length: r.rating}).map(() => '<i class="fa-solid fa-star"></i>').join('');
                const initials = (r.name || '').trim().split(' ').map(p=>p[0]||'').join('').slice(0,2).toUpperCase();
                
                const html = `
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 mb-6 animate-fade-up">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-xs font-bold text-slate-600 shadow-inner">
                                    ${escapeHtml(initials)}
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-slate-900">${escapeHtml(r.name)}</div>
                                    <div class="text-[10px] text-gray-400">Baru saja</div>
                                </div>
                            </div>
                            <div class="flex text-yellow-400 text-xs bg-yellow-50 px-2 py-1 rounded-lg border border-yellow-100">
                                ${starHtml}
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed pl-14">${escapeHtml(r.comment || '-')}</p>
                    </div>
                `;
                reviewsList.insertAdjacentHTML('afterbegin', html);
            }

            const submitReviewBtn = qs('#submit-review');
            const formEl = modal.querySelector('form');
            if (formEl && submitReviewBtn) {
                formEl.addEventListener('submit', (e) => {
                    if (!ratingInput.value) {
                        e.preventDefault();
                        alert('Mohon pilih bintang rating terlebih dahulu');
                        return false;
                    }
                    toggleModal(false);
                });
            }

            function showEmailNotification(email, name) {
                const notifArea = document.getElementById('notification-area');
                const toast = document.createElement('div');
                toast.className = "bg-white border-l-4 border-blue-500 p-4 rounded-xl shadow-2xl email-toast flex gap-4 w-96 pointer-events-auto ring-1 ring-black/5";
                toast.innerHTML = `
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-envelope-circle-check text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Sistem Email (Simulasi)</p>
                        <p class="text-sm font-bold text-slate-800 truncate">To: ${escapeHtml(email)}</p>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">"Hai ${escapeHtml(name)}, Terima kasih telah memberikan ulasan..."</p>
                    </div>
                `;
                notifArea.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 500);
                }, 6000);
            }

            function escapeHtml(unsafe) {
                return String(unsafe).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            }
        });
    </script>

    <script>
        (function(){
            const navbar = document.getElementById('navbar');
            if(!navbar) return;
            window.addEventListener('scroll', () => {
                if (window.scrollY > 10) navbar.classList.add('shadow-sm');
                else navbar.classList.remove('shadow-sm');
            });
        })();
    </script>

    <x-footer />

</body>
</html>