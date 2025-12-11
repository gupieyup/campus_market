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

        @include('Admin._sidebar', ['active' => 'verifikasi', 'verifCount' => 3])
        

        <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <header class="bg-white border-b border-red-100 h-16 flex items-center justify-between px-8 flex-shrink-0 z-10">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>Moderasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-red-500 font-semibold">Review Pengajuan #REQ-889</span>
                </div>
                <div class="flex items-center gap-3">
                   <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wide border border-yellow-200">Menunggu Review</span>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 lg:p-8 scroll-smooth" id="scrollContainer">
                <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 pb-32">
                    
                    @php 
                        $regData = $applicant ?? session('last_registration', [
                            'nama_toko' => 'Berkah Jaya Book',
                            'deskripsi_toko' => 'Menjual buku tulis, alat tulis kantor, dan perlengkapan sekolah lengkap.',
                            'nama_pic' => 'Budi Santoso',
                            'no_hp_pic' => '081234567890',
                            'email_pic' => 'budi.s@student.univ.ac.id',
                            'jalan' => 'Jl. Merdeka No. 45, Cilandak',
                            'rt' => '005',
                            'rw' => '002',
                            'kelurahan' => 'Sukamaju',
                            'kota' => 'Jakarta Selatan',
                            'provinsi' => 'DKI Jakarta',
                            'no_ktp' => '3174092205980001',
                            'foto_pic_name' => 'budi_selfie.jpg',
                            'file_ktp_name' => 'ktp_scan_hd.jpg'
                        ]); 
                    @endphp

                    <div class="lg:col-span-5 space-y-6">
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-red-50 p-6">
                            <h3 class="text-sm font-semibold text-red-500 uppercase tracking-wide mb-4 flex items-center gap-2">
                                <span class="bg-red-100 p-1 rounded">🏪</span> Profil & Kontak
                            </h3>
                            <div class="space-y-4">
                                <div class="border-b border-gray-50 pb-2">
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">1. Nama Toko</label>
                                    <p class="text-base font-bold text-gray-800">{{ $regData['nama_toko'] }}</p>
                                </div>
                                <div class="border-b border-gray-50 pb-2">
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">2. Deskripsi</label>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $regData['deskripsi_toko'] }}</p>
                                </div>
                                <div>
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">3. Nama PIC</label>
                                    <p class="text-sm font-bold text-gray-800">{{ $regData['nama_pic'] }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">4. No. HP</label>
                                        <p class="text-sm font-medium text-gray-700 font-mono">{{ $regData['no_hp_pic'] }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">5. Email</label>
                                        <p class="text-sm font-medium text-blue-600 truncate">{{ $regData['email_pic'] }}</p>
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
                                    <label class="text-[11px] font-bold text-gray-400 uppercase block mb-1">6. Jalan</label>
                                    <p class="text-sm font-medium text-gray-800">{{ $regData['jalan'] }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-gray-50 p-2 rounded-lg border border-gray-100">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase block">7. RT</label>
                                        <p class="text-sm font-bold text-gray-800">{{ $regData['rt'] }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-2 rounded-lg border border-gray-100">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase block">8. RW</label>
                                        <p class="text-sm font-bold text-gray-800">{{ $regData['rw'] }}</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-0.5">9. Kelurahan</label>
                                        <p class="text-sm text-gray-700">{{ $regData['kelurahan'] }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-0.5">10. Kota</label>
                                        <p class="text-sm text-gray-700">{{ $regData['kota'] }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-gray-400 uppercase block mb-0.5">11. Provinsi</label>
                                        <p class="text-sm text-gray-700">{{ $regData['provinsi'] }}</p>
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
                                        <p class="text-lg font-mono font-bold text-gray-800 tracking-wider">{{ $regData['no_ktp'] }}</p>
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
                                        <img src="https://via.placeholder.com/800x600/374151/FFFFFF?text=FOTO+PIC+(Point+13)" class="max-w-full max-h-full object-contain shadow-2xl rounded" alt="Foto PIC">
                                    </template>
                                    <template x-if="activeDoc === 'ktp'">
                                        <img src="https://via.placeholder.com/800x600/374151/FFFFFF?text=SCAN+KTP+(Point+14)" class="max-w-full max-h-full object-contain shadow-2xl rounded" alt="Scan KTP">
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
                    
                    <div x-show="actionStatus === 'idle'" class="hidden md:block text-sm text-gray-500">
                        Review data untuk: <span class="font-bold text-gray-800">Budi Santoso</span>
                    </div>

                    <div x-show="actionStatus === 'reject'" class="flex-1 mr-4 max-w-2xl" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                         <div class="flex items-center gap-2">
                             <input type="text" x-model="rejectReason" class="flex-1 text-sm rounded-xl border-red-300 focus:ring-red-500 focus:border-red-500 px-4 py-2.5 bg-red-50" placeholder="Tulis alasan penolakan di sini...">
                         </div>
                    </div>

                    <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                        
                        <button x-show="actionStatus === 'reject'" @click="actionStatus = 'idle'" class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition text-sm">
                            Batal
                        </button>

                        <button x-show="actionStatus === 'idle'" @click="actionStatus = 'reject'" class="px-5 py-2.5 rounded-xl border border-red-200 text-red-600 font-bold hover:bg-red-50 transition text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>

                        <button x-show="actionStatus === 'reject'" @click="submitRejection()" :disabled="!rejectReason" :class="!rejectReason ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-700 shadow-red-200'" class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-bold text-sm shadow-lg transition">
                            Kirim Penolakan
                        </button>

                        <button x-show="actionStatus === 'idle'" @click="submitApproval()" class="px-6 py-2.5 rounded-xl bg-green-500 text-white font-bold hover:bg-green-600 text-sm shadow-lg shadow-green-200 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui
                        </button>
                    </div>

                </div>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verificationDetail', () => ({
                activeDoc: 'foto',
                actionStatus: 'idle',
                rejectReason: '',
                submitApproval() {
                    if(confirm("Yakin data valid?")) alert("Disetujui!");
                },
                submitRejection() {
                    if(!this.rejectReason) return;
                    alert("Ditolak: " + this.rejectReason);
                    this.actionStatus = 'idle'; this.rejectReason = '';
                }
            }))
        })
    </script>
</body>
</html>