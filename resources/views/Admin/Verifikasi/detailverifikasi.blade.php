<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Verifikasi - SiToko Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased" x-data="verificationDetail()">

    <div class="flex h-screen overflow-hidden">

        @include('Admin._sidebar', ['active' => 'verifikasi', 'verifCount' => 3])

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-hidden flex flex-col relative">
            
            <!-- Topbar: Breadcrumb & Title -->
            <header class="bg-white border-b border-red-100 h-16 flex items-center justify-between px-6 flex-shrink-0">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>Moderasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-red-500 font-semibold">Review Pengajuan #REQ-2023-889</span>
                </div>
                <div class="flex items-center gap-3">
                   <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wide">Menunggu Review</span>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- KOLOM KIRI: Data Pendaftar (ambil dari form registrasi) -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-red-50 p-6">
                            <h3 class="font-bold text-gray-800 mb-4">Data Pendaftar</h3>
                            @php $regData = $applicant ?? session('last_registration', []); @endphp
                            <div class="space-y-3 text-sm">
                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">Nama Toko</label>
                                    <p class="text-sm font-medium text-gray-800">{{ $regData['nama_toko'] ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">Deskripsi Singkat</label>
                                    <p class="text-sm text-gray-600">{{ $regData['deskripsi_toko'] ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">Nama PIC</label>
                                    <p class="text-sm font-medium text-gray-800">{{ $regData['nama_pic'] ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">No. Handphone</label>
                                    <p class="text-sm text-gray-600">{{ $regData['no_hp_pic'] ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">Email PIC</label>
                                    <p class="text-sm text-gray-600">{{ $regData['email_pic'] ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">Alamat</label>
                                    <p class="text-sm text-gray-600">{{ $regData['jalan'] ?? '-' }}<br>{{ 'RT ' . ($regData['rt'] ?? '-') . ' / RW ' . ($regData['rw'] ?? '-') }}<br>{{ $regData['kelurahan'] ?? '-' }}, {{ $regData['kota'] ?? '-' }}, {{ $regData['provinsi'] ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">No. KTP</label>
                                    <p class="text-sm text-gray-600">{{ $regData['no_ktp'] ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">Nama File Foto PIC</label>
                                    <p class="text-sm text-gray-600">{{ $regData['foto_pic_name'] ?? ($regData['foto_pic'] ?? '-') }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-400 uppercase">Nama File Scan KTP</label>
                                    <p class="text-sm text-gray-600">{{ $regData['file_ktp_name'] ?? ($regData['file_ktp'] ?? '-') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: Dokumen & Validasi -->
                    <div class="lg:col-span-2 space-y-6 pb-24"> <!-- pb-24 for sticky footer space -->
                        
                        <!-- Document Viewer -->
                        <div class="bg-white rounded-2xl shadow-sm border border-red-50 overflow-hidden">
                            <div class="border-b border-gray-100 px-6 py-4 bg-gray-50 flex justify-between items-center">
                                <h3 class="font-bold text-gray-800">Dokumen Pendukung</h3>
                                <div class="flex bg-white rounded-lg p-1 border border-gray-200 shadow-sm">
                                    <button @click="activeDoc = 'ktm'" :class="activeDoc === 'ktm' ? 'bg-red-50 text-red-600 shadow-sm' : 'text-gray-500 hover:bg-gray-50'" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all">KTM</button>
                                    <button @click="activeDoc = 'ktp'" :class="activeDoc === 'ktp' ? 'bg-red-50 text-red-600 shadow-sm' : 'text-gray-500 hover:bg-gray-50'" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all">KTP</button>
                                </div>
                            </div>

                            <div class="p-6 bg-gray-800 min-h-[400px] flex flex-col items-center justify-center relative group">
                                <!-- Simulated Image -->
                                <template x-if="activeDoc === 'ktm'">
                                    <div class="text-center w-full">
                                        <img src="https://via.placeholder.com/600x380/374151/FFFFFF?text=FOTO+KTM+MAHASISWA" alt="KTM" class="max-w-full max-h-[400px] object-contain mx-auto shadow-2xl rounded-lg border-4 border-white/10 transition-transform duration-300 hover:scale-105 cursor-zoom-in">
                                        <p class="text-gray-400 text-xs mt-4">Klik gambar untuk memperbesar</p>
                                    </div>
                                </template>
                                <template x-if="activeDoc === 'ktp'">
                                    <div class="text-center w-full">
                                        <img src="https://via.placeholder.com/600x380/374151/FFFFFF?text=FOTO+KTP+ASLI" alt="KTP" class="max-w-full max-h-[400px] object-contain mx-auto shadow-2xl rounded-lg border-4 border-white/10 transition-transform duration-300 hover:scale-105 cursor-zoom-in">
                                        <p class="text-gray-400 text-xs mt-4">Klik gambar untuk memperbesar</p>
                                    </div>
                                </template>

                                <!-- Helper Badge -->
                                <div class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-medium border border-white/20">
                                    <span x-text="activeDoc === 'ktm' ? 'Kartu Tanda Mahasiswa' : 'Kartu Tanda Penduduk'"></span>
                                </div>
                            </div>

                            <div class="bg-yellow-50 px-6 py-4 border-t border-yellow-100">
                                <h4 class="text-sm font-bold text-yellow-800 flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Panduan Verifikasi
                                </h4>
                                <ul class="text-sm text-yellow-700 list-disc list-inside space-y-1 ml-1">
                                    <li>Pastikan Nama di KTM sesuai dengan Nama di KTP.</li>
                                    <li>Pastikan foto terlihat jelas, tidak buram, dan tidak terpotong.</li>
                                    <li>Pastikan status mahasiswa masih aktif (cek tanggal berlaku KTM).</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Rejection Form (Hidden by default) -->
                        <div x-show="actionStatus === 'reject'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="bg-red-50 border border-red-200 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-red-800 font-bold mb-2">Formulir Penolakan</h3>
                            <p class="text-sm text-red-600 mb-4">Pesan ini akan dikirimkan otomatis ke email <b>budi.s@student.univ.ac.id</b>. Mohon gunakan bahasa yang sopan dan jelas.</p>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <button @click="rejectReason = 'Foto dokumen tidak jelas/buram, mohon upload ulang.'" class="text-xs text-left p-2 bg-white border border-red-100 rounded hover:bg-red-100 transition">📝 Foto Buram</button>
                                    <button @click="rejectReason = 'Nama di KTP tidak sesuai dengan KTM.'" class="text-xs text-left p-2 bg-white border border-red-100 rounded hover:bg-red-100 transition">📝 Nama Tidak Sesuai</button>
                                </div>
                                <textarea x-model="rejectReason" rows="4" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 p-3 text-sm" placeholder="Tulis alasan detail di sini..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STICKY FOOTER ACTION BAR -->
            <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 lg:px-8 z-10 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                <div class="max-w-6xl mx-auto flex items-center justify-between">
                    <div class="hidden lg:block text-sm text-gray-500">
                        Sedang mereview: <span class="font-semibold text-gray-800">Budi Santoso</span>
                    </div>

                    <div class="flex items-center gap-4 w-full lg:w-auto justify-end">
                        
                        <!-- Cancel Button (Only visible when rejecting) -->
                        <button x-show="actionStatus === 'reject'" @click="actionStatus = 'idle'" class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                            Batal
                        </button>

                        <!-- Reject Trigger -->
                        <button x-show="actionStatus === 'idle'" @click="actionStatus = 'reject'" class="px-6 py-2.5 rounded-xl border border-red-200 text-red-600 font-semibold hover:bg-red-50 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>

                        <!-- Confirm Reject (Send Email) -->
                        <button x-show="actionStatus === 'reject'" @click="submitRejection()" :disabled="!rejectReason" :class="!rejectReason ? 'opacity-50 cursor-not-allowed' : ''" class="px-6 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 shadow-lg shadow-red-200 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Kirim Email Penolakan
                        </button>

                        <!-- Approve Trigger -->
                        <button x-show="actionStatus === 'idle'" @click="submitApproval()" class="px-6 py-2.5 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 shadow-lg shadow-green-200 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui & Aktifkan Akun
                        </button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verificationDetail', () => ({
                activeDoc: 'ktm', // 'ktm' or 'ktp'
                actionStatus: 'idle', // 'idle' or 'reject'
                rejectReason: '',

                submitApproval() {
                    // Simulasi API Request ke Backend
                    const confirmMsg = confirm("Apakah Anda yakin data ini valid? Sistem akan mengirimkan email aktivasi ke pengguna.");
                    if(confirmMsg) {
                        alert("✅ SUKSES! \n\nEmail aktivasi telah dikirim ke budi.s@student.univ.ac.id.\nAkun 'Berkah Jaya Book' kini berstatus AKTIF.");
                        // Redirect logic here, e.g., window.location.href = '/admin/verification';
                    }
                },

                submitRejection() {
                    if(!this.rejectReason) return;
                    
                    alert(`⚠️ PENOLAKAN TERKIRIM! \n\nEmail penolakan telah dikirim dengan alasan:\n"${this.rejectReason}"`);
                    // Redirect logic here
                }
            }))
        })
    </script>
</body>
</html>