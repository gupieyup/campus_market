<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Daftar Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
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
            <div class="flex space-x-6 border-b border-gray-100 text-sm font-medium">
                <a href="#" class="pb-3 text-red-500 border-b-2 border-red-500 transition-colors">Semua Produk (29)</a>
                <a href="#" class="pb-3 text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-200 transition-colors">Aktif (25)</a>
                <a href="#" class="pb-3 text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-200 transition-colors">Nonaktif (5)</a>
                <a href="#" class="pb-3 text-gray-500 hover:text-red-500 hover:border-b-2 hover:border-red-200 transition-colors">Draf (2)</a>
            </div>

            <!-- Filter Bar -->
            <div class="flex flex-wrap items-center space-y-3 sm:space-y-0 sm:space-x-4 mt-4">
                
                <!-- Pencarian -->
                <div class="relative flex-1 min-w-[200px]">
                    <input type="text" placeholder="Cari nama produk atau SKU" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-red-500 focus:border-red-500">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Dropdown Filter -->
                <select class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium focus:ring-red-500 focus:border-red-500">
                    <option>Kategori</option>
                    <option>Makanan</option>
                    <option>Elektronik</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium focus:ring-red-500 focus:border-red-500">
                    <option>Filter</option>
                    <option>Stok Habis</option>
                    <option>Skor Rendah</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium focus:ring-red-500 focus:border-red-500">
                    <option>Urutkan</option>
                    <option>Terbaru</option>
                    <option>Terlaris</option>
                </select>

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
                <tbody class="bg-white divide-y divide-gray-100" id="productList">
                    <!-- Product rows will be injected by JavaScript -->
                </tbody>
            </table>
        </div>

    </main>

    <script>
        // Data Produk Fiktif
        const productData = [
            {
                id: 1,
                name: 'Sepatu NK42 Hitam',
                sku: 'NK42HITAM',
                image: 'https://placehold.co/40x40/000000/FFFFFF?text=SKU',
                price: 75000000,
                stock: null, // Induk tidak memiliki stok
                score: 'Sempurna',
                views: 413,
                sales: 434,
                isActive: true,
                variants: [
                    { name: 'Hitam', sku: 'S64-Hitam', price: 2500000, stock: 40, score: 'Baik', views: 32, sales: 12, isActive: true },
                    { name: 'Putih', sku: 'S64-Putih', price: 2500000, stock: 1400, score: 'Cukup', views: 44, sales: 5, isActive: true },
                    { name: 'Hitam Gold', sku: 'S64-HG', price: 1240000, stock: 12, score: 'Kurang', views: 0, sales: 0, isActive: false },
                ]
            },
            {
                id: 2,
                name: 'Buku Saku Kuliah Premium',
                sku: 'BSK-P01',
                image: 'https://placehold.co/40x40/FCA5A5/FFFFFF?text=BUK',
                price: 85000,
                stock: 150,
                score: 'Sempurna',
                views: 1200,
                sales: 1050,
                isActive: true,
                variants: []
            },
            {
                id: 3,
                name: 'Headset Gaming Super Bass',
                sku: 'HGSB-L3',
                image: 'https://placehold.co/40x40/6366F1/FFFFFF?text=HDS',
                price: 150000,
                stock: 5, // Stok Rendah
                score: 'Cukup',
                views: 70,
                sales: 15,
                isActive: false,
                variants: []
            }
        ];

        // Helper untuk format Rupiah
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        };

        // Helper untuk mendapatkan warna skor (Masih diperlukan untuk varian/score)
        const getScoreColor = (score) => {
            switch (score) {
                case 'Sempurna': return 'bg-green-100 text-green-700';
                case 'Baik': return 'bg-emerald-100 text-emerald-700';
                case 'Cukup': return 'bg-yellow-100 text-yellow-700';
                case 'Kurang': return 'bg-red-100 text-red-700';
                default: return 'bg-gray-100 text-gray-500';
            }
        };

        // Helper untuk membuat Toggle Switch HTML
        const createToggleSwitch = (id, isActive) => {
            const checked = isActive ? 'checked' : '';
            return `
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle-${id}" ${checked} class="sr-only toggle-checkbox">
                    <div class="w-9 h-5 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 toggle-label">
                        <div class="absolute top-[2px] left-[2px] w-4 h-4 bg-white rounded-full transition-transform duration-300 toggle-circle"></div>
                    </div>
                </label>
            `;
        };
        
        // Fungsi untuk me-render satu baris produk
        const renderProductRow = (product, isVariant = false) => {
            const rowClass = isVariant ? 'bg-gray-50/50 text-xs' : 'font-medium';
            // Variabel viewsText, salesText, dan score tidak digunakan lagi di render
            // const viewsText = product.views ? product.views.toLocaleString('id-ID') : 0;
            // const salesText = product.sales ? product.sales.toLocaleString('id-ID') : 0;
            const stockText = product.stock !== null ? product.stock.toLocaleString('id-ID') : '-';
            const priceText = formatRupiah(product.price);
            const toggleId = isVariant ? `variant-${product.sku}` : `product-${product.id}`;

            // Jika produk induk, tampilkan total harga dan hilangkan stok
            const parentPriceDisplay = !isVariant && product.variants.length > 0 ? `<span class="text-sm text-gray-500">Mulai dari</span><br/>${priceText}` : priceText;

            // Baris Utama Produk/Varian
            let rowHtml = `
                <tr class="hover:bg-red-50/50 ${rowClass}">
                    <td class="p-4"><input type="checkbox" class="rounded text-red-500 border-gray-300 focus:ring-red-500"></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-lg" src="${product.image}" alt="${product.name}">
                            </div>
                            <div class="ml-4">
                                <div class="text-gray-900 truncate max-w-xs">${isVariant ? product.name : product.name}</div>
                                <div class="text-gray-500 text-xs">SKU: ${product.sku}</div>
                            </div>
                        </div>
                    </td>
                    <!-- Kolom Statistik Dihapus -->
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${parentPriceDisplay}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${stockText}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${createToggleSwitch(toggleId, product.isActive)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <button class="text-gray-500 hover:text-red-500 transition-colors">Atur</button>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </td>
                </tr>
            `;
            
            // Jika produk memiliki varian, tambahkan tombol "Lihat varian produk" dan baris varian
            if (product.variants && product.variants.length > 0) {
                // Tombol Lihat Varian
                rowHtml += `
                    <tr class="bg-white hover:bg-red-50/50">
                        <!-- colspan diubah dari 7 menjadi 6 -->
                        <td colspan="6" class="px-6 py-2 text-sm text-red-500 cursor-pointer font-medium" onclick="toggleVariants(${product.id})">
                            <span id="toggleText-${product.id}">Lihat ${product.variants.length} varian produk</span>
                        </td>
                    </tr>
                `;

                // Baris Varian (tersembunyi secara default)
                product.variants.forEach(variant => {
                    rowHtml += `
                        <tr class="variant-row-${product.id} hidden bg-red-50/20 hover:bg-red-50/50 text-xs">
                            <td class="p-4 pl-8"><input type="checkbox" class="rounded text-red-500 border-gray-300 focus:ring-red-500"></td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="flex items-center pl-4">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-md border border-gray-200" src="https://placehold.co/32x32/E5E7EB/A1A1AA?text=V" alt="${variant.name}">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-gray-700">${variant.name}</div>
                                        <div class="text-gray-500 text-xs">SKU: ${variant.sku}</div>
                                    </div>
                                </div>
                            </td>
                            <!-- Kolom Statistik Varian Dihapus -->
                            <td class="px-6 py-2 whitespace-nowrap text-gray-700">${formatRupiah(variant.price)}</td>
                            <td class="px-6 py-2 whitespace-nowrap text-gray-700">${variant.stock.toLocaleString('id-ID')}</td>
                            <td class="px-6 py-2 whitespace-nowrap">${createToggleSwitch(`variant-${variant.sku}`, variant.isActive)}</td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button class="text-gray-500 hover:text-red-500 transition-colors">Atur</button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            return rowHtml;
        };

        // Fungsi untuk me-render semua produk ke tabel
        const renderProductList = () => {
            const productListElement = document.getElementById('productList');
            productListElement.innerHTML = '';
            productData.forEach(product => {
                productListElement.innerHTML += renderProductRow(product);
            });
        };

        // Fungsi untuk menampilkan/menyembunyikan varian
        window.toggleVariants = (productId) => {
            const rows = document.querySelectorAll(`.variant-row-${productId}`);
            const toggleText = document.getElementById(`toggleText-${productId}`);
            let isHidden = true;

            rows.forEach(row => {
                if (row.classList.contains('hidden')) {
                    row.classList.remove('hidden');
                    isHidden = false;
                } else {
                    row.classList.add('hidden');
                }
            });

            if (isHidden) {
                toggleText.textContent = `Lihat ${rows.length} varian produk`;
            } else {
                toggleText.textContent = `Sembunyikan varian produk`;
            }
        };

        // Panggil fungsi render saat halaman dimuat
        document.addEventListener('DOMContentLoaded', renderProductList);
    </script>
</body>
</html>