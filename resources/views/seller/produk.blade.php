<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Daftar Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom scrollbar matching the style */
        main::-webkit-scrollbar { width: 8px; }
        main::-webkit-scrollbar-thumb { background-color: #fca5a5; border-radius: 4px; }
        main::-webkit-scrollbar-track { background-color: #fef2f2; }
        
        /* Custom Toggle Switch Style (Pure CSS - matching green color) */
        .toggle-checkbox:checked + .toggle-label {
            background-color: #10B981; /* Emerald 500 */
        }
        .toggle-checkbox:checked + .toggle-label .toggle-circle {
            transform: translateX(100%);
        }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">
<div class="flex h-screen overflow-hidden">
    @include('seller.layouts.sidebar', ['activeMenu' => 'produk'])
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
    @include('components.toast')
        
        <!-- Header Halaman -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Inventory List</h1>
            <div class="space-x-4 flex items-center">
                <!-- Tombol Tambah Sekaligus dihapus -->
                <a href="{{ route('seller.tambahproduk') }}" class="flex items-center px-6 py-2 bg-red-500 text-white font-medium rounded-xl shadow-md hover:bg-red-600 transition-colors">
                    <!-- Plus Icon -->
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Produk
                </a>
            </div>
        </div>

        <!-- Panel Filter dan Navigasi Tab -->
        <div class="bg-white rounded-2xl p-4 shadow-md border border-red-100 mb-6">
            
            <!-- Tab Navigasi -->
            <div id="productTabs" class="flex space-x-6 border-b border-gray-100 text-sm font-medium">
                <a href="#" class="pb-3 text-red-500 border-b-2 border-red-500 transition-colors">Semua Produk</a>
                <a href="#" class="pb-3 text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-200 transition-colors">Aktif</a>
                <a href="#" class="pb-3 text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-200 transition-colors">Nonaktif</a>
            </div>

            <!-- Filter Bar -->
            <div class="flex flex-wrap items-center space-y-3 sm:space-y-0 sm:space-x-4 mt-4">
                
                <!-- Pencarian -->
                    <div class="relative flex-1 min-w-[200px]">
                    <input id="productSearch" type="text" placeholder="Cari nama produk atau SKU" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-red-500 focus:border-red-500">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Dropdowns: categories come from DB, filter and sort wired to DB stats -->
                <select id="categorySelect" class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium focus:ring-red-500 focus:border-red-500">
                    <option value="">Semua Kategori</option>
                    @if(!empty($categories))
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    @endif
                </select>
                <select id="filterSelect" class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium focus:ring-red-500 focus:border-red-500">
                    <option value="">Filter</option>
                    <option value="stok-habis">Stok Habis</option>
                    <option value="skor-rendah">Skor Rendah</option>
                </select>
                <!-- Sort removed per request -->

            </div>
        </div>

        <!-- Daftar Produk (Tabel Responsif) -->
        <div class="bg-white rounded-2xl shadow-md border border-red-100 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50/50">
                    <tr>
                        <th class="p-4 text-left">
                            <input type="checkbox" class="rounded text-red-500 border-gray-300 focus:ring-red-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[250px]">Info produk</th>
                        <!-- Kolom Statistik Dihapus -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktif</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atur</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @if(!empty($noSeller) && $noSeller)
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-yellow-700">
                                Anda belum terdaftar sebagai penjual. Tambahkan data penjual terlebih dahulu.
                            </td>
                        </tr>
                    @else
                                @forelse($products as $product)
                                    <tr class="hover:bg-red-50/50 font-medium" data-active="{{ $product->is_active ? '1' : '0' }}" data-category="{{ $product->category_id }}" data-rating="{{ $productRatings[$product->id] ?? 0 }}" data-sold="{{ $productSold[$product->id] ?? 0 }}" data-order="{{ $loop->index }}">
                                <td class="p-4"><input type="checkbox" class="rounded text-red-500 border-gray-300 focus:ring-red-500"></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @php
                                                $img = $product->image ?? null;
                                                if ($img) {
                                                    if (filter_var($img, FILTER_VALIDATE_URL)) {
                                                        $imageUrl = $img;
                                                    } elseif (is_string($img) && Str::startsWith($img, '/')) {
                                                        $imageUrl = asset(ltrim($img, '/'));
                                                    } elseif (is_string($img) && Str::startsWith($img, 'images/')) {
                                                        $imageUrl = asset($img);
                                                    } elseif (is_string($img) && (Str::startsWith($img, '/storage/') || Str::startsWith($img, 'storage/'))) {
                                                        $imageUrl = asset(ltrim($img, '/'));
                                                    } else {
                                                        $imageUrl = asset('storage/' . ltrim((string)$img, '/'));
                                                    }
                                                } else {
                                                    $imageUrl = asset('images/products/default.png');
                                                }
                                            @endphp
                                            <img class="h-10 w-10 rounded-lg object-cover" src="{{ $imageUrl }}" alt="{{ $product->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-gray-900 truncate max-w-xs">{{ $product->name }}</div>
                                            <div class="text-gray-500 text-xs">ID: {{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($product->price,0,',','.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($product->stock ?? 0,0,',','.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                        <a href="{{ route('seller.produk.edit', $product->id) }}" class="action-btn-edit px-3 py-1 text-xs rounded-lg border border-gray-200 hover:bg-gray-50">Edit</a>
                                        <button data-action="toggle" data-id="{{ $product->id }}" class="action-btn-toggle px-3 py-1 text-xs rounded-lg border border-gray-200 hover:bg-gray-50">
                                            @if($product->is_active)
                                                Nonaktifkan
                                            @else
                                                Aktifkan
                                            @endif
                                        </button>

                                        <button data-action="delete" data-id="{{ $product->id }}" class="action-btn-delete px-3 py-1 text-xs rounded-lg bg-red-100 text-red-700 hover:bg-red-200">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada produk. Tambahkan produk baru.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

    </main>
    
    @if(session('success'))
        <script>
            notify({ heading: 'Berhasil', message: '{{ addslashes(session('success')) }}', variant: 'success' });
        </script>
    @endif

<div id="toast" class="fixed right-6 bottom-6 z-50 hidden">
    <div id="toast-msg" class="px-4 py-2 rounded bg-gray-800 text-white shadow">Pesan</div>
</div>

<script>
    (function(){
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showToast(message, timeout = 3000, variant = 'info') {
            if (typeof notify === 'function') {
                notify({ message, variant, timeout });
                return;
            }
            // fallback minimal
            const toast = document.getElementById('toast');
            const msg = document.getElementById('toast-msg');
            if (!toast || !msg) return;
            msg.textContent = message;
            toast.classList.remove('hidden');
            setTimeout(()=>{ toast.classList.add('hidden'); }, timeout);
        }

        async function postJson(url, method = 'POST'){
            const res = await fetch(url, {
                method: method,
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            });

            // Better error handling: if non-2xx, try parse JSON message
            if (!res.ok) {
                let errText = `HTTP ${res.status}`;
                try {
                    const payload = await res.json();
                    console.error('Server error payload:', payload);
                    errText = payload.message || payload.error || JSON.stringify(payload);
                } catch (e) {
                    const txt = await res.text();
                    console.error('Server error text:', txt);
                    errText = txt || errText;
                }
                throw new Error(errText);
            }

            return res.json();
        }

        // Toggle handlers
        document.querySelectorAll('.action-btn-toggle').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const id = btn.dataset.id;
                const url = `{{ url('/dashboard-seller/produk') }}/${id}/toggle`;
                btn.disabled = true;
                try {
                    const data = await postJson(url, 'POST');
                    console.log('toggle response', data);
                    if (data && data.success) {
                        // update button label and status badge in row
                        const row = btn.closest('tr');
                        const badge = row.querySelector('td:nth-child(5) span');
                        if (data.is_active) {
                            badge.textContent = 'Aktif';
                            badge.className = 'px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs';
                            btn.textContent = 'Nonaktifkan';
                            row.dataset.active = '1';
                        } else {
                            badge.textContent = 'Nonaktif';
                            badge.className = 'px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs';
                            btn.textContent = 'Aktifkan';
                            row.dataset.active = '0';
                        }
                        showToast(data.message || 'Status produk diperbarui', 3000, 'success');
                    } else {
                        console.warn('toggle returned no success:', data);
                        showToast((data && data.message) ? data.message : 'Gagal mengubah status produk', 3500, 'error');
                    }
                } catch (err) {
                    console.error('Toggle error:', err);
                    showToast('Gagal mengubah status produk: ' + err.message, 3500, 'error');
                } finally { btn.disabled = false; }
            });
        });

        // Delete handlers
        document.querySelectorAll('.action-btn-delete').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const id = btn.dataset.id;
                if (!confirm('Hapus produk ini? Tindakan tidak dapat dibatalkan.')) return;
                const url = `{{ url('/dashboard-seller/produk') }}/${id}`;
                btn.disabled = true;
                try {
                    const res = await fetch(url, {
                        method: 'DELETE',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({})
                    });

                    if (!res.ok) {
                        let bodyText = '';
                        try { bodyText = await res.json(); console.error('Delete error payload', bodyText); } catch(e) { bodyText = await res.text(); console.error('Delete error text', bodyText); }
                        throw new Error(bodyText?.message || bodyText || `HTTP ${res.status}`);
                    }

                    const data = await res.json();
                    if (data && data.success) {
                        // remove row
                        const row = btn.closest('tr');
                        row.parentNode.removeChild(row);
                        showToast(data.message, 3000, 'success');
                    } else {
                        showToast('Gagal menghapus produk', 3500, 'error');
                    }
                } catch (err) {
                    console.error(err);
                    showToast('Terjadi kesalahan jaringan', 3500, 'error');
                } finally { btn.disabled = false; }
            });
        });

        // Simple client-side filtering for tabs, search, category, filter and sort
        const allRows = Array.from(document.querySelectorAll('tbody tr')).filter(r => r.dataset.active !== undefined);
        const tbody = document.querySelector('tbody');

        function applyFilters(){
            const activeTab = document.querySelector('#productTabs a.text-red-500');
            const tabKey = activeTab ? activeTab.textContent.trim().toLowerCase() : 'semua produk';
            let status = 'semua produk';
            // check 'non' first to avoid matching 'aktif' substring inside 'nonaktif'
            if (tabKey === 'nonaktif' || tabKey.includes('non')) status = 'nonaktif';
            else if (tabKey === 'aktif' || tabKey.includes('aktif')) status = 'aktif';

            const q = (document.getElementById('productSearch')?.value || '').trim().toLowerCase();
            const categoryVal = document.getElementById('categorySelect')?.value || '';
            const filterVal = document.getElementById('filterSelect')?.value || '';
            const sortVal = document.getElementById('sortSelect')?.value || '';

            // determine visible rows
            let visibleRows = [];
            allRows.forEach(row => {
                const isActive = row.dataset.active === '1';
                let statusMatch = true;
                if (status === 'aktif') statusMatch = isActive === true;
                else if (status === 'nonaktif') statusMatch = isActive === false;

                // category match
                const catMatch = !categoryVal || row.dataset.category === categoryVal;

                // search match
                const nameEl = row.querySelector('.text-gray-900');
                const name = nameEl ? nameEl.textContent.toLowerCase() : '';
                const queryMatch = q === '' || name.includes(q);

                // filter match
                let filterMatch = true;
                if (filterVal === 'stok-habis') {
                    const stock = parseInt(row.querySelector('td:nth-child(4)').textContent.replace(/[^0-9]/g,'')) || 0;
                    filterMatch = stock <= 0;
                } else if (filterVal === 'skor-rendah') {
                    const rating = parseFloat(row.dataset.rating || 0);
                    filterMatch = rating > 0 ? rating < 3 : false; // only show if rated and low
                }

                if (statusMatch && catMatch && queryMatch && filterMatch) {
                    row.style.display = '';
                    visibleRows.push(row);
                } else {
                    row.style.display = 'none';
                }
            });

            // sorting: reorder visible rows inside tbody
            // Sorting removed; keep server-side ordering

            // append rows in order
            visibleRows.forEach(r => tbody.appendChild(r));
        }

        // Tabs behavior
        const tabs = document.querySelectorAll('#productTabs a');
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                // reset classes
                tabs.forEach(t => {
                    t.classList.remove('text-red-500', 'border-b-2', 'border-red-500');
                    t.classList.add('text-gray-500');
                });
                tab.classList.remove('text-gray-500');
                tab.classList.add('text-red-500', 'border-b-2', 'border-red-500');

                const key = tab.textContent.trim().toLowerCase();
                // normalize explicitly to avoid substring collisions (e.g. 'nonaktif' contains 'aktif')
                let norm = 'semua produk';
                if (key === 'semua produk' || key.includes('semua')) norm = 'semua produk';
                else if (key === 'nonaktif' || key.includes('non')) norm = 'nonaktif';
                else if (key === 'aktif' || key === 'aktif' || key.includes('aktif')) norm = 'aktif';
                else if (key === 'draf' || key.includes('draf')) norm = 'draf';
                // apply all filters (tab click changes status)
                applyFilters();
            });
        });

        // Search behavior
        const searchInput = document.getElementById('productSearch');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const q = e.target.value.trim().toLowerCase();
                const activeTab = document.querySelector('#productTabs a.text-red-500');
                const key = activeTab ? activeTab.textContent.trim().toLowerCase() : 'semua produk';
                applyFilters();
            });
        }

        // attach listeners to selects and search
        document.getElementById('categorySelect')?.addEventListener('change', applyFilters);
        document.getElementById('filterSelect')?.addEventListener('change', applyFilters);
        // Sort select removed
        document.getElementById('productSearch')?.addEventListener('input', applyFilters);

        // initial apply
        applyFilters();
    })();
</script>

</body>
</html>