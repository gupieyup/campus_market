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
                <p class="text-sm text-gray-500">SiToko | Tanggal: {{ isset($generatedAt) ? $generatedAt->format('d F Y') : now()->format('d F Y') }}</p>
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
                    <tbody class="bg-white divide-y divide-gray-100">
                        @if(!empty($noSeller) && $noSeller)
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-yellow-700">Anda belum terdaftar sebagai penjual. Tidak ada data untuk dicetak.</td>
                            </tr>
                        @else
                            @foreach($stockSorted as $i => $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-left">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $p['name'] }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $p['category'] }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-red-500 text-center">{{ number_format($p['rating'],1) }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($p['price'],0,',','.') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-center {{ $p['stock'] < 2 ? 'text-red-600' : 'text-gray-700' }}">{{ number_format($p['stock'],0,',','.') }}</td>
                                </tr>
                            @endforeach
                        @endif
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
                    <tbody class="bg-white divide-y divide-gray-100">
                        @if(!empty($noSeller) && $noSeller)
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-yellow-700">Anda belum terdaftar sebagai penjual. Tidak ada data untuk dicetak.</td>
                            </tr>
                        @else
                            @foreach($ratingSorted as $i => $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-left">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $p['name'] }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $p['category'] }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-red-500 text-center">{{ number_format($p['rating'],1) }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($p['price'],0,',','.') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-center {{ $p['stock'] < 2 ? 'text-red-600' : 'text-gray-700' }}">{{ number_format($p['stock'],0,',','.') }}</td>
                                </tr>
                            @endforeach
                        @endif
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
                    <tbody class="bg-white divide-y divide-gray-100">
                        @if(!empty($noSeller) && $noSeller)
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-yellow-700">Anda belum terdaftar sebagai penjual. Tidak ada data untuk dicetak.</td>
                            </tr>
                        @else
                            @foreach($critical as $i => $p)
                                <tr class="table-critical-row bg-red-50/50">
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-left">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $p['name'] }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $p['category'] }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-red-500 text-center">{{ number_format($p['rating'],1) }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($p['price'],0,',','.') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-center text-red-600">{{ number_format($p['stock'],0,',','.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</body>
</html>