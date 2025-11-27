<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk - SiToko Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased" x-data="productReport()">

    <div class="flex h-screen overflow-hidden">

        @include('Admin._sidebar', ['active' => 'reports'])

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Laporan Produk</h2>
                    <p class="text-gray-500 text-sm mt-1">Analisa performa produk, stok barang, dan pemantauan konten ilegal.</p>
                </div>
                <div class="flex gap-3">
                    <button class="bg-white text-gray-600 hover:text-red-500 hover:bg-red-50 px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm border border-red-100 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Kategori Baru
                    </button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh Laporan
                    </button>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Card Total -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Produk</p>
                    <div class="flex items-end justify-between mt-2">
                        <p class="text-2xl font-bold text-gray-800">2,543</p>
                        <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded">↑ 12%</span>
                    </div>
                </div>

                <!-- Card Terjual -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50">
                    <p class="text-xs font-bold text-gray-400 uppercase">Produk Terjual (Bulan ini)</p>
                    <div class="flex items-end justify-between mt-2">
                        <p class="text-2xl font-bold text-gray-800">8,120</p>
                        <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded">↑ 5.4%</span>
                    </div>
                </div>

                <!-- Card Low Stock -->
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50">
                    <p class="text-xs font-bold text-gray-400 uppercase">Stok Menipis (< 5)</p>
                    <div class="flex items-end justify-between mt-2">
                        <p class="text-2xl font-bold text-yellow-600">142</p>
                        <span class="text-xs text-yellow-600 bg-yellow-100 px-2 py-0.5 rounded">Perlu Restock</span>
                    </div>
                </div>

                 <!-- Card Reported -->
                 <div class="bg-white p-5 rounded-xl shadow-sm border border-red-50">
                    <p class="text-xs font-bold text-gray-400 uppercase">Dilaporkan User</p>
                    <div class="flex items-end justify-between mt-2">
                        <p class="text-2xl font-bold text-red-500">3</p>
                        <span class="text-xs text-red-600 bg-red-100 px-2 py-0.5 rounded">Perlu Review</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-50 overflow-hidden">
                
                <!-- Toolbar Filters -->
                <div class="p-5 border-b border-gray-100 bg-gray-50 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Search -->
                    <div class="relative w-full lg:w-80">
                        <input type="text" x-model="searchQuery" placeholder="Cari nama produk..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent text-sm">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <!-- Filter Groups -->
                    <div class="flex flex-wrap gap-2">
                        <select x-model="filterCategory" class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 text-gray-600 bg-white">
                            <option value="all">Semua Kategori</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Buku">Buku</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Makanan">Makanan</option>
                        </select>

                        <select x-model="filterStock" class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 text-gray-600 bg-white">
                            <option value="all">Status Stok</option>
                            <option value="in_stock">Tersedia</option>
                            <option value="low_stock">Menipis</option>
                            <option value="out_of_stock">Habis</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-gray-500 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                                <th class="p-5 w-1/3">Info Produk</th>
                                <th class="p-5">Kategori</th>
                                <th class="p-5">Harga</th>
                                <th class="p-5 text-center">Stok</th>
                                <th class="p-5 text-center">Terjual</th>
                                <th class="p-5 text-center">Status</th>
                                <th class="p-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <template x-for="product in filteredProducts" :key="product.id">
                                <tr class="hover:bg-red-50/30 transition-colors group">
                                    <td class="p-5">
                                        <div class="flex items-start gap-3">
                                            <img :src="product.image" class="w-12 h-12 rounded-lg object-cover bg-gray-100 border border-gray-200">
                                            <div>
                                                <div class="font-bold text-gray-800 line-clamp-1" x-text="product.name"></div>
                                                <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    <span x-text="product.storeName"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-5">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200" x-text="product.category"></span>
                                    </td>
                                    <td class="p-5 font-medium text-gray-800" x-text="formatRupiah(product.price)"></td>
                                    
                                    <!-- Stock Logic -->
                                    <td class="p-5 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="font-bold" :class="getStockColor(product.stock)" x-text="product.stock"></span>
                                            <span x-show="product.stock < 5" class="text-[10px] text-red-500 font-semibold uppercase tracking-wide">Low!</span>
                                        </div>
                                    </td>

                                    <td class="p-5 text-center text-gray-600" x-text="product.sold"></td>
                                    
                                    <td class="p-5 text-center">
                                         <!-- Active/Banned/Reported Logic -->
                                        <div x-show="product.status === 'active'" class="flex justify-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500" title="Aktif"></div>
                                        </div>
                                        <div x-show="product.status === 'reported'" class="flex justify-center">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600 uppercase border border-red-200">Reported</span>
                                        </div>
                                    </td>
                                    
                                    <td class="p-5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button class="text-gray-400 hover:text-blue-500 p-1.5 hover:bg-blue-50 rounded transition" title="Lihat Produk">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                            <button @click="deleteProduct(product.id)" class="text-gray-400 hover:text-red-500 p-1.5 hover:bg-red-50 rounded transition" title="Hapus / Ban Produk">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                             <!-- Empty State -->
                             <tr x-show="filteredProducts.length === 0">
                                <td colspan="7" class="p-8 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        <p>Tidak ada produk yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-5 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Menampilkan <span x-text="filteredProducts.length"></span> dari 2,543 produk</span>
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
            Alpine.data('productReport', () => ({
                searchQuery: '',
                filterCategory: 'all',
                filterStock: 'all',
                products: [
                    { id: 1, name: 'Buku Pengantar Teknik Informatika', category: 'Buku', price: 85000, stock: 45, sold: 120, storeName: 'Berkah Jaya Book', status: 'active', image: 'https://via.placeholder.com/100?text=Buku' },
                    { id: 2, name: 'Kabel USB Type-C Fast Charging', category: 'Elektronik', price: 25000, stock: 3, sold: 850, storeName: 'Gadget Corner', status: 'active', image: 'https://via.placeholder.com/100?text=Kabel' },
                    { id: 3, name: 'Kemeja Flannel Kotak-kotak', category: 'Fashion', price: 120000, stock: 12, sold: 45, storeName: 'Fashion Kekinian', status: 'active', image: 'https://via.placeholder.com/100?text=Kemeja' },
                    { id: 4, name: 'Keripik Pisang Coklat Lumer', category: 'Makanan', price: 15000, stock: 0, sold: 200, storeName: 'Dapur Mama Siti', status: 'active', image: 'https://via.placeholder.com/100?text=Snack' },
                    { id: 5, name: 'Jasa Install Ulang Windows 10', category: 'Elektronik', price: 50000, stock: 999, sold: 12, storeName: 'Jasa Ketik Kilat', status: 'reported', image: 'https://via.placeholder.com/100?text=Jasa' },
                    { id: 6, name: 'Mouse Wireless Logitech M330', category: 'Elektronik', price: 145000, stock: 8, sold: 67, storeName: 'Gadget Corner', status: 'active', image: 'https://via.placeholder.com/100?text=Mouse' },
                ],

                get filteredProducts() {
                    return this.products.filter(p => {
                        const matchesSearch = p.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                        const matchesCategory = this.filterCategory === 'all' || p.category === this.filterCategory;
                        
                        let matchesStock = true;
                        if (this.filterStock === 'in_stock') matchesStock = p.stock > 5;
                        if (this.filterStock === 'low_stock') matchesStock = p.stock > 0 && p.stock <= 5;
                        if (this.filterStock === 'out_of_stock') matchesStock = p.stock === 0;

                        return matchesSearch && matchesCategory && matchesStock;
                    });
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                },

                getStockColor(stock) {
                    if (stock === 0) return 'text-red-500';
                    if (stock <= 5) return 'text-yellow-600';
                    return 'text-gray-800';
                },

                deleteProduct(id) {
                    if(confirm("Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.")) {
                        this.products = this.products.filter(p => p.id !== id);
                    }
                }
            }))
        })
    </script>
</body>
</html>