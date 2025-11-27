<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Verifikasi Penjual - SiToko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Menambahkan Alpine.js untuk interaksi Modal yang smooth tanpa banyak vanilla JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased" x-data="verificationPage()">

    <div class="flex h-screen overflow-hidden">

        @include('Admin._sidebar', ['active' => 'verifikasi', 'verifCount' => 3])

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Verifikasi Calon Penjual</h2>
                    <p class="text-gray-500 text-sm mt-1">Tinjau kelengkapan dokumen dan validasi pendaftaran toko baru.</p>
                </div>
                
                <!-- Quick Filter / Tabs -->
                <div class="bg-white p-1 rounded-xl border border-red-100 flex shadow-sm">
                    <button class="px-4 py-2 text-sm font-medium rounded-lg bg-red-100 text-red-600">Perlu Review (3)</button>
                    <button class="px-4 py-2 text-sm font-medium rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition">Ditolak</button>
                    <button class="px-4 py-2 text-sm font-medium rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition">Disetujui</button>
                </div>
            </div>

            <!-- List Card Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="p-5 font-semibold">Nama Calon / Toko</th>
                                <th class="p-5 font-semibold">Tanggal Daftar</th>
                                <th class="p-5 font-semibold">Status Dokumen</th>
                                <th class="p-5 font-semibold">Email</th>
                                <th class="p-5 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            
                            <!-- Row 1 -->
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">BS</div>
                                        <div>
                                            <div class="font-bold text-gray-800">Budi Santoso</div>
                                            <div class="text-xs text-gray-500">Toko: "Berkah Jaya Book"</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-sm text-gray-600">24 Nov 2023, 08:30</td>
                                <td class="p-5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                        Menunggu Review
                                    </span>
                                </td>
                                <td class="p-5 text-sm text-gray-600">budi.s@student.univ.ac.id</td>
                                <td class="p-5 text-right">
                                    <a href="{{ url('/dashboard-admin/detailverifikasi') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors inline-block">
                                        Review
                                    </a>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold">AM</div>
                                        <div>
                                            <div class="font-bold text-gray-800">Anisa Maharani</div>
                                            <div class="text-xs text-gray-500">Toko: "Preloved Fashion"</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-sm text-gray-600">24 Nov 2023, 10:15</td>
                                <td class="p-5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                        Menunggu Review
                                    </span>
                                </td>
                                <td class="p-5 text-sm text-gray-600">anisa.m@student.univ.ac.id</td>
                                <td class="p-5 text-right">
                                    <a href="{{ url('/dashboard-admin/detailverifikasi') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors inline-block">
                                        Review
                                    </a>
                                </td>
                            </tr>

                             <!-- Row 3 -->
                             <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold">DK</div>
                                        <div>
                                            <div class="font-bold text-gray-800">Dimas Kurniawan</div>
                                            <div class="text-xs text-gray-500">Toko: "Jasa Ketik Kilat"</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-sm text-gray-600">23 Nov 2023, 16:45</td>
                                <td class="p-5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Revisi Diupload
                                    </span>
                                </td>
                                <td class="p-5 text-sm text-gray-600">dimas.k@student.univ.ac.id</td>
                                <td class="p-5 text-right">
                                    <a href="{{ url('/dashboard-admin/detailverifikasi') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors inline-block">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="p-5 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Menampilkan 1-3 dari 3 data</span>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-sm border rounded text-gray-500 hover:bg-gray-50" disabled>Previous</button>
                        <button class="px-3 py-1 text-sm border rounded text-gray-500 hover:bg-gray-50" disabled>Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL VERIFIKASI (Alpine JS Controlled) -->
    <div x-cloak x-show="isModalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm transition-opacity"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Modal Content -->
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden transform transition-all"
             @click.away="closeModal()">
            
            <!-- Modal Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Verifikasi Data Penjual</h3>
                <button @click="closeModal()" class="text-gray-400 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row h-[500px]">
                <!-- Left: Applicant Details -->
                <div class="w-full md:w-1/3 bg-white p-6 border-r border-gray-100 overflow-y-auto">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-red-100 rounded-full mx-auto flex items-center justify-center text-red-500 text-2xl font-bold mb-3" x-text="activeUser.initials">BS</div>
                        <h4 class="font-bold text-gray-800 text-lg" x-text="activeUser.name">Budi Santoso</h4>
                        <p class="text-sm text-gray-500" x-text="activeUser.email">budi.s@student.univ.ac.id</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Nama Toko</label>
                            <p class="text-sm font-medium text-gray-800" x-text="activeUser.storeName">Berkah Jaya Book</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Nomor HP</label>
                            <p class="text-sm font-medium text-gray-800">+62 812 3456 7890</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Alamat Pickup</label>
                            <p class="text-sm text-gray-600">Jl. Kaliurang KM 5, Gg. Megatruh No. 12, Sleman, Yogyakarta.</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">NIM / ID Mahasiswa</label>
                            <p class="text-sm font-medium text-gray-800">19/445566/PA/12345</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Document Checking -->
                <div class="w-full md:w-2/3 bg-gray-50 p-6 overflow-y-auto flex flex-col">
                    <h4 class="font-bold text-gray-800 mb-4">Kelengkapan Dokumen</h4>

                    <!-- State: Viewing Documents -->
                    <div x-show="!isRejecting">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Card KTM -->
                            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-gray-500 uppercase">Kartu Tanda Mahasiswa</span>
                                    <span class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                                </div>
                                <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-sm border-2 border-dashed border-gray-300">
                                    [Preview Gambar KTM]
                                </div>
                                <button class="w-full mt-3 text-sm text-red-500 font-semibold hover:underline">Lihat Fullscreen</button>
                            </div>

                            <!-- Card KTP -->
                            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-gray-500 uppercase">KTP</span>
                                    <span class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                                </div>
                                <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-sm border-2 border-dashed border-gray-300">
                                    [Preview Gambar KTP]
                                </div>
                                <button class="w-full mt-3 text-sm text-red-500 font-semibold hover:underline">Lihat Fullscreen</button>
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-4 text-sm text-yellow-800 mb-6">
                            <p class="font-bold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Catatan Sistem
                            </p>
                            <p class="mt-1">Nama di KTP sesuai dengan nama di KTM. Status Mahasiswa Aktif.</p>
                        </div>
                    </div>

                    <!-- State: Rejecting (Form) -->
                    <div x-show="isRejecting" class="flex-1 flex flex-col" x-transition>
                        <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-4">
                            <h5 class="font-bold text-red-700 text-sm mb-2">Konfirmasi Penolakan</h5>
                            <p class="text-sm text-red-600 mb-4">Email penolakan akan dikirimkan ke pengguna. Mohon berikan alasan yang jelas agar pengguna dapat memperbaiki data.</p>
                            
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Penolakan</label>
                            <textarea x-model="rejectReason" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none text-sm h-32" placeholder="Contoh: Foto KTM buram, Nama toko mengandung unsur SARA, dll..."></textarea>
                        </div>
                    </div>

                    <!-- Action Buttons Footer (Sticky Bottom) -->
                    <div class="mt-auto pt-4 border-t border-gray-200 flex justify-end gap-3">
                        
                        <!-- Buttons when VIEWING -->
                        <div x-show="!isRejecting" class="flex gap-3 w-full justify-end">
                            <button @click="startReject()" class="px-5 py-2.5 rounded-xl border border-red-200 text-red-600 font-semibold hover:bg-red-50 transition">
                                Tolak Pengajuan
                            </button>
                            <button @click="approveUser()" class="px-5 py-2.5 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 shadow-lg shadow-green-200 transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Terima & Aktivasi
                            </button>
                        </div>

                        <!-- Buttons when REJECTING -->
                        <div x-show="isRejecting" class="flex gap-3 w-full justify-end">
                            <button @click="isRejecting = false" class="px-5 py-2.5 rounded-xl text-gray-500 font-semibold hover:text-gray-700 transition">
                                Batal
                            </button>
                            <button @click="submitRejection()" :disabled="!rejectReason" :class="!rejectReason ? 'opacity-50 cursor-not-allowed' : ''" class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 shadow-lg shadow-red-200 transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Email Penolakan
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logic Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verificationPage', () => ({
                isModalOpen: false,
                isRejecting: false,
                rejectReason: '',
                activeUser: {
                    name: '',
                    storeName: '',
                    email: '',
                    initials: ''
                },

                openModal(name, store, email) {
                    this.activeUser = {
                        name: name,
                        storeName: store,
                        email: email,
                        initials: name.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase()
                    };
                    this.isRejecting = false;
                    this.rejectReason = '';
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                startReject() {
                    this.isRejecting = true;
                },

                approveUser() {
                    // Di sini logika Backend API call untuk Approve
                    alert(`✅ SUKSES!\n\nAkun ${this.activeUser.name} telah diaktifkan.\nEmail notifikasi berisi kredensial login telah dikirim ke ${this.activeUser.email}.`);
                    this.closeModal();
                    // Optional: Refresh table data here
                },

                submitRejection() {
                    // Di sini logika Backend API call untuk Reject dengan alasan
                    alert(`⚠️ DITOLAK.\n\nPengajuan atas nama ${this.activeUser.name} telah ditolak.\nEmail berisi alasan penolakan ("${this.rejectReason}") telah dikirim.`);
                    this.closeModal();
                }
            }))
        })
    </script>
</body>
</html>