<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Moderasi Verifikasi Penjual - SiToko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased" x-data="verificationPage()">

    <div class="flex h-screen overflow-hidden">

        @include('Admin._sidebar', ['active' => 'verifikasi', 'verifCount' => $verifCount ?? 0])

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
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}" 
                       class="{{ $status === 'pending' ? 'bg-red-100 text-red-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} px-4 py-2 text-sm font-medium rounded-lg transition">
                        Perlu Review ({{ $stats['pending'] ?? 0 }})
                    </a>
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'rejected']) }}" 
                       class="{{ $status === 'rejected' ? 'bg-red-100 text-red-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} px-4 py-2 text-sm font-medium rounded-lg transition">
                        Ditolak
                    </a>
                    <a href="{{ route('admin.verifikasi.index', ['status' => 'verified']) }}" 
                       class="{{ $status === 'verified' ? 'bg-red-100 text-red-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} px-4 py-2 text-sm font-medium rounded-lg transition">
                        Disetujui
                    </a>
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
                            @forelse($pendingSellers as $seller)
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        @if($seller->shop_image)
                                            <img src="{{ asset('storage/' . $seller->shop_image) }}" 
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
                                                 onerror="this.outerHTML='<div class=\'w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm\'>{{ strtoupper(substr($seller->user->name, 0, 2)) }}</div>'">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                                {{ strtoupper(substr($seller->user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $seller->user->name }}</div>
                                            <div class="text-xs text-gray-500">Toko: "{{ $seller->shop_name }}"</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-sm text-gray-600">{{ $seller->created_at->format('d M Y, H:i') }}</td>
                                <td class="p-5">
                                    @if($seller->verification_status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                            Menunggu Review
                                        </span>
                                    @elseif($seller->verification_status === 'verified')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="p-5 text-sm text-gray-600">{{ $seller->user->email }}</td>
                                <td class="p-5 text-right">
                                    @if($seller->verification_status === 'pending')
                                        <button @click="openModal({{ $seller->id }}, '{{ addslashes($seller->user->name) }}', '{{ addslashes($seller->shop_name) }}', '{{ $seller->user->email }}', '{{ addslashes($seller->phone) }}', '{{ addslashes($seller->address) }}', '{{ $seller->shop_image ? asset('storage/' . $seller->shop_image) : '' }}')" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors inline-block">
                                            Review
                                        </button>
                                    @else
                                        <a href="{{ route('admin.verifikasi.show', $seller->id) }}" 
                                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors inline-block">
                                            Lihat Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-bold text-gray-700 mb-2">Tidak Ada Data</h3>
                                    <p class="text-sm text-gray-500">
                                        @if($status === 'pending')
                                            Belum ada pengajuan verifikasi yang perlu ditinjau
                                        @elseif($status === 'rejected')
                                            Belum ada pengajuan yang ditolak
                                        @else
                                            Belum ada pengajuan yang disetujui
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="p-5 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm text-gray-500">
                        Menampilkan {{ $pendingSellers->count() }} data
                        @if($status === 'pending')
                            yang perlu direview
                        @elseif($status === 'rejected')
                            yang ditolak
                        @else
                            yang disetujui
                        @endif
                    </span>
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
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden transform transition-all max-h-[90vh] flex flex-col"
             @click.away="closeModal()">
            
            <!-- Modal Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center flex-shrink-0">
                <h3 class="text-lg font-bold text-gray-800">Verifikasi Data Penjual</h3>
                <button @click="closeModal()" class="text-gray-400 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row flex-1 overflow-hidden">
                <!-- Left: Applicant Details -->
                <div class="w-full md:w-1/3 bg-white p-6 border-r border-gray-100 overflow-y-auto">
                    <div class="text-center mb-6">
                        <template x-if="activeUser.image">
                            <img :src="activeUser.image" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover border-2 border-red-200" alt="Foto Toko">
                        </template>
                        <template x-if="!activeUser.image">
                            <div class="w-20 h-20 bg-red-100 rounded-full mx-auto flex items-center justify-center text-red-500 text-2xl font-bold mb-3" x-text="activeUser.initials">BS</div>
                        </template>
                        <h4 class="font-bold text-gray-800 text-lg" x-text="activeUser.name">Loading...</h4>
                        <p class="text-sm text-gray-500" x-text="activeUser.email">-</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Nama Toko</label>
                            <p class="text-sm font-medium text-gray-800" x-text="activeUser.storeName">-</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Nomor HP</label>
                            <p class="text-sm font-medium text-gray-800" x-text="activeUser.phone">-</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Alamat Lengkap</label>
                            <p class="text-sm text-gray-600" x-text="activeUser.address">-</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Document Checking -->
                <div class="w-full md:w-2/3 bg-gray-50 p-6 overflow-y-auto flex flex-col">
                    <h4 class="font-bold text-gray-800 mb-4">Kelengkapan Dokumen</h4>

                    <!-- State: Viewing Documents -->
                    <div x-show="!isRejecting">
                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <!-- Card Foto Toko -->
                            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-gray-500 uppercase">Foto Toko</span>
                                    <span class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                                </div>
                                <template x-if="activeUser.image">
                                    <img :src="activeUser.image" class="w-full h-48 object-cover rounded-lg border-2 border-gray-200" alt="Preview Foto Toko">
                                </template>
                                <template x-if="!activeUser.image">
                                    <div class="h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-sm border-2 border-dashed border-gray-300">
                                        [Tidak Ada Foto]
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-sm text-blue-800 mb-6">
                            <p class="font-bold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Panduan Verifikasi
                            </p>
                            <p class="mt-1">Pastikan data kontak valid, nama toko sesuai, dan foto toko jelas. Periksa apakah ada indikasi pelanggaran kebijakan.</p>
                        </div>
                    </div>

                    <!-- State: Rejecting (Form) -->
                    <div x-show="isRejecting" class="flex-1 flex flex-col" x-transition>
                        <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-4">
                            <h5 class="font-bold text-red-700 text-sm mb-2">Konfirmasi Penolakan</h5>
                            <p class="text-sm text-red-600 mb-4">Notifikasi penolakan akan dikirimkan ke pengguna. Mohon berikan alasan yang jelas agar pengguna dapat memperbaiki data.</p>
                            
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Penolakan</label>
                            <textarea x-model="rejectReason" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none text-sm h-32" placeholder="Contoh: Foto toko tidak jelas, Nama toko mengandung unsur SARA, Data kontak tidak valid, dll... (minimal 10 karakter)"></textarea>
                        </div>
                    </div>

                    <!-- Action Buttons Footer (Sticky Bottom) -->
                    <div class="mt-auto pt-4 border-t border-gray-200 flex justify-end gap-3">
                        
                        <!-- Buttons when VIEWING -->
                        <div x-show="!isRejecting" class="flex gap-3 w-full justify-end">
                            <button @click="startReject()" class="px-5 py-2.5 rounded-xl border border-red-200 text-red-600 font-semibold hover:bg-red-50 transition">
                                Tolak Pengajuan
                            </button>
                            <button @click="approveUser()" :disabled="loading" :class="loading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-green-600'" class="px-5 py-2.5 rounded-xl bg-green-500 text-white font-semibold shadow-lg shadow-green-200 transition flex items-center gap-2">
                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span x-text="loading ? 'Memproses...' : 'Terima & Aktivasi'"></span>
                            </button>
                        </div>

                        <!-- Buttons when REJECTING -->
                        <div x-show="isRejecting" class="flex gap-3 w-full justify-end">
                            <button @click="isRejecting = false; rejectReason = ''" class="px-5 py-2.5 rounded-xl text-gray-500 font-semibold hover:text-gray-700 transition">
                                Batal
                            </button>
                            <button @click="submitRejection()" :disabled="loading || rejectReason.length < 10" :class="(loading || rejectReason.length < 10) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-700'" class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-semibold shadow-lg shadow-red-200 transition flex items-center gap-2">
                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                <span x-text="loading ? 'Memproses...' : 'Kirim Penolakan'"></span>
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
                loading: false,
                currentStatus: '{{ $status }}',
                activeUser: {
                    id: null,
                    name: '',
                    storeName: '',
                    email: '',
                    phone: '',
                    address: '',
                    image: '',
                    initials: ''
                },

                openModal(id, name, store, email, phone, address, image) {
                    this.activeUser = {
                        id: id,
                        name: name,
                        storeName: store,
                        email: email,
                        phone: phone,
                        address: address,
                        image: image,
                        initials: name.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase()
                    };
                    this.isRejecting = false;
                    this.rejectReason = '';
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.isRejecting = false;
                    this.rejectReason = '';
                },

                startReject() {
                    this.isRejecting = true;
                },

                async approveUser() {
                    if(!confirm(`Yakin ingin menyetujui pengajuan dari ${this.activeUser.name}?\n\nAkun seller akan langsung aktif dan dapat mulai berjualan.`)) {
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await fetch(`/dashboard-admin/verifikasi/${this.activeUser.id}/approve`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        const data = await response.json();

                        if(data.success) {
                            alert(`✅ SUKSES!\n\n${data.message}\n\nAkun ${this.activeUser.name} telah diaktifkan.`);
                            this.closeModal();
                            // Reload dengan status yang sama
                            window.location.href = `/dashboard-admin/verifikasi?status=${this.currentStatus}`;
                        } else {
                            alert('❌ Error: ' + data.message);
                        }
                    } catch(error) {
                        console.error('Error:', error);
                        alert('❌ Terjadi kesalahan saat memproses persetujuan');
                    } finally {
                        this.loading = false;
                    }
                },

                async submitRejection() {
                    if(this.rejectReason.length < 10) {
                        alert('⚠️ Alasan penolakan minimal 10 karakter');
                        return;
                    }

                    if(!confirm(`Yakin ingin menolak pengajuan dari ${this.activeUser.name}?`)) {
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await fetch(`/dashboard-admin/verifikasi/${this.activeUser.id}/reject`, {
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
                            alert(`⚠️ DITOLAK\n\n${data.message}\n\nAlasan: "${this.rejectReason}"`);
                            this.closeModal();
                            // Reload dengan status yang sama
                            window.location.href = `/dashboard-admin/verifikasi?status=${this.currentStatus}`;
                        } else {
                            alert('❌ Error: ' + data.message);
                        }
                    } catch(error) {
                        console.error('Error:', error);
                        alert('❌ Terjadi kesalahan saat memproses penolakan');
                    } finally {
                        this.loading = false;
                    }
                }
            }))
        })
    </script>
</body>
</html>