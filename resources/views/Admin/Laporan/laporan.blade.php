<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Laporan - SiToko Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased" x-data="reportSystem()">

    <div class="flex h-screen overflow-hidden">

        @include('Admin._sidebar', ['active' => 'reports'])

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Laporan Platform</h2>
                    <p class="text-gray-500 text-sm mt-1">Pilih jenis laporan untuk melihat data spesifik.</p>
                </div>
                <div class="flex gap-3">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh PDF
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-5 flex flex-col lg:flex-row gap-4 items-center justify-between">
                    
                    <div class="w-full lg:w-1/3">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jenis Laporan</label>
                        <select x-model="activeReport" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-400 font-medium text-gray-700 bg-gray-50">
                            <option value="seller_status">Laporan Akun Penjual (Aktif/Non-Aktif)</option> <option value="store_location">Laporan Daftar Toko per Lokasi</option> <option value="product_rating">Laporan Produk Berdasarkan Rating</option> </select>
                    </div>

                    <div class="w-full lg:w-1/3">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pencarian</label>
                        <div class="relative">
                            <input type="text" x-model="searchQuery" placeholder="Cari data..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-400 text-sm">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                                <th class="p-5 w-16 text-center">No</th>
                                
                                <template x-if="activeReport === 'seller_status'">
                                    <React.Fragment>
                                        <th class="p-5">Nama User</th>
                                        <th class="p-5">Nama PIC</th>
                                        <th class="p-5">Nama Toko</th>
                                        <th class="p-5 text-center">Status</th>
                                    </React.Fragment>
                                </template>

                                <template x-if="activeReport === 'store_location'">
                                    <React.Fragment>
                                        <th class="p-5">Nama Toko</th>
                                        <th class="p-5">Nama PIC</th>
                                        <th class="p-5">Propinsi</th>
                                    </React.Fragment>
                                </template>

                                <template x-if="activeReport === 'product_rating'">
                                    <React.Fragment>
                                        <th class="p-5">Produk</th>
                                        <th class="p-5">Kategori</th>
                                        <th class="p-5">Harga</th>
                                        <th class="p-5 text-center">Rating</th>
                                        <th class="p-5">Nama Toko</th>
                                        <th class="p-5">Propinsi</th>
                                    </React.Fragment>
                                </template>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            <template x-for="(item, index) in filteredData" :key="index">
                                <tr class="hover:bg-red-50/30 transition-colors">
                                    <td class="p-5 text-center font-medium text-gray-400" x-text="index + 1"></td>

                                    <template x-if="activeReport === 'seller_status'">
                                        <React.Fragment>
                                            <td class="p-5 font-medium" x-text="item.namaUser"></td>
                                            <td class="p-5" x-text="item.namaPIC"></td>
                                            <td class="p-5 text-blue-600" x-text="item.namaToko"></td>
                                            <td class="p-5 text-center">
                                                <span :class="item.status === 'Aktif' ? 'bg-green-100 text-green-700 border-green-200' : 'bg-gray-100 text-gray-600 border-gray-200'" 
                                                      class="px-3 py-1 rounded-full text-xs font-bold uppercase border" 
                                                      x-text="item.status"></span>
                                            </td>
                                        </React.Fragment>
                                    </template>

                                    <template x-if="activeReport === 'store_location'">
                                        <React.Fragment>
                                            <td class="p-5 font-bold text-gray-800" x-text="item.namaToko"></td>
                                            <td class="p-5" x-text="item.namaPIC"></td>
                                            <td class="p-5">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    <span x-text="item.propinsi"></span>
                                                </div>
                                            </td>
                                        </React.Fragment>
                                    </template>

                                    <template x-if="activeReport === 'product_rating'">
                                        <React.Fragment>
                                            <td class="p-5 font-medium" x-text="item.produk"></td>
                                            <td class="p-5"><span class="bg-gray-100 px-2 py-1 rounded text-xs" x-text="item.kategori"></span></td>
                                            <td class="p-5" x-text="formatRupiah(item.harga)"></td>
                                            <td class="p-5 text-center">
                                                <div class="flex items-center justify-center gap-1 text-yellow-500 font-bold">
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <span x-text="item.rating"></span>
                                                </div>
                                            </td>
                                            <td class="p-5 text-sm text-gray-500" x-text="item.namaToko"></td>
                                            <td class="p-5 text-sm text-gray-500" x-text="item.propinsi"></td>
                                        </React.Fragment>
                                    </template>
                                </tr>
                            </template>

                            <tr x-show="filteredData.length === 0">
                                <td colspan="7" class="p-12 text-center text-gray-400">
                                    <p>Data tidak ditemukan untuk laporan ini.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="p-5 border-t border-gray-100 bg-gray-50 text-xs text-gray-500 flex justify-between">
                    <span x-text="'Total Data: ' + filteredData.length"></span>
                    <span>Dicetak oleh: NamaAkunPemroses</span>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('reportSystem', () => ({
                activeReport: 'seller_status', // Default Report
                searchQuery: '',

                // SRS-MartPlace-09 Data [cite: 5]
                sellerData: [
                    { namaUser: 'User001', namaPIC: 'Budi Santoso', namaToko: 'Elektronik Jaya', status: 'Aktif' },
                    { namaUser: 'User002', namaPIC: 'Siti Aminah', namaToko: 'Dapur Bunda', status: 'Tidak Aktif' },
                    { namaUser: 'User003', namaPIC: 'Andi Wijaya', namaToko: 'Gudang Gadget', status: 'Aktif' },
                    { namaUser: 'User004', namaPIC: 'Rina Marlina', namaToko: 'Fashion Hits', status: 'Tidak Aktif' },
                    { namaUser: 'User005', namaPIC: 'Doni Tata', namaToko: 'Otomotif Part', status: 'Aktif' },
                ],

                // SRS-MartPlace-10 Data [cite: 10]
                storeData: [
                    { namaToko: 'Batik Semar', namaPIC: 'Bambang', propinsi: 'Jawa Tengah' },
                    { namaToko: 'Pempek Candy', namaPIC: 'Ahmad', propinsi: 'Sumatera Selatan' },
                    { namaToko: 'Gudang Gadget', namaPIC: 'Andi Wijaya', propinsi: 'DKI Jakarta' },
                    { namaToko: 'Elektronik Jaya', namaPIC: 'Budi Santoso', propinsi: 'Jawa Timur' },
                    { namaToko: 'Dapur Bunda', namaPIC: 'Siti Aminah', propinsi: 'Jawa Barat' },
                ],

                // SRS-MartPlace-11 Data [cite: 15]
                productData: [
                    { produk: 'Laptop Asus ROG', kategori: 'Elektronik', harga: 15000000, rating: 4.9, namaToko: 'Gudang Gadget', propinsi: 'DKI Jakarta' },
                    { produk: 'Kemeja Batik', kategori: 'Fashion', harga: 150000, rating: 4.5, namaToko: 'Batik Semar', propinsi: 'Jawa Tengah' },
                    { produk: 'Mouse Logitech', kategori: 'Elektronik', harga: 120000, rating: 4.8, namaToko: 'Elektronik Jaya', propinsi: 'Jawa Timur' },
                    { produk: 'Keripik Sanjai', kategori: 'Makanan', harga: 25000, rating: 3.5, namaToko: 'Oleh-oleh Minang', propinsi: 'Sumatera Barat' },
                    { produk: 'Sepatu Sneakers', kategori: 'Fashion', harga: 300000, rating: 4.2, namaToko: 'Fashion Hits', propinsi: 'Jawa Barat' },
                ],

                get filteredData() {
                    let data = [];

                    // 1. Select Data Source
                    if (this.activeReport === 'seller_status') data = this.sellerData;
                    else if (this.activeReport === 'store_location') data = this.storeData;
                    else if (this.activeReport === 'product_rating') data = this.productData;

                    // 2. Filter by Search
                    if (this.searchQuery) {
                        data = data.filter(item => 
                            Object.values(item).some(val => 
                                String(val).toLowerCase().includes(this.searchQuery.toLowerCase())
                            )
                        );
                    }

                    // 3. Apply Sorting Rules Requested in SRS
                    
                    // SRS-MartPlace-09: Urutkan berdasarkan status (aktif dulu baru tidak aktif) 
                    if (this.activeReport === 'seller_status') {
                        data = data.sort((a, b) => a.status.localeCompare(b.status)); // "Aktif" (A) comes before "Tidak Aktif" (T) alphabetically
                    }
                    
                    // SRS-MartPlace-10: Urutkan berdasarkan propinsi 
                    if (this.activeReport === 'store_location') {
                        data = data.sort((a, b) => a.propinsi.localeCompare(b.propinsi));
                    }

                    // SRS-MartPlace-11: Urutkan berdasarkan rating (menurun) 
                    if (this.activeReport === 'product_rating') {
                        data = data.sort((a, b) => b.rating - a.rating);
                    }

                    return data;
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                }
            }))
        })
    </script>
</body>
</html>