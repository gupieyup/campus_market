<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        // Demo Fallbacks (Logic Tetap)
        if (!isset($product)) {
            $product = (object) [
                'id' => 0,
                'name' => 'Kalung Wanita Kupu-Kupu Perak - Kalung Murah Kekinian',
                'image' => 'placeholder.png', 
                'price' => 200000,
                'description' => "Kalung perak wanita dengan liontin kupu-kupu yang elegan.\n\nSpesifikasi:\n- Bahan: Silver 925\n- Panjang: 45cm\n- Anti karat dan tahan lama.\n\nCocok untuk hadiah atau pemakaian sehari-hari.",
                'shop' => (object) ['name' => 'Beauty Jewelry']
            ];
        }

        if (!isset($reviews) || !($reviews instanceof \Illuminate\Support\Collection)) {
            $reviews = \Illuminate\Support\Collection::make([]);
        }
    @endphp
    <title>{{ $product->name }} - CampusMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Open Sans', sans-serif; }

        /* Warna Utama (Pink Theme) */
        :root { 
            --primary: #FF7A7A; 
            --primary-hover: #ff6363;
        }

        /* Background Gradient */
            .page-bg { background: #FFEBEB; }

        /* Utilities */
        .text-primary { color: var(--primary); }
        .bg-primary { background-color: var(--primary); }
        .border-primary { border-color: var(--primary); }
        
        /* Tokopedia-like Shadows & Cards */
        .card-shadow { box-shadow: 0 8px 24px rgba(15,23,42,0.06); border-radius: 12px; }
        .sticky-card { position: sticky; top: 100px; }

        /* Card helpers */
        .product-price { font-size: 1.5rem; font-weight: 800; color: #111827; }
        .card-sub { color: #6b7280; font-size: .875rem; }
        
        /* Form Inputs */
        .form-input {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 1px var(--primary);
        }
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
    </style>
</head>
<body class="page-bg min-h-screen text-gray-700 pb-20 md:pb-0">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm transition-all duration-300" id="navbar">
        <div class="tokped-container h-16 flex items-center justify-between gap-6">
            <a href="/" class="flex items-center gap-2 text-[#FF9894] hover:text-pink-600 transition group">
                <div class="bg-pink-50 p-2 rounded-lg group-hover:bg-pink-100 transition">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                </div>
                <span class="font-bold text-xl tracking-tight hidden md:block">SiToko</span>
            </a>

            <div class="hidden md:flex flex-1 max-w-2xl relative">
                <input type="text" placeholder="Cari barang di SiToko..." class="w-full border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:border-[#FF9894] focus:ring-1 focus:ring-[#FF9894] transition-all text-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-sm"></i>
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

    <main class="tokped-container py-6 md:py-8">
        
        <div class="text-xs text-primary mb-4 font-medium">Home &gt; Fashion &gt; {{ $product->name }}</div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <div class="md:col-span-4 lg:col-span-4">
                <div class="sticky top-24">
                    <div class="aspect-square rounded-xl overflow-hidden border border-gray-100 card-shadow relative group bg-white">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                </div>
            </div>

            <div class="md:col-span-8 lg:col-span-5 space-y-6">
                
                <div class="bg-white md:bg-transparent rounded-xl p-4 md:p-0 card-shadow md:shadow-none">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800 leading-snug mb-2">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-2 text-sm mb-3">
                        <span class="font-bold text-gray-800">Terjual 300+</span>
                        <span class="text-gray-300">•</span>
                        <div class="flex items-center text-yellow-400 gap-1">
                            <i class="fa-solid fa-star"></i>
                            <span class="text-gray-800 font-bold" id="avg-rating">4.9</span>
                            <span class="text-gray-500 font-normal" id="avg-count">({{ $reviews->count() }} rating)</span>
                        </div>
                    </div>

                    <div class="text-3xl font-bold text-gray-800 md:hidden block mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>

                <div class="bg-white rounded-xl p-6 card-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-800">Detail Produk</h2>
                        <div class="text-sm text-gray-500">• {{ $product->shop->name }}</div>
                    </div>

                    @php
                        $descLines = preg_split('/\r\n|\r|\n/', trim($product->description ?? '')) ?: [];
                        $paras = array_values(array_filter($descLines, function($l){ return trim($l) !== '' && substr(trim($l),0,1) !== '-'; }));
                        $bullets = array_values(array_filter($descLines, function($l){ return substr(trim($l),0,1) === '-'; }));
                    @endphp

                    <div class="text-sm text-gray-600 leading-relaxed">
                        @if(count($paras))
                            @foreach($paras as $p)
                                <p class="mb-3">{{ $p }}</p>
                            @endforeach
                        @endif

                        @if(count($bullets))
                            <div class="mt-3">
                                <h4 class="font-semibold text-gray-700 mb-2">Spesifikasi</h4>
                                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                    @foreach($bullets as $b)
                                        <li>{{ ltrim($b, "- ") }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-3">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white text-xl">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <div>
                            <div class="font-bold text-gray-800">{{ $product->shop->name }}</div>
                            <!-- Online status removed per request -->
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-0 pt-2">
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Ulasan Pembeli</h3>
                    
                    <div class="flex items-center gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
                        <div class="text-4xl font-bold text-gray-800 flex items-end">
                            <span id="big-avg">4.9</span><span class="text-lg text-gray-400 font-normal">/5</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex text-yellow-400 text-sm mb-1">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <div class="text-xs text-gray-500 font-medium">{{ $reviews->count() }} Ulasan</div>
                        </div>
                    </div>

                    <div class="text-sm font-semibold text-gray-800 mb-4 pb-2 border-b">Paling Relevan</div>

                    <div id="reviews-list" class="space-y-4">
                        @forelse($reviews as $review)
                            <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-bold text-gray-600">
                                        {{ strtoupper(substr(trim($review->user_name),0,2)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-800">{{ $review->user_name }}</div>
                                        <div class="text-[11px] text-gray-400">{{ \Carbon\Carbon::parse($review->created_at)->format('d F Y') }}</div>
                                    </div>
                                </div>
                                <div class="flex text-yellow-400 text-sm mb-2">
                                    @for($i=0; $i<$review->rating; $i++) <i class="fa-solid fa-star"></i> @endfor
                                </div>
                                <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <div class="bg-white rounded-lg p-4 border border-gray-100 shadow-sm">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-bold text-gray-600">C</div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-800">Clara S.</div>
                                        <div class="text-[11px] text-gray-400">20 September 2025</div>
                                    </div>
                                </div>
                                <div class="flex text-yellow-400 text-sm mb-2">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-sm text-gray-700">Suka banget sama kalungnya! Desainnya cantik dan kelihatan mewah.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="hidden lg:block lg:col-span-3">
                <div class="sticky-card bg-white p-6 card-shadow border border-gray-100">
                    <h3 class="font-semibold text-gray-700 mb-2">Info Produk</h3>

                    <div class="card-sub mb-1">Harga</div>
                    <div class="product-price mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                    <!-- Removed: Terjual / Kondisi line as requested -->

                    <div class="border-t border-gray-100 my-4"></div>

                    <button id="open-review-form-desktop" class="w-full bg-primary text-white font-bold py-3 rounded-lg shadow hover:bg-[#ff6363] transition">Beri Ulasan</button>

                    <div class="mt-4 text-xs text-gray-400 text-center">
                        <i class="fa-solid fa-shield-halved mr-1"></i> Aman & Terpercaya
                    </div>
                </div>
            </div>

        </div> <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 flex gap-3 lg:hidden z-40 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
             <button id="open-review-form-mobile" class="w-full bg-white border border-primary text-primary font-bold py-2 rounded-lg text-sm hover:bg-red-50">
                Beri Ulasan
            </button>
        </div>

        <div id="review-form-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden flex items-center justify-center p-4 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden animate-[fadeIn_0.2s_ease-out]">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                    <h4 class="font-bold text-gray-800">Tulis Ulasan</h4>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                
                <div class="p-6 max-h-[80vh] overflow-y-auto">
                    <div class="mb-6 text-center">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Bagaimana kualitas produk ini?</label>
                        <div id="form-star-rating" class="flex justify-center text-gray-300 text-3xl gap-2 cursor-pointer">
                            <i class="fa-solid fa-star form-star transition hover:text-yellow-400" data-value="1"></i>
                            <i class="fa-solid fa-star form-star transition hover:text-yellow-400" data-value="2"></i>
                            <i class="fa-solid fa-star form-star transition hover:text-yellow-400" data-value="3"></i>
                            <i class="fa-solid fa-star form-star transition hover:text-yellow-400" data-value="4"></i>
                            <i class="fa-solid fa-star form-star transition hover:text-yellow-400" data-value="5"></i>
                        </div>
                        <div id="rating-text" class="text-xs text-yellow-500 font-bold mt-2 h-4"></div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Nama</label>
                                <input type="text" id="review-name" class="form-input w-full p-2.5 text-sm" placeholder="Nama Lengkap">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">No. HP</label>
                                <input type="tel" id="review-phone" class="form-input w-full p-2.5 text-sm" placeholder="0812...">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Email</label>
                            <input type="email" id="review-email" class="form-input w-full p-2.5 text-sm" placeholder="email@contoh.com">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Provinsi</label>
                            <select id="review-provinsi" class="form-input w-full p-2.5 text-sm bg-white">
                                <option value="">Pilih Provinsi...</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Ulasan Kamu</label>
                            <textarea id="review-comment" rows="3" class="form-input w-full p-2.5 text-sm" placeholder="Ceritakan kepuasanmu tentang kualitas barang & pelayanan toko ini..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button id="cancel-review" class="px-4 py-2 text-sm font-bold text-gray-500 hover:bg-gray-200 rounded-lg transition">Batal</button>
                    <button id="submit-review" class="px-6 py-2 text-sm font-bold bg-primary text-white rounded-lg shadow hover:bg-red-500 transition">Kirim</button>
                </div>
            </div>
        </div>

    </main>

    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Helpers
            const qs = (sel) => document.querySelector(sel);
            const qsa = (sel) => document.querySelectorAll(sel);

            // 1. Modal Handling
            const modal = qs('#review-form-modal');
            const openBtns = [qs('#open-review-form-desktop'), qs('#open-review-form-mobile')];
            const closeBtn = qs('#close-modal');
            const cancelBtn = qs('#cancel-review');

            function toggleModal(show) {
                if(show) modal.classList.remove('hidden');
                else modal.classList.add('hidden');
            }

            openBtns.forEach(btn => {
                if(btn) btn.addEventListener('click', () => toggleModal(true));
            });
            
            [closeBtn, cancelBtn].forEach(btn => {
                if(btn) btn.addEventListener('click', () => toggleModal(false));
            });

            // Close on click outside
            modal.addEventListener('click', (e) => {
                if(e.target === modal) toggleModal(false);
            });


            // 2. Fetch Provinces
            const provSelect = qs('#review-provinsi');
            if (provSelect) {
                fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                    .then(r => r.json())
                    .then(list => {
                        list.forEach(p => {
                            const opt = document.createElement('option'); opt.value = p.name; opt.textContent = p.name; provSelect.appendChild(opt);
                        });
                    }).catch(()=>{});
            }


            // 3. Form Star Logic
            let formSelected = 0;
            const formStars = qsa('.form-star');
            const ratingText = qs('#rating-text');
            const ratingLabels = ["Sangat Buruk", "Buruk", "Cukup", "Bagus", "Sangat Bagus"];

            function setFormStars(n) {
                formStars.forEach(s => {
                    const v = parseInt(s.dataset.value);
                    if (v <= n) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
                if(n > 0) ratingText.textContent = ratingLabels[n-1];
            }

            formStars.forEach(s => {
                s.addEventListener('mouseenter', () => setFormStars(parseInt(s.dataset.value)));
                s.addEventListener('mouseleave', () => setFormStars(formSelected));
                s.addEventListener('click', () => { 
                    formSelected = parseInt(s.dataset.value); 
                    setFormStars(formSelected); 
                });
            });


            // 4. Local Storage Review Logic
            const storageKey = 'cm_reviews_product_{{ $product->id }}';
            const serverCount = {{ $reviews->count() }};
            const serverSum = {{ $reviews->count() > 0 ? $reviews->sum('rating') : 0 }};
            
            let storedReviews = [];
            try { storedReviews = JSON.parse(localStorage.getItem(storageKey) || '[]'); } catch(e) { storedReviews = []; }

            let totalReviewCount = storedReviews.length; 
            let currentTotalCount = serverCount + totalReviewCount;
            
            // Render Stored Reviews
            const reviewsList = qs('#reviews-list');
            
            if (reviewsList && storedReviews.length) {
                storedReviews.slice().reverse().forEach(r => {
                    const starHtml = Array.from({length: r.rating}).map(() => '<i class="fa-solid fa-star"></i>').join('');
                    const initials = (r.name || '').trim().split(' ').map(p=>p[0]||'').join('').slice(0,2).toUpperCase();
                    
                    const html = `
                        <div class="border-b border-gray-100 pb-4 last:border-0 bg-yellow-50 p-3 rounded-lg mb-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center text-[10px] font-bold">
                                    ${escapeHtml(initials)}
                                </div>
                                <div class="text-xs font-bold text-gray-800">${escapeHtml(r.name)} <span class="font-normal text-gray-400">• Baru saja</span></div>
                            </div>
                            <div class="flex text-yellow-400 text-[10px] mb-2">${starHtml}</div>
                            <p class="text-sm text-gray-700">${escapeHtml(r.comment || '-')}</p>
                        </div>
                    `;
                    reviewsList.insertAdjacentHTML('afterbegin', html);
                });
            }

            if(storedReviews.length > 0) {
                 const avgCountEl = qs('#avg-count');
                 if(avgCountEl) avgCountEl.textContent = `(${currentTotalCount} rating)`;
            }

            // Submit Handler
            const submitReviewBtn = qs('#submit-review');
            submitReviewBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const name = qs('#review-name').value.trim();
                const phone = qs('#review-phone').value.trim();
                const prov = qs('#review-provinsi').value.trim();
                const email = qs('#review-email').value.trim();
                const comment = qs('#review-comment').value.trim();
                const rating = formSelected;

                if (!name || !phone || !prov || !email || !rating) {
                    alert('Mohon lengkapi data dan pilih bintang!');
                    return;
                }

                const reviewObj = { name, phone, provinsi: prov, email, comment, rating, created_at: new Date().toISOString() };
                storedReviews.push(reviewObj);
                localStorage.setItem(storageKey, JSON.stringify(storedReviews));

                alert('Ulasan berhasil disimpan!');
                location.reload(); 
            });

            function escapeHtml(unsafe) {
                return String(unsafe).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            }
        });
    </script>

    <script>
        // Navbar shadow on scroll (match home behavior)
        (function(){
            const navbar = document.getElementById('navbar');
            if(!navbar) return;
            window.addEventListener('scroll', () => {
                if (window.scrollY > 10) navbar.classList.add('shadow-md');
                else navbar.classList.remove('shadow-md');
            });
        })();
    </script>

</body>
</html>