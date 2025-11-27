<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        /* Custom scrollbar for better aesthetics */
        main::-webkit-scrollbar { width: 8px; }
        main::-webkit-scrollbar-thumb { background-color: #fca5a5; border-radius: 4px; }
        main::-webkit-scrollbar-track { background-color: #fef2f2; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">
<div class="flex h-screen overflow-hidden">
    @include('seller.layouts.sidebar', ['activeMenu' => 'dashboard'])
    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
        <!-- Header dan Ringkasan Toko -->
        <div class="mb-8 bg-white rounded-2xl p-6 shadow-sm border border-red-100 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, Penjual! 👋</h2>
                <p class="text-gray-500 text-sm mt-1">Ringkasan aktivitas toko dan performa hari ini.</p>
            </div>
            <!-- Placeholder Profil Toko -->
            <div class="h-10 w-10 bg-red-200 rounded-full flex items-center justify-center text-red-500 font-bold text-lg">TS</div>
        </div>
        <!-- Kartu Metrik Kunci Penjual -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Total Produk Aktif -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50 hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-semibold text-gray-600">Total Produk Aktif</h3>
                    <div class="flex items-end justify-between mt-4">
                        <span class="text-3xl font-bold text-gray-800">125</span>
                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-lg">↑ 5 Produk</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Stok keseluruhan: 4,890 unit</p>
                </div>

                <!-- Total Penjualan (Transaksi) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50 hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-semibold text-gray-600">Total Penjualan</h3>
                    <div class="flex items-end justify-between mt-4">
                        <span class="text-3xl font-bold text-gray-800">56</span>
                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-lg">↑ 15%</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Transaksi sukses minggu ini</p>
                </div>

                <!-- Rata-Rata Rating Toko -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50 hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-semibold text-gray-600">Rata-Rata Rating Toko</h3>
                    <div class="flex items-end justify-between mt-4">
                        <span class="text-3xl font-bold text-red-500">4.9</span>
                        <span class="text-xs font-medium text-red-500 bg-red-100 px-2 py-1 rounded-lg">⭐⭐⭐⭐⭐</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Dari 89 ulasan baru hari ini</p>
                </div>

                <!-- Pesanan Baru (Hari Ini) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50 hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-semibold text-gray-600">Pesanan Baru</h3>
                    <div class="flex items-end justify-between mt-4">
                        <span class="text-3xl font-bold text-gray-800">14</span>
                        <span class="text-xs font-medium text-red-600 bg-red-100 px-2 py-1 rounded-lg">Perlu Diproses</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Siap kirim: 8 pesanan</p>
                </div>
            </div>

            <!-- Bagian PENTING: Upload Produk -->
            <div class="mb-8 bg-red-100 p-6 rounded-2xl shadow-lg border border-red-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-red-800 mb-2">Pasang Produk Pertamamu! 🚀</h3>
                        <p class="text-red-700 text-sm">Jual barang-barang di sekitar kampusmu sekarang. Isi semua elemen data berikut untuk produk yang optimal (mirip standar Tokopedia).</p>
                        <ul class="text-xs text-red-600 mt-2 list-disc list-inside space-y-1">
                            <li>Nama Produk (Maks 70 Karakter) & Kategori (Otomatis/Manual)</li>
                            <li>Foto Produk (Min. 3 Foto Jelas) & Deskripsi Lengkap</li>
                            <li>Harga Jual, Berat Produk, dan **Stok** (Penting untuk Dashboard ini)</li>
                        </ul>
                    </div>
                        <a href="{{ route('seller.tambahproduk') }}" class="flex items-center px-6 py-3 bg-red-500 text-white font-bold rounded-xl shadow-md hover:bg-red-600 transition-colors">
                            <!-- Upload Icon -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Upload Produk
                        </a>
                </div>
            </div>

            <!-- Bagian Grafik: Stok dan Rating -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                
                <!-- GRAFIK 1: Sebaran Jumlah Stok Per Produk (Bar Chart Horizontal) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Sebaran Jumlah Stok Per Produk (Top 5)</h3>
                    <p class="text-sm text-gray-500 mb-4">Waspada: Produk dengan stok di bawah 10 unit ditandai merah.</p>
                    <div class="relative h-72 w-full">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>

                <!-- GRAFIK 2: Sebaran Nilai Rating Per Produk (Stacked Bar for Top Product) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Rating Produk Terlaris</h3>
                    <div class="flex items-center mb-6">
                        <span class="text-3xl font-bold text-red-500 mr-2">4.7</span>
                        <span class="text-sm text-gray-500">dari 1.2k ulasan (Produk: Buku Saku Kuliah)</span>
                    </div>
                    <div class="relative h-64 w-full flex justify-center">
                        <canvas id="ratingDistributionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- GRAFIK 3: Sebaran Pemberi Rating Berdasarkan Lokasi (Provinsi) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Sebaran Pemberi Rating per Provinsi</h3>
                    <button class="text-sm text-red-500 font-semibold hover:text-red-600">Lihat Peta</button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Contoh Provinsi: Data dari mana rating terbanyak berasal -->
                    <div class="flex items-center p-4 border border-gray-100 rounded-xl hover:bg-red-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold mr-4 text-xs">JBR</div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-800">Jawa Barat</h4>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                <div class="bg-red-400 h-1.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <span class="ml-4 font-bold text-gray-700">85% Review</span>
                    </div>

                    <div class="flex items-center p-4 border border-gray-100 rounded-xl hover:bg-red-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 font-bold mr-4 text-xs">JKT</div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-800">DKI Jakarta</h4>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                <div class="bg-red-400 h-1.5 rounded-full" style="width: 55%"></div>
                            </div>
                        </div>
                        <span class="ml-4 font-bold text-gray-700">55% Review</span>
                    </div>

                    <div class="flex items-center p-4 border border-gray-100 rounded-xl hover:bg-red-50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-500 font-bold mr-4 text-xs">JTG</div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-800">Jawa Tengah</h4>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                <div class="bg-red-400 h-1.5 rounded-full" style="width: 40%"></div>
                            </div>
                        </div>
                        <span class="ml-4 font-bold text-gray-700">40% Review</span>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        // Data Produk Fiktif
        const productData = [
            { name: 'Buku Saku Kuliah', stock: 150, ratings: [1050, 80, 50, 10, 5] },
            { name: 'Powerbank 10000mAh', stock: 12, ratings: [150, 10, 5, 2, 1] },
            { name: 'Kaos Kampus Edisi 2024', stock: 5, ratings: [450, 20, 10, 5, 2] },
            { name: 'Modul Praktikum Fisika', stock: 210, ratings: [90, 5, 2, 1, 0] },
            { name: 'Headset Gaming Murah', stock: 9, ratings: [70, 15, 8, 4, 3] },
        ];

        // 1. Chart Sebaran Jumlah Stok Per Produk (Bar Chart Horizontal)
        const ctxStock = document.getElementById('stockChart').getContext('2d');
        
        // Sorting data: Stok terendah di atas (lebih mudah dilihat sebagai prioritas)
        const sortedProducts = [...productData].sort((a, b) => a.stock - b.stock);

        new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: sortedProducts.map(p => p.name),
                datasets: [{
                    label: 'Stok Saat Ini (Unit)',
                    data: sortedProducts.map(p => p.stock),
                    backgroundColor: sortedProducts.map(p => p.stock < 10 ? '#F87171' : '#FCA5A5'), // Red-400 for low stock
                    hoverBackgroundColor: '#EF4444', 
                    borderRadius: 6,
                }]
            },
            options: {
                indexAxis: 'y', // Membuat Horizontal Bar Chart
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                label += new Intl.NumberFormat('id-ID').format(context.parsed.x);
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f3f4f6' },
                        title: { display: true, text: 'Jumlah Stok (Unit)', font: { size: 12, weight: '600' } }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });

        // 2. Chart Sebaran Nilai Rating Per Produk (Stacked Horizontal Bar for Top Product)
        const ctxRating = document.getElementById('ratingDistributionChart').getContext('2d');
        const topProduct = productData[0]; // Ambil produk pertama sebagai contoh
        
        // Label rating: 5 Bintang, 4 Bintang, dst.
        const ratingLabels = ['5 Bintang', '4 Bintang', '3 Bintang', '2 Bintang', '1 Bintang'];
        const ratingColors = ['#4ADE80', '#A7F3D0', '#FCD34D', '#F97316', '#EF4444']; // Green to Red

        // Ubah format data menjadi format stacked bar chart
        const datasets = ratingLabels.map((label, index) => ({
            label: label,
            data: [topProduct.ratings[index]], // Setiap rating memiliki 1 data point
            backgroundColor: ratingColors[index],
            barThickness: 30,
        }));

        new Chart(ctxRating, {
            type: 'bar',
            data: {
                labels: ['Rating Distribusi'],
                datasets: datasets,
            },
            options: {
                indexAxis: 'y', // Horizontal Bar
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                label += new Intl.NumberFormat('id-ID').format(context.parsed.x) + ' Ulasan';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true, // Stacked bar
                        beginAtZero: true,
                        display: false // Hide X-axis numbers
                    },
                    y: {
                        stacked: true, // Stacked bar
                        grid: { display: false },
                        display: false // Hide Y-axis labels
                    }
                }
            }
        });
    </script>
</body>
</html>