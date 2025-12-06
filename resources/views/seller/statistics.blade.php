
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Statistik Penjual</title>
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
        
        /* Utility untuk warna garis pada chart, menyamakan dengan gaya referensi (hijau-merah) */
        .chart-green { border-color: #10B981; /* Emerald 500 */ }
        .chart-red { border-color: #EF4444; /* Red 500 */ }
        .chart-green-bg { background-color: #D1FAE5; /* Emerald 100 */ }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">
<div class="flex h-screen overflow-hidden">
    @include('seller.layouts.sidebar', ['activeMenu' => 'statistik'])
    <!-- Main Content (Dashboard Statistik) -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
        <!-- Header Animasi (meniru header referensi) -->
        <div class="mb-8 bg-green-50 rounded-2xl p-6 md:p-10 shadow-lg overflow-hidden relative">
            <div class="absolute inset-0 z-0 opacity-20">
                <!-- Placeholder Sederhana untuk Ilustrasi Kampus/Toko -->
                <div class="h-full w-full bg-cover bg-center" style="background-image: url('https://placehold.co/1200x200/F0FDF4/6EE7B7?text=Selamat+Datang+di+SiToko');"></div>
            </div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <!-- Mengganti font-bold menjadi font-semibold -->
                        <h2 class="text-2xl font-semibold text-green-700">Dashboard Statistik SiToko</h2>
                        <p class="text-green-600 text-sm mt-1">Pantau performa toko Anda secara real-time.</p>
                    </div>
                    <!-- Placeholder Profil Toko -->
                    <div class="h-10 w-10 bg-red-500 rounded-full flex items-center justify-center text-white font-medium text-lg">TS</div>
                </div>
            </div>

            <!-- Konten Utama Dashboard (Grid 3 Kolom) -->
            @if(!empty($noSeller) && $noSeller)
                <div class="mb-6 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h3 class="text-lg font-semibold text-yellow-800">Anda belum terdaftar sebagai penjual</h3>
                    <p class="text-sm text-yellow-700 mt-2">Halaman statistik memerlukan data toko. Jika Anda sudah menambahkan data penjual di database, silakan login kembali. Jika belum, bagian statistik akan disembunyikan.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <!-- KOLOM 1: METRIK KUNCI PENJUALAN (4 Box Vertikal) -->
                @unless(!empty($noSeller) && $noSeller)
                <div class="space-y-6">
                    <!-- Pesanan Baru -->
                    <div class="bg-white p-6 rounded-2xl shadow-md border border-red-100">
                        <!-- Mengganti font-semibold menjadi font-medium -->
                        <h3 class="text-sm font-medium text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Pesanan Baru
                        </h3>
                        <!-- Mengganti font-extrabold menjadi font-semibold -->
                        <div class="text-4xl font-semibold text-gray-800 mt-2">{{ $newOrders ?? 0 }}</div>
                        <div class="flex items-center mt-1">
                            <span id="metric1_change" class="text-xs font-medium text-red-500 bg-red-100 px-2 py-0.5 rounded-full">-3.71%</span>
                            <span class="text-xs text-gray-500 ml-2">dari 7 Hari lalu</span>
                        </div>
                    </div>

                    <!-- Produk Dilihat -->
                    <div class="bg-white p-6 rounded-2xl shadow-md border border-red-100">
                        <!-- Mengganti font-semibold menjadi font-medium -->
                        <h3 class="text-sm font-medium text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Produk Dilihat
                        </h3>
                        <!-- Mengganti font-extrabold menjadi font-semibold -->
                        <div class="text-4xl font-semibold text-gray-800 mt-2">0</div>
                        <div class="flex items-center mt-1">
                            <span id="metric2_change" class="text-xs font-medium text-red-500 bg-red-100 px-2 py-0.5 rounded-full">-33.17%</span>
                            <span class="text-xs text-gray-500 ml-2">dari 7 Hari lalu</span>
                        </div>
                    </div>

                    <!-- Produk Terjual -->
                    <div class="bg-white p-6 rounded-2xl shadow-md border border-red-100">
                        <!-- Mengganti font-semibold menjadi font-medium -->
                        <h3 class="text-sm font-medium text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Produk Terjual
                        </h3>
                        <!-- Mengganti font-extrabold menjadi font-semibold -->
                        <div class="text-4xl font-semibold text-gray-800 mt-2">{{ $productsSold ?? 0 }}</div>
                        <div class="flex items-center mt-1">
                            <span id="metric3_change" class="text-xs font-medium text-red-500 bg-red-100 px-2 py-0.5 rounded-full">-30.78%</span>
                            <span class="text-xs text-gray-500 ml-2">dari 7 Hari lalu</span>
                        </div>
                    </div>

                    <!-- Pendapatan Bersih -->
                    <div class="bg-white p-6 rounded-2xl shadow-md border border-red-100">
                        <!-- Mengganti font-semibold menjadi font-medium -->
                        <h3 class="text-sm font-medium text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V9m0 3v2m0 3v1m-6-1V7a4 4 0 014-4h4a4 4 0 014 4v10a4 4 0 01-4 4h-4a4 4 0 01-4-4z"></path></svg>
                            Pendapatan Bersih
                        </h3>
                        <!-- Mengganti font-extrabold menjadi font-semibold -->
                        <div class="text-4xl font-semibold text-red-500 mt-2">Rp{{ number_format($netRevenue ?? 0, 0, ',', '.') }}</div>
                        <div class="flex items-center mt-1">
                            <span id="metric4_change" class="text-xs font-medium text-red-500 bg-red-100 px-2 py-0.5 rounded-full">-37.79%</span>
                            <span class="text-xs text-gray-500 ml-2">dari 7 Hari lalu</span>
                        </div>
                    </div>
                </div>
                @endunless
                
                <!-- KOLOM 2: GRAFIK TREN PENDAPATAN BERSIH -->
                @unless(!empty($noSeller) && $noSeller)
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-md border border-red-100">
                    <div class="flex justify-between items-start mb-4">
                        <!-- Mengganti font-bold menjadi font-semibold -->
                        <h3 class="text-xl font-semibold text-gray-800">Tren Pendapatan Bersih</h3>
                        <div class="flex items-center text-sm text-gray-500">
                            Periode:
                            <span class="ml-2 font-medium text-red-500">
                                7 Hari lalu
                                <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </div>
                    </div>

                    <!-- Ringkasan Pendapatan di atas Grafik -->
                    <div class="mb-6 border-b pb-4 border-red-50">
                        <p class="text-sm text-gray-500 font-medium flex items-center">
                            Pendapatan Bersih Hari Ini (Live, {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }})
                        </p>
                        <div class="text-4xl font-semibold text-red-600 mt-1">Rp{{ number_format($todayRevenue ?? 0, 0, ',', '.') }}</div>
                        <p class="text-sm text-gray-400 mt-2">Pendapatan Bersih 7 Hari lalu: Rp{{ number_format($prevWeekTotal ?? 0, 0, ',', '.') }}</p>
                    </div>

                    <div class="relative h-96 w-full">
                        <canvas id="revenueTrendChart"></canvas>
                    </div>
                    
                </div>
                @endunless
                
                <!-- KOLOM 3: PERINGKAT PRODUK TERJUAL (Bergeser ke Kanan pada Tampilan Lebar) -->
                @unless(!empty($noSeller) && $noSeller)
                <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-md border border-red-100">
                    <!-- Mengganti font-bold menjadi font-semibold -->
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center mb-4">
                        <svg class="w-6 h-6 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.007 12.007 0 002.944 12c.045 4.095 2.227 7.765 5.618 9.044l.872.378a1 1 0 00.932 0l.872-.378c3.391-1.279 5.573-4.949 5.618-9.044a12.007 12.007 0 00-.574-5.96z"></path></svg>
                        Ranking Produk
                    </h3>
                    
                    <div id="productRankingList" class="space-y-4">
                        <!-- Data Produk akan di-generate oleh JS -->
                    </div>

                    <!-- Mengganti font-semibold menjadi font-medium -->
                    <button class="w-full mt-6 py-3 text-red-500 font-medium border border-red-200 rounded-xl hover:bg-red-50 transition-colors">
                        Lihat Semua Ranking
                    </button>
                </div>
                @endunless

            </div>

        </main>
    </div>

    <script>
        // Data diisi dari server (blade -> json)
        const statsData = {
            productRankings: @json($productRankings ?? []),
            revenueTrend: {
                labels: @json($labels ?? []),
                currentPeriod: @json($data ?? []),
                previousPeriod: @json($prevData ?? [])
            }
        };

        // Fungsi untuk format mata uang Rupiah
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        };
        
        // --- 1. Generate Ranking Produk ---
        const rankingList = document.getElementById('productRankingList');
        statsData.productRankings.forEach((product, index) => {
            const listItem = `
                <div class="flex items-center p-3 hover:bg-red-50 rounded-xl transition-colors cursor-pointer">
                    <!-- Mengganti font-bold menjadi font-medium -->
                    <span class="text-lg font-medium w-6 text-center text-red-500 mr-4">${index + 1}</span>
                    <div class="w-10 h-10 ${product.color} rounded-lg flex items-center justify-center font-semibold text-xs mr-4">${product.image.match(/text=(.*)/)[1]}</div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-800 truncate">${product.name}</h4>
                        <p class="text-xs text-gray-500">${product.sold} Terjual</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 ml-4 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            `;
            rankingList.innerHTML += listItem;
        });

        // --- 2. Inisialisasi Grafik Tren Pendapatan Bersih ---
        const ctxRevenue = document.getElementById('revenueTrendChart').getContext('2d');
        
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: statsData.revenueTrend.labels,
                datasets: [
                    {
                        label: 'Periode Ini (Live)',
                        data: statsData.revenueTrend.currentPeriod,
                        borderColor: '#10B981', // Hijau (Emerald 500)
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: false,
                        pointRadius: 0,
                        pointHitRadius: 10,
                    },
                    {
                        label: 'Periode Sebelumnya (7 Hari lalu)',
                        data: statsData.revenueTrend.previousPeriod,
                        borderColor: '#F87171', // Merah Muda (Red 400)
                        backgroundColor: 'rgba(248, 113, 113, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: false,
                        pointRadius: 0,
                        pointHitRadius: 10,
                        borderDash: [5, 5] // Garis putus-putus
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                label += formatRupiah(context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            callback: function(value, index, values) {
                                // Format sumbu Y sebagai Rupiah (disederhanakan)
                                if (value >= 1000000) return 'Rp' + (value / 1000000).toFixed(1) + ' Jt';
                                if (value >= 1000) return 'Rp' + (value / 1000) + ' Rb';
                                return 'Rp' + value;
                            },
                            maxRotation: 0,
                            minRotation: 0
                        },
                        // Mengganti weight: '600' (semibold) menjadi '500' (medium)
                        title: { display: true, text: 'Pendapatan Bersih', font: { size: 12, weight: '500' } }
                    },
                    x: {
                        grid: { display: false },
                        // Mengganti weight: '600' (semibold) menjadi '500' (medium)
                        title: { display: true, text: 'Jam (WIB)', font: { size: 12, weight: '500' } }
                    }
                }
            }
        });
    </script>
</body>
</html>