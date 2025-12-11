<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SiToko - Laporan Admin</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
		body { font-family: 'Inter', sans-serif; }

		main::-webkit-scrollbar { width: 8px; }
		main::-webkit-scrollbar-thumb { background-color: #fca5a5; border-radius: 4px; }
		main::-webkit-scrollbar-track { background-color: #fef2f2; }

		.color-primary { background-color: #EF4444; }
		.color-light { background-color: #FEE2E2; }
		.color-critical { background-color: #FCA5A5; }
		.color-reorder-header { background-color: #EF4444; color: white; }

		@media print {
			body { background-color: #fff; margin: 0; }
			.no-print { display: none; }
			.print-area { margin: 0; padding: 0; width: 100%; box-shadow: none; border: none; }
			.page-break { page-break-before: always; }
			/* Remove screen constraints that cut content */
			.h-screen { height: auto !important; }
			.overflow-hidden, .overflow-x-hidden, .overflow-y-auto { overflow: visible !important; }
			.flex { display: block !important; }
			.max-w-4xl, .max-w-5xl { max-width: none !important; width: 100% !important; }
			main { padding: 0 !important; background: #fff !important; }
			.shadow-lg, .rounded-2xl, .border { box-shadow: none !important; border: none !important; }
            
			/* Ensure tables print fully without cutting rows */
			table { page-break-inside: auto; }
			thead { display: table-header-group; }
			tfoot { display: table-footer-group; }
			tr { page-break-inside: avoid; page-break-after: auto; }
			td, th { page-break-inside: avoid; }
			/* Slightly tighten padding for print to fit more rows */
			.px-4 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
			.py-2 { padding-top: 0.4rem !important; padding-bottom: 0.4rem !important; }
			/* Reduce font sizes for print to fit more data */
			body, table { font-size: 12px !important; }
			h1 { font-size: 18px !important; }
			h2 { font-size: 16px !important; }
			h3 { font-size: 14px !important; }
			.table-header-light th { background-color: #fef2f2 !important; -webkit-print-color-adjust: exact; }
			.table-header-critical th { background-color: #EF4444 !important; color: white !important; -webkit-print-color-adjust: exact; }
			.table-critical-row td { background-color: #FEE2E2 !important; -webkit-print-color-adjust: exact; }
			h1, h2, h3, p { color: #000 !important; }
		}
	</style>
@php
	$generatedAt = $generatedAt ?? now();
	$processedBy = $processedBy ?? (auth()->user()->name ?? 'Admin');
@endphp
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">
<div class="flex h-screen overflow-hidden">
	<div class="no-print">
		@include('admin._sidebar', ['active' => 'reports'])
	</div>
	<main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">

		<div class="flex justify-between items-center mb-6 no-print">
			<h1 class="text-3xl font-semibold text-gray-800">Cetak Laporan Admin</h1>
			<button onclick="window.print()" class="flex items-center px-6 py-2 color-primary text-white font-medium rounded-xl shadow-md hover:bg-red-600 transition-colors">
				<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m0 0v-4a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6"></path></svg>
				Cetak ke PDF
			</button>
		</div>

		<div class="max-w-5xl mx-auto space-y-12 bg-white rounded-2xl shadow-lg border border-red-100 p-6 md:p-10 print-area">
			<div class="pb-4 border-b border-gray-100">
				<h2 class="text-2xl font-bold text-gray-800">Laporan Platform SiToko</h2>
				<p class="text-sm text-gray-500">Tanggal dibuat: {{ $generatedAt->format('d-m-Y') }} oleh {{ $processedBy }}</p>
			</div>

			<!-- SRS-MartPlace-09 -->
			<section>
				<h3 class="text-xl font-semibold text-gray-800 mb-4">(SRS-MartPlace-09) Daftar Akun Penjual Berdasarkan Status</h3>
				<p class="text-sm text-gray-600 mb-4">Diurutkan: Aktif terlebih dahulu lalu Tidak Aktif.</p>
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="table-header-light">
						<tr class="bg-red-50/50">
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">No.</th>
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama User</th>
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama PIC</th>
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama Toko</th>
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-100">
						@php
							$sellerRows = collect($sellersByStatus ?? [])
								->sortByDesc(fn($s) => strtolower($s['status'] ?? '') === 'aktif')
								->values();
						@endphp
						@forelse($sellerRows as $i => $s)
							<tr class="hover:bg-gray-50">
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $i + 1 }}</td>
								<td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $s['user_name'] ?? '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $s['pic_name'] ?? '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $s['store_name'] ?? '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm font-medium {{ (strtolower($s['status'] ?? '') === 'aktif') ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($s['status'] ?? '-') }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="px-6 py-8 text-center text-yellow-700">Tidak ada data penjual.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</section>

			<div class="page-break no-print"></div>

			<!-- SRS-MartPlace-10 -->
			<section>
				<h3 class="text-xl font-semibold text-gray-800 mb-4">(SRS-MartPlace-10) Daftar Toko Berdasarkan Propinsi</h3>
				<p class="text-sm text-gray-600 mb-4">Diurutkan berdasarkan nama propinsi.</p>
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="table-header-light">
						<tr class="bg-red-50/50">
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">No.</th>
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama Toko</th>
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Nama PIC</th>
							<th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Propinsi</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-100">
						@php
							$storeRows = collect($storesByProvince ?? [])
								->sortBy(fn($r) => $r['province'] ?? '')
								->values();
						@endphp
						@forelse($storeRows as $i => $r)
							<tr class="hover:bg-gray-50">
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $i + 1 }}</td>
								<td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $r['store_name'] ?? '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $r['pic_name'] ?? '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $r['province'] ?? '-' }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="px-6 py-8 text-center text-yellow-700">Tidak ada data toko.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</section>

			<div class="page-break no-print"></div>

			<!-- SRS-MartPlace-11 -->
			<section class="page-break">
				<h3 class="text-xl font-semibold text-red-600 mb-4">(SRS-MartPlace-11) Daftar Produk Berdasarkan Rating</h3>
				<p class="text-sm text-red-600 mb-4 font-medium">Propinsi adalah propinsi pemberi rating. Diurutkan rating tertinggi.</p>
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="table-header-critical">
						<tr class="color-reorder-header">
							<th class="px-4 py-2 text-left text-xs font-medium uppercase">No.</th>
							<th class="px-4 py-2 text-left text-xs font-medium uppercase">Produk</th>
							<th class="px-4 py-2 text-left text-xs font-medium uppercase">Kategori</th>
							<th class="px-4 py-2 text-right text-xs font-medium uppercase">Harga</th>
							<th class="px-4 py-2 text-center text-xs font-medium uppercase">Rating</th>
							<th class="px-4 py-2 text-left text-xs font-medium uppercase">Nama Toko</th>
							<th class="px-4 py-2 text-left text-xs font-medium uppercase">Propinsi</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-100">
						@php
							$productRows = collect($productsByRating ?? [])
								->sortByDesc(fn($p) => $p['rating'] ?? 0)
								->values();
						@endphp
						@forelse($productRows as $i => $p)
							<tr class="table-critical-row bg-red-50/50 hover:bg-red-100/50">
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $i + 1 }}</td>
								<td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $p['product_name'] ?? '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $p['category'] ?? '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ isset($p['price']) ? number_format($p['price'],0,',','.') : '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-red-600 text-center">{{ isset($p['rating']) ? number_format($p['rating'],1) : '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $p['store_name'] ?? '-' }}</td>
								<td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $p['province'] ?? '-' }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="px-6 py-8 text-center text-yellow-700">Tidak ada data produk.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</section>
		</div>
	</main>
</div>
</body>
</html>
