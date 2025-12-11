<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-gray-500 text-sm mt-1">Ringkasan aktivitas toko dan performa hari ini.</p>
            </div>
            <!-- Status Akun dan Tombol Toggle -->
            <div class="flex items-center gap-4">
                @if(!empty($seller))
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold {{ $seller->is_active ? 'text-green-600' : 'text-red-600' }}">
                            Status: {{ $seller->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                        </span>
                        <button id="toggleAccountBtn" class="px-4 py-2 rounded-lg font-semibold text-white transition-colors {{ $seller->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}" data-status="{{ $seller->is_active ? 'true' : 'false' }}">
                            {{ $seller->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                        </button>
                    </div>
                @endif
                <!-- Placeholder Profil Toko -->
                <div class="h-10 w-10 bg-red-200 rounded-full flex items-center justify-center text-red-500 font-bold text-lg">TS</div>
            </div>
        </div>
        <!-- Kartu Metrik Kunci Penjual -->
        @if(!empty($noSeller) && $noSeller)
            <div class="mb-6 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h3 class="text-lg font-semibold text-yellow-800">Anda belum terdaftar sebagai penjual</h3>
                <p class="text-sm text-yellow-700 mt-2">Dashboard memerlukan data toko untuk menampilkan metrik. Jika sudah menambahkan data penjual di database, silakan login kembali.</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                
                <!-- Total Produk Aktif -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50 hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-semibold text-gray-600">Total Produk Aktif</h3>
                        <div class="flex items-end justify-between mt-4">
                            <span class="text-3xl font-bold text-gray-800">{{ $totalProducts ?? 0 }}</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Stok keseluruhan: {{ number_format($totalStock ?? 0) }} unit</p>
                </div>

                <!-- Total Penjualan (Transaksi) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50 hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-semibold text-gray-600">Total Penjualan</h3>
                    <div class="flex items-end justify-between mt-4">
                        <span class="text-3xl font-bold text-gray-800">{{ $totalSales ?? 0 }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Transaksi sukses (total)</p>
                </div>

                <!-- Rata-Rata Rating Toko -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-50 hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-semibold text-gray-600">Rata-Rata Rating Toko</h3>
                    <div class="flex items-end justify-between mt-4">
                        <span class="text-3xl font-bold text-red-500">{{ $avgRating ?? 0 }}</span>
                        <span class="text-xs font-medium text-red-500 bg-red-100 px-2 py-1 rounded-lg">{{ $ratingCount ?? 0 }} ulasan</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Rata-rata rating produk Anda</p>
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
                        <span class="text-3xl font-bold text-red-500 mr-2">{{ $avgRating ?? 0 }}</span>
                        <span class="text-sm text-gray-500">dari {{ number_format($ratingCount ?? 0) }} ulasan (Produk: {{ $topProductName ?? '—' }})</span>
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
                    @php
                        $provTotal = array_sum(array_column($provinceDistribution ?? [], 'count')) ?: 0;
                    @endphp

                    @if(empty($provinceDistribution) || $provTotal === 0)
                        <div class="col-span-1 p-4 text-center text-gray-500">Belum ada data distribusi provinsi.</div>
                    @else
                        @foreach($provinceDistribution as $pd)
                            @php
                                $provName = $pd['province'] ?: '-';
                                // Abbreviation: take first letter of each word
                                $parts = preg_split('/\s+/', $provName);
                                $abbr = '';
                                foreach ($parts as $w) { $abbr .= strtoupper(substr($w,0,1)); }
                                $count = $pd['count'];
                                $pct = $provTotal ? round($count * 100 / $provTotal) : 0;
                            @endphp
                            <div class="flex items-center p-4 border border-gray-100 rounded-xl hover:bg-red-50 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold mr-4 text-xs">{{ $abbr }}</div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-gray-800">{{ $provName }}</h4>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                        <div class="bg-red-400 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                                <span class="ml-4 font-bold text-gray-700">{{ $pct }}% Review</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </main>
    </div>

    <script>
        @php
            // Ensure variables are defined without using inline array literals inside @json()
            $topStockProducts = $topStockProducts ?? [];
            $ratingDistribution = $ratingDistribution ?? [0,0,0,0,0];
        @endphp

        // Data Produk dari server (top stock products)
        const productData = @json($topStockProducts);

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
        (function(){
            const canvas = document.getElementById('ratingDistributionChart');
            if (!canvas) return;
            const ratingDistribution = @json($ratingDistribution);
            const totalRatings = ratingDistribution.reduce((s, v) => s + (v || 0), 0);
            if (!totalRatings) {
                // replace canvas container with a friendly placeholder
                const parent = canvas.parentElement;
                parent.innerHTML = '<div class="p-6 text-center text-gray-500">Belum ada ulasan untuk produk terlaris.</div>';
                return;
            }

            const ctxRating = canvas.getContext('2d');
            const ratingLabels = ['5 Bintang', '4 Bintang', '3 Bintang', '2 Bintang', '1 Bintang'];
            const ratingColors = ['#4ADE80', '#A7F3D0', '#FCD34D', '#F97316', '#EF4444']; // Green to Red

            const datasets = ratingLabels.map((label, index) => ({
                label: label,
                data: [ratingDistribution[index] || 0],
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
        })();
    </script>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium hidden transition-opacity duration-300"></div>

    <script>
        // Toggle Account Status
        document.getElementById('toggleAccountBtn')?.addEventListener('click', async function() {
            const btn = this;
            const wasActive = btn.dataset.status === 'true';
            
            try {
                const response = await fetch('{{ route("seller.toggle-account") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                });

                const data = await response.json();

                if (data.success) {
                    // Update button and status text
                    const newStatus = data.is_active;
                    btn.dataset.status = newStatus ? 'true' : 'false';
                    btn.textContent = newStatus ? 'Nonaktifkan Akun' : 'Aktifkan Akun';
                    btn.className = `px-4 py-2 rounded-lg font-semibold text-white transition-colors ${
                        newStatus ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600'
                    }`;

                    // Update status text
                    const statusSpan = btn.parentElement.querySelector('span');
                    if (statusSpan) {
                        statusSpan.className = `text-sm font-semibold ${newStatus ? 'text-green-600' : 'text-red-600'}`;
                        statusSpan.textContent = `Status: ${newStatus ? '✓ Aktif' : '✗ Nonaktif'}`;
                    }

                    showToast(data.message, 'bg-green-500');
                } else {
                    showToast(data.message || 'Gagal mengubah status akun', 'bg-red-500');
                }
            } catch (error) {
                console.error('Error toggling account:', error);
                showToast('Terjadi kesalahan saat mengubah status akun', 'bg-red-500');
            }
        });

        function showToast(message, bgColor = 'bg-green-500') {
            const toast = document.getElementById('toast');
            if (!toast) return;
            
            toast.textContent = message;
            toast.className = `${bgColor} fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-opacity duration-300`;
            
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => {
                    toast.classList.remove('opacity-0');
                }, 300);
            }, 1500);
        }
    </script>
</html>