<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjual - SiToko Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        @include('admin._sidebar', ['active' => 'penjual', 'verifCount' => 3])

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Data Penjual</h2>
                    <p class="text-gray-500 text-sm mt-1">Kelola informasi, status, dan performa seluruh penjual di SiToko.</p>
                </div>
                <a href="{{ route('admin.sellers.export') }}" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export CSV
                </a>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card Total -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Total Penjual</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalSellers) }}</p>
                    </div>
                    <div class="h-10 w-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <!-- Card Active -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Aktif Berjualan</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($activeSellers) }}</p>
                    </div>
                    <div class="h-10 w-10 bg-green-50 text-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <!-- Card Suspended -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Tidak Aktif</p>
                        <p class="text-2xl font-bold text-red-500 mt-1">{{ number_format($inactiveSellers) }}</p>
                    </div>
                    <div class="h-10 w-10 bg-red-50 text-red-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Table & Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-50 overflow-hidden">
                
                <!-- Toolbar -->
                <form method="GET" action="{{ route('admin.sellers.index') }}" id="filterForm" class="p-5 border-b border-gray-100 bg-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="relative w-full md:w-96">
                        <input 
                            type="text" 
                            name="search" 
                            id="searchInput"
                            value="{{ $search }}" 
                            placeholder="Cari nama penjual, toko, atau email..." 
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent text-sm">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <div class="flex gap-2">
                        <select name="status" onchange="this.form.submit()" class="px-4 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 text-gray-600">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition">
                            Cari
                        </button>
                    </div>
                </form>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-gray-500 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                                <th class="p-5">Info Penjual</th>
                                <th class="p-5">Toko</th>
                                <th class="p-5 text-center">Produk</th>
                                <th class="p-5">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($sellers as $seller)
                                <tr class="hover:bg-red-50/30 transition-colors">
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold overflow-hidden">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($seller->user->name ?? 'User') }}&background=random" alt="Avatar">
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800">{{ $seller->user->name ?? '-' }}</div>
                                                <div class="text-xs text-gray-400">{{ $seller->user->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-5">
                                        <div class="font-semibold text-gray-700">{{ $seller->shop_name }}</div>
                                        <div class="flex items-center text-xs text-yellow-500 mt-1">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            <span class="ml-1 text-gray-500">{{ $seller->avg_rating }} / 5.0</span>
                                        </div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="bg-gray-100 text-gray-600 py-1 px-2.5 rounded-md text-xs font-bold">{{ $seller->product_count }}</span>
                                    </td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1 {{ $seller->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $seller->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            <span>{{ $seller->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p>Tidak ada data penjual yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-5 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm text-gray-500">
                        Menampilkan {{ $sellers->count() }} dari {{ $sellers->total() }} data
                    </span>
                    <div class="flex gap-2">
                        {{ $sellers->appends(['search' => $search, 'status' => $status])->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Auto submit form saat mengetik di search input (dengan debounce)
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const filterForm = document.getElementById('filterForm');

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                filterForm.submit();
            }, 500); // Submit setelah 500ms user berhenti mengetik
        });
    </script>
</body>
</html>