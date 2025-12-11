<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Verifikasi - SiToko Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased" x-data="verificationDetail()">

    <div class="flex h-screen overflow-hidden">

        @include('Admin._sidebar', ['active' => 'verifikasi', 'verifCount' => $verifCount ?? 0])
        

        <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <header class="bg-white border-b border-red-100 h-16 flex items-center justify-between px-8 flex-shrink-0 z-10">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>Moderasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-red-500 font-semibold">Review Pengajuan #{{ $seller->id }}</span>
                </div>
                <div class="flex items-center gap-3">
                    @php
                        $status = $seller->verification_status;
                        $badgeClass = $status === 'verified' ? 'bg-green-100 text-green-700 border-green-200' : ($status === 'rejected' ? 'bg-red-100 text-red-700 border-red-200' : 'bg-yellow-100 text-yellow-700 border-yellow-200');
                        $label = $status === 'verified' ? 'Terverifikasi' : ($status === 'rejected' ? 'Ditolak' : 'Menunggu Review');
                    @endphp
                    <span class="px-3 py-1 {{ $badgeClass }} rounded-full text-xs font-bold uppercase tracking-wide">{{ $label }}</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 lg:p-8 scroll-smooth" id="scrollContainer">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 pb-32">
                    
                    @php use Illuminate\Support\Str; @endphp

                    <div class="lg:col-span-5 space-y-6">
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-red-50 p-6">
                            <h3 class="text-sm font-semibold text-red-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <span class="bg-red-100 p-1 rounded">🏪</span> Profil & Kontak
                            </h3>
                            <div class="space-y-4">
                                <div class="border-b border-gray-50 pb-2">
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">1. Nama Toko</label>
                                    <p class="text-base font-bold text-gray-800">{{ $seller->shop_name }}</p>
                                </div>
                                <div class="border-b border-gray-50 pb-2">
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">2. Deskripsi</label>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $seller->shop_description ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">3. Nama PIC</label>
                                    <p class="text-sm font-bold text-gray-800">{{ $seller->user->name }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">4. No. HP</label>
                                        <p class="text-sm font-medium text-gray-700 font-mono">{{ $seller->phone }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">5. Email</label>
                                        <p class="text-sm font-medium text-blue-600 truncate">{{ $seller->user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-red-50 p-6">
                            <h3 class="text-sm font-semibold text-red-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <span class="bg-red-100 p-1 rounded">📍</span> Detail Alamat
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">Alamat Lengkap</label>
                                    <p class="text-sm font-medium text-gray-800">{{ $seller->address }}</p>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-0.5">Kota/Kabupaten</label>
                                        <p class="text-sm text-gray-700">{{ optional($seller->region)->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-red-50 p-6">
                            <h3 class="text-sm font-semibold text-red-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <span class="bg-red-100 p-1 rounded">🆔</span> Validasi Identitas
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">12. Nomor KTP (NIK)</label>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center">
                                        <p class="text-lg font-mono font-bold text-gray-800 tracking-wider">{{ $seller->nik ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div @click="activeDoc='foto'; window.scrollTo({top:0, behavior:'smooth'})" class="cursor-pointer border border-green-100 bg-green-50 rounded-lg p-3 hover:bg-green-100 transition">
                                        <label class="text-[10px] font-bold text-green-700 uppercase block mb-1">13. Foto PIC</label>
                                        <div class="flex items-center gap-1 text-xs text-green-800 font-semibold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Uploaded
                                        </div>
                                    </div>
                                    <div @click="activeDoc='ktp'; window.scrollTo({top:0, behavior:'smooth'})" class="cursor-pointer border border-green-100 bg-green-50 rounded-lg p-3 hover:bg-green-100 transition">
                                        <label class="text-[10px] font-bold text-green-700 uppercase block mb-1">14. File KTP</label>
                                        <div class="flex items-center gap-1 text-xs text-green-800 font-semibold">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Uploaded
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-7">
                        <div class="sticky top-4 space-y-4">
                            
                            <div class="bg-white rounded-2xl shadow-sm border border-red-50 overflow-hidden flex flex-col h-[600px]">
                                <div class="bg-gray-50 border-b border-gray-100 px-6 py-3 flex justify-between items-center">
                                    <div class="flex space-x-2">
                                        <button @click="activeDoc = 'foto'" :class="activeDoc === 'foto' ? 'bg-red-600 text-white shadow-md' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50'" class="px-4 py-1.5 text-xs font-bold uppercase rounded-lg transition-all">
                                            Foto Diri
                                        </button>
                                        <button @click="activeDoc = 'ktp'" :class="activeDoc === 'ktp' ? 'bg-red-600 text-white shadow-md' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50'" class="px-4 py-1.5 text-xs font-bold uppercase rounded-lg transition-all">
                                            Scan KTP
                                        </button>
                                    </div>
                                    <span class="text-xs font-medium text-gray-400">Mode Preview</span>
                                </div>

                                <div class="flex-1 bg-gray-900 relative overflow-hidden flex items-center justify-center p-8">
                                    <template x-if="activeDoc === 'foto'">
                                        <img src="{{ $seller->shop_image ? asset('storage/' . $seller->shop_image) : 'https://via.placeholder.com/800x600/374151/FFFFFF?text=TIDAK+ADA+FOTO' }}" class="max-w-full max-h-full object-contain shadow-2xl rounded" alt="Foto PIC">
                                    </template>
                                    <template x-if="activeDoc === 'ktp'">
                                        @php $isPdf = $seller->ktp_image && Str::endsWith(strtolower($seller->ktp_image), '.pdf'); @endphp
                                        @if($isPdf)
                                            <div class="text-center text-white">
                                                <a class="underline text-blue-300" href="{{ asset('storage/' . $seller->ktp_image) }}" target="_blank">Buka File KTP (PDF)</a>
                                            </div>
                                        @else
                                            <img src="{{ $seller->ktp_image ? asset('storage/' . $seller->ktp_image) : 'https://via.placeholder.com/800x600/374151/FFFFFF?text=TIDAK+ADA+FILE+KTP' }}" class="max-w-full max-h-full object-contain shadow-2xl rounded" alt="Scan KTP">
                                        @endif
                                    </template>
                                </div>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-sm font-bold text-yellow-800">Panduan Validasi</h4>
                                    <p class="text-xs text-yellow-700 mt-1">Pastikan NIK pada formulir (Poin 12) sama persis dengan yang tertera pada Scan KTP. Wajah pada Foto Diri harus cocok dengan foto di KTP.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 lg:px-8 z-30 shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Detail verifikasi ditampilkan tanpa aksi. Status saat ini: 
                        <span class="font-bold text-gray-800">{{ $label }}</span>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verificationDetail', () => ({
                activeDoc: 'foto'
            }))
        })
    </script>
</body>
</html>