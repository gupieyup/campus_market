<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjual - SiToko Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased" x-data="sellerData()">

    <div class="flex h-screen overflow-hidden">

        @include('Admin._sidebar', ['active' => 'penjual'])

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Data Penjual</h2>
                    <p class="text-gray-500 text-sm mt-1">Kelola informasi, status, dan performa seluruh penjual di SiToko.</p>
                </div>
                <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export CSV
                </button>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Card Total -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Total Penjual</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">1,245</p>
                    </div>
                    <div class="h-10 w-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <!-- Card Active -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Aktif Berjualan</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">1,180</p>
                    </div>
                    <div class="h-10 w-10 bg-green-50 text-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <!-- Card Suspended -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Tidak Aktif</p>
                        <p class="text-2xl font-bold text-red-500 mt-1">65</p>
                    </div>
                    <div class="h-10 w-10 bg-red-50 text-red-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Table & Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-50 overflow-hidden">
                
                <!-- Toolbar -->
                <div class="p-5 border-b border-gray-100 bg-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="relative w-full md:w-96">
                        <input type="text" x-model="searchQuery" placeholder="Cari nama penjual, toko, atau email..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent text-sm">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <div class="flex gap-2">
                        <select x-model="filterStatus" class="px-4 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 text-gray-600">
                            <option value="all">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-gray-500 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                                <th class="p-5 cursor-pointer hover:text-red-500">Info Penjual</th>
                                <th class="p-5 cursor-pointer hover:text-red-500">Toko</th>
                                <th class="p-5 text-center">Produk</th>
                                <th class="p-5 text-center">Total Sales</th>
                                <th class="p-5">Status</th>
                                <th class="p-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <template x-for="seller in filteredSellers" :key="seller.id">
                                <tr class="hover:bg-red-50/30 transition-colors group">
                                    <td class="p-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold overflow-hidden">
                                                <img :src="`https://ui-avatars.com/api/?name=${seller.name}&background=random`" alt="Avatar">
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800" x-text="seller.name"></div>
                                                <div class="text-xs text-gray-400" x-text="seller.email"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-5">
                                        <div class="font-semibold text-gray-700" x-text="seller.storeName"></div>
                                        <div class="flex items-center text-xs text-yellow-500 mt-1">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            <span class="ml-1 text-gray-500" x-text="seller.rating + ' / 5.0'"></span>
                                        </div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <span class="bg-gray-100 text-gray-600 py-1 px-2.5 rounded-md text-xs font-bold" x-text="seller.products"></span>
                                    </td>
                                    <td class="p-5 text-center">
                                        <div class="font-medium text-gray-800" x-text="seller.totalSales"></div>
                                    </td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1"
                                            :class="seller.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                                            <span class="w-1.5 h-1.5 rounded-full" :class="seller.status === 'active' ? 'bg-green-500' : 'bg-red-500'"></span>
                                            <span x-text="seller.status === 'active' ? 'Aktif' : 'Tidak Aktif'"></span>
                                        </span>
                                    </td>
                                    <td class="p-5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button class="p-2 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                            <button @click="toggleStatus(seller.id)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" :title="seller.status === 'active' ? 'Suspend Akun' : 'Aktifkan Akun'">
                                                <svg x-show="seller.status === 'active'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                <svg x-show="seller.status !== 'active'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            
                            <!-- Empty State -->
                            <tr x-show="filteredSellers.length === 0">
                                <td colspan="6" class="p-8 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p>Tidak ada data penjual yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-5 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Menampilkan <span x-text="filteredSellers.length"></span> data</span>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-sm border rounded text-gray-400 hover:bg-gray-50 cursor-not-allowed">Previous</button>
                        <button class="px-3 py-1 text-sm border rounded text-gray-600 hover:bg-gray-50 hover:text-red-500">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sellerData', () => ({
                searchQuery: '',
                filterStatus: 'all',
                sellers: [
                    { id: 1, name: 'Budi Santoso', email: 'budi.santoso@gmail.com', storeName: 'Berkah Jaya Book', rating: 4.8, products: 120, totalSales: 'Rp 45.2 jt', status: 'active' },
                    { id: 2, name: 'Siti Aminah', email: 'siti.aminah@yahoo.com', storeName: 'Dapur Mama Siti', rating: 4.9, products: 45, totalSales: 'Rp 12.8 jt', status: 'active' },
                    { id: 3, name: 'Doni Pratama', email: 'doni.pratama@mhs.univ.ac.id', storeName: 'Gadget Corner', rating: 4.5, products: 230, totalSales: 'Rp 156.0 jt', status: 'suspended' },
                    { id: 4, name: 'Rina Kartika', email: 'rina.kartika@gmail.com', storeName: 'Fashion Kekinian', rating: 4.7, products: 88, totalSales: 'Rp 32.5 jt', status: 'active' },
                    { id: 5, name: 'Joko Anwar', email: 'joko.anwar@gmail.com', storeName: 'Joko Craft', rating: 4.2, products: 15, totalSales: 'Rp 2.1 jt', status: 'active' },
                    { id: 6, name: 'Maya Sari', email: 'maya.sari@outlook.com', storeName: 'Maya Beauty', rating: 3.5, products: 60, totalSales: 'Rp 8.4 jt', status: 'suspended' },
                ],

                get filteredSellers() {
                    return this.sellers.filter(seller => {
                        const matchesSearch = seller.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                              seller.storeName.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                              seller.email.toLowerCase().includes(this.searchQuery.toLowerCase());
                        
                        // filterStatus: 'all' | 'active' | 'inactive' (treat any non-'active' as inactive)
                        const matchesFilter = this.filterStatus === 'all' || (
                            this.filterStatus === 'active' ? seller.status === 'active' : seller.status !== 'active'
                        );

                        return matchesSearch && matchesFilter;
                    });
                },

                toggleStatus(id) {
                    const seller = this.sellers.find(s => s.id === id);
                    if (seller) {
                        const action = seller.status === 'active' ? 'menangguhkan' : 'mengaktifkan';
                        if(confirm(`Apakah Anda yakin ingin ${action} akun toko "${seller.storeName}"?`)) {
                            seller.status = seller.status === 'active' ? 'suspended' : 'active';
                        }
                    }
                }
            }))
        })
    </script>
</body>
</html>