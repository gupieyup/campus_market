<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Laporan Penjual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom scrollbar matching the style */
        main::-webkit-scrollbar { width: 8px; }
        main::-webkit-scrollbar-thumb { background-color: #fca5a5; border-radius: 4px; }
        main::-webkit-scrollbar-track { background-color: #fef2f2; }
        
        /* Definisi Warna */
        .color-primary { background-color: #EF4444; } /* Red 500 */
        .color-light { background-color: #FEE2E2; } /* Red 100 */
        .color-critical { background-color: #FCA5A5; } /* Red 300 - untuk baris kritis */
        .color-reorder-header { background-color: #EF4444; color: white; } /* Header Merah */

        /* Gaya Khusus untuk Cetak/Print */
        @media print {
            body { background-color: #fff; margin: 0; }
            .no-print { display: none; }
            .print-area { 
                margin: 0; 
                padding: 0; 
                width: 100%; 
                box-shadow: none; 
                border: none;
            }
            .page-break { page-break-before: always; }
            
            /* Menghilangkan warna background untuk efisiensi tinta kecuali header yang penting */
            .table-header-light th { background-color: #fef2f2 !important; -webkit-print-color-adjust: exact; }
            .table-header-critical th { background-color: #EF4444 !important; color: white !important; -webkit-print-color-adjust: exact; }
            .table-critical-row td { background-color: #FEE2E2 !important; -webkit-print-color-adjust: exact; }

            h1, h2, h3, p { color: #000 !important; }
        }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">
<div class="flex h-screen overflow-hidden">
    @include('seller.layouts.sidebar', ['activeMenu' => 'laporan'])
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
        
        <!-- Header Halaman (Tombol Cetak) -->
        <div class="flex justify-between items-center mb-6 no-print">
            <h1 class="text-3xl font-semibold text-gray-800">Cetak Laporan Penjual</h1>
            <button onclick="window.print()" class="flex items-center px-6 py-2 color-primary text-white font-medium rounded-xl shadow-md hover:bg-red-600 transition-colors">
                <!-- Print Icon -->
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m0 0v-4a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6"></path></svg>
                Cetak ke PDF
            </button>
        </div>

        <!-- Kontainer Laporan -->
        <div class="max-w-4xl mx-auto space-y-12 bg-white rounded-2xl shadow-lg border border-red-100 p-6 md:p-10 print-area">

            <!-- Informasi Toko (Hanya Muncul di Halaman Pertama Cetak) -->
            <div class="pb-4 border-b border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800">Laporan Penjual SiToko</h2>
                <!-- Tanggal Real-time -->
                <p class="text-sm text-gray-500">SiToko | Tanggal: <span id="currentDate"></span></p>
            </div>
            
            <!-- LAPORAN 1: STOK MENURUN -->
            <section>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Laporan 1: Daftar Stok Produk (Urutan Menurun)</h3>
                <p class="text-sm text-gray-600 mb-4">Menampilkan semua produk diurutkan berdasarkan jumlah stok terbesar.</p>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="table-header-light">
                        <tr class="bg-red-50/50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">No.</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama Produk</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Kategori</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase">Rating</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 uppercase">Harga</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="report1">
                        <!-- Data akan diisi oleh JS -->
                    </tbody>
                </table>
            </section>
            
            <!-- Pemisah Halaman untuk Cetak -->
            <div class="page-break no-print"></div>

            <!-- LAPORAN 2: RATING MENURUN -->
            <section>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Laporan 2: Daftar Stok Produk (Urutan Rating Terbaik)</h3>
                <p class="text-sm text-gray-600 mb-4">Menampilkan semua produk diurutkan berdasarkan skor rating tertinggi.</p>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="table-header-light">
                        <tr class="bg-red-50/50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">No.</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama Produk</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Kategori</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase">Rating</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 uppercase">Harga</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="report2">
                        <!-- Data akan diisi oleh JS -->
                    </tbody>
                </table>
            </section>

            <!-- Pemisah Halaman untuk Cetak -->
            <div class="page-break no-print"></div>

            <!-- LAPORAN 3: STOK KRITIS -->
            <section class="print-area">
                <h3 class="text-xl font-semibold text-red-600 mb-4">Laporan 3: Stok Kritis (Perlu Pemesanan Ulang)</h3>
                <p class="text-sm text-red-600 mb-4 font-medium">Daftar produk dengan stok di bawah batas minimum (Stok kurang dari 2). Produk-produk ini harus segera dipesan!</p>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="table-header-critical">
                        <tr class="color-reorder-header">
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">No.</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">Nama Produk</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">Kategori</th>
                            <th class="px-4 py-2 text-center text-xs font-medium uppercase">Rating</th>
                            <th class="px-4 py-2 text-right text-xs font-medium uppercase">Harga</th>
                            <th class="px-4 py-2 text-center text-xs font-medium uppercase">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="report3">
                        <!-- Data akan diisi oleh JS -->
                    </tbody>
                </table>
            </section>
        </div>

    </main>

    <script>
        // Data Produk Fiktif
        const rawProductData = [
            { id: 1, name: 'Buku Saku Kuliah Premium', category: 'Alat Tulis', price: 85000, stock: 150, rating: 5.0 },
            { id: 2, name: 'Powerbank 10000mAh', category: 'Elektronik', price: 250000, stock: 40, rating: 4.5 },
            { id: 3, name: 'Headset Gaming Super Bass', category: 'Elektronik', price: 150000, stock: 5, rating: 3.8 },
            { id: 4, name: 'Kaos Kampus Edisi 2024', category: 'Pakaian', price: 120000, stock: 1400, rating: 4.9 },
            { id: 5, name: 'Gantungan Kunci Logo Kampus', category: 'Aksesoris', price: 15000, stock: 1, rating: 4.2 }, // Kritis
            { id: 6, name: 'Mi Instan Rasa Kari Ayam', category: 'Makanan', price: 3500, stock: 0, rating: 4.7 } // Kritis
        ];

        // Helper untuk format Rupiah
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        };

        // Fungsi untuk me-render satu baris laporan
        const renderRow = (product, index, isCritical = false) => {
            const rowClass = isCritical ? 'table-critical-row bg-red-50/50' : 'hover:bg-gray-50';
            
            return `
                <tr class="${rowClass}">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-left">${index + 1}</td>
                    <td class="px-4 py-2 text-sm font-medium text-gray-900">${product.name}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">${product.category}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-red-500 text-center">${product.rating.toFixed(1)}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">${formatRupiah(product.price)}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-center ${product.stock < 2 ? 'text-red-600' : 'text-gray-700'}">${product.stock.toLocaleString('id-ID')}</td>
                </tr>
            `;
        };

        // Fungsi utama untuk menjalankan laporan
        const generateReports = () => {
            
            // --- Laporan 1: Stok Menurun ---
            const report1Data = [...rawProductData].sort((a, b) => b.stock - a.stock);
            const report1Html = report1Data.map(renderRow).join('');
            document.getElementById('report1').innerHTML = report1Html;

            // --- Laporan 2: Rating Menurun ---
            const report2Data = [...rawProductData].sort((a, b) => b.rating - a.rating);
            const report2Html = report2Data.map(renderRow).join('');
            document.getElementById('report2').innerHTML = report2Html;
            
            // --- Laporan 3: Stok Kritis (< 2) ---
            const report3Data = rawProductData.filter(p => p.stock < 2);
            const report3Html = report3Data.map((p, i) => renderRow(p, i, true)).join('');
            document.getElementById('report3').innerHTML = report3Html;

            // Set tanggal real-time
            document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
                day: 'numeric', month: 'long', year: 'numeric'
            });
        };

        // Panggil fungsi saat dokumen dimuat
        document.addEventListener('DOMContentLoaded', generateReports);
    </script>
</body>
</html>