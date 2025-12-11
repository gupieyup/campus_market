<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Review Verifikasi - SiToko Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
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
                    <a href="{{ route('admin.verifikasi.index') }}" class="hover:text-red-500 transition">Moderasi</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-red-500 font-semibold">Review Pengajuan #{{ $seller->id }}</span>
                </div>
                <div class="flex items-center gap-3">
                    @if($seller->verification_status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wide border border-yellow-200">Menunggu Review</span>
                    @elseif($seller->verification_status === 'verified')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-wide border border-green-200">Terverifikasi</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase tracking-wide border border-red-200">Ditolak</span>
                    @endif
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 lg:p-8 scroll-smooth" id="scrollContainer">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 pb-32">
                    
                    <div class="lg:col-span-5 space-y-6">
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-red-50 p-6">
                            <h3 class="text-sm font-semibold text-red-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <span class="bg-red-100 p-1 rounded">🏪</span> Profil & Kontak
                            </h3>
                            <div class="space-y-4">
                                <div class="border-b border-gray-50 pb-2">
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">1. Nama Toko</label>
                                    <p class="text-base font-bold text-gray-800">{{ $applicant['nama_toko'] }}</p>
                                </div>
                                <div class="border-b border-gray-50 pb-2">
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">2. Deskripsi</label>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $applicant['deskripsi_toko'] }}</p>
                                </div>
                                <div>
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">3. Nama PIC</label>
                                    <p class="text-sm font-bold text-gray-800">{{ $applicant['nama_pic'] }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">4. No. HP</label>
                                        <p class="text-sm font-medium text-gray-700 font-mono">{{ $applicant['no_hp_pic'] }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">5. Email</label>
                                        <p class="text-sm font-medium text-blue-600 truncate">{{ $applicant['email_pic'] }}</p>
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
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">6. Alamat Lengkap</label>
                                    <p class="text-sm font-medium text-gray-800">{{ $applicant['jalan'] }}</p>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-0.5">7. Kota/Kabupaten</label>
                                        <p class="text-sm text-gray-700">{{ $applicant['kota'] }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-0.5">8. Provinsi</label>
                                        <p class="text-sm text-gray-700">{{ $applicant['provinsi'] }}</p>
                                    </div>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mt-3">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Tanggal Pengajuan</label>
                                    <p class="text-sm font-medium text-gray-700">{{ $applicant['created_at'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-red-50 p-6">
                            <h3 class="text-sm font-semibold text-red-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <span class="bg-red-100 p-1 rounded">📷</span> Dokumen Pendukung
                            </h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 gap-3">
                                    <div @click="activeDoc='foto'; window.scrollTo({top:0, behavior:'smooth'})" class="cursor-pointer border border-green-100 bg-green-50 rounded-lg p-3 hover:bg-green-100 transition">
                                        <label class="text-[10px] font-bold text-green-700 uppercase block mb-1">9. Foto Toko</label>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1 text-xs text-green-800 font-semibold">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                {{ $applicant['foto_pic_name'] }}
                                            </div>
                                            <span class="text-xs text-green-600">Lihat →</span>
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
                                            Foto Toko
                                        </button>
                                    </div>
                                    <span class="text-xs font-medium text-gray-400">Mode Preview</span>
                                </div>

                                <div class="flex-1 bg-gray-900 relative overflow-hidden flex items-center justify-center p-8">
                                    <template x-if="activeDoc === 'foto'">
                                        @if($seller->shop_image)
                                            <img src="{{ asset('storage/' . $seller->shop_image) }}" 
                                                 class="max-w-full max-h-full object-contain shadow-2xl rounded" 
                                                 alt="Foto Toko"
                                                 onerror="this.src='https://via.placeholder.com/800x600/374151/FFFFFF?text=Foto+Tidak+Tersedia'">
                                        @else
                                            <img src="https://via.placeholder.com/800x600/374151/FFFFFF?text=Foto+Tidak+Tersedia" 
                                                 class="max-w-full max-h-full object-contain shadow-2xl rounded" 
                                                 alt="Foto Toko">
                                        @endif
                                    </template>
                                </div>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <h4 class="text-sm font-bold text-yellow-800">Panduan Validasi</h4>
                                    <p class="text-xs text-yellow-700 mt-1">Pastikan informasi toko lengkap dan foto yang diunggah jelas. Verifikasi bahwa data kontak dapat dihubungi.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            @if($seller->verification_status === 'pending')
            <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 lg:px-8 z-30 shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
                <div class="max-w-7xl mx-auto flex items-center justify-between">
                    
                    <div x-show="actionStatus === 'idle'" class="hidden md:block text-sm text-gray-500">
                        Review data untuk: <span class="font-bold text-gray-800">{{ $applicant['nama_pic'] }}</span>
                    </div>

                    <div x-show="actionStatus === 'reject'" class="flex-1 mr-4 max-w-2xl" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                         <div class="flex items-center gap-2">
                             <input type="text" x-model="rejectReason" class="flex-1 text-sm rounded-xl border-red-300 focus:ring-red-500 focus:border-red-500 px-4 py-2.5 bg-red-50" placeholder="Tulis alasan penolakan di sini... (minimal 10 karakter)">
                         </div>
                    </div>

                    <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                        
                        <button x-show="actionStatus === 'reject'" @click="actionStatus = 'idle'; rejectReason = ''" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition text-sm">
                            Batal
                        </button>

                        <button x-show="actionStatus === 'idle'" @click="actionStatus = 'reject'" class="px-5 py-2.5 rounded-xl border border-red-200 text-red-600 font-bold hover:bg-red-50 transition text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>

                        <button x-show="actionStatus === 'reject'" @click="submitRejection()" :disabled="loading || rejectReason.length < 10" :class="(loading || rejectReason.length < 10) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-700 shadow-red-200'" class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-bold text-sm shadow-lg transition">
                            <span x-show="!loading">Kirim Penolakan</span>
                            <span x-show="loading">Memproses...</span>
                        </button>

                        <button x-show="actionStatus === 'idle'" @click="submitApproval()" :disabled="loading" :class="loading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-green-600 shadow-green-200'" class="px-6 py-2.5 rounded-xl bg-green-500 text-white font-bold text-sm shadow-lg transition flex items-center gap-2">
                            <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span x-show="!loading">Setujui</span>
                            <span x-show="loading">Memproses...</span>
                        </button>
                    </div>

                </div>
            </div>
            @endif

        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verificationDetail', () => ({
                activeDoc: 'foto',
                actionStatus: 'idle',
                rejectReason: '',
                loading: false,

                async submitApproval() {
                    if(!confirm("Yakin ingin menyetujui pengajuan ini? Data seller akan langsung aktif.")) return;
                    
                    this.loading = true;
                    
                    try {
                        const response = await fetch(`/dashboard-admin/verifikasi/{{ $seller->id }}/approve`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        const data = await response.json();

                        if(data.success) {
                            alert(data.message);
                            window.location.href = '/dashboard-admin/verifikasi';
                        } else {
                            alert('Error: ' + data.message);
                        }
                    } catch(error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memproses persetujuan');
                    } finally {
                        this.loading = false;
                    }
                },

                async submitRejection() {
                    if(this.rejectReason.length < 10) {
                        alert('Alasan penolakan minimal 10 karakter');
                        return;
                    }

                    if(!confirm("Yakin ingin menolak pengajuan ini?")) return;
                    
                    this.loading = true;
                    
                    try {
                        const response = await fetch(`/dashboard-admin/verifikasi/{{ $seller->id }}/reject`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                reason: this.rejectReason
                            })
                        });

                        const data = await response.json();

                        if(data.success) {
                            alert(data.message);
                            window.location.href = '/dashboard-admin/verifikasi';
                        } else {
                            alert('Error: ' + data.message);
                        }
                    } catch(error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memproses penolakan');
                    } finally {
                        this.loading = false;
                    }
                }
            }))
        })
    </script>
</body>
</html>