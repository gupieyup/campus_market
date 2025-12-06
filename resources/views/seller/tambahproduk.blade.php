<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko - Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom scrollbar matching the style */
        main::-webkit-scrollbar { width: 8px; }
        main::-webkit-scrollbar-thumb { background-color: #fca5a5; border-radius: 4px; }
        main::-webkit-scrollbar-track { background-color: #fef2f2; }

        /* Style untuk input form */
        .form-input {
            @apply w-full px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium focus:ring-red-500 focus:border-red-500 transition-colors;
        }

        /* Style untuk kotak dropzone */
        .dropzone {
            @apply border-2 border-dashed border-red-300 bg-red-50 rounded-xl p-6 text-center cursor-pointer transition-colors hover:border-red-500 hover:bg-red-100;
        }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">

<div class="flex h-screen overflow-hidden">
    @include('seller.layouts.sidebar', ['activeMenu' => 'tambahproduk'])
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
        <!-- Header Halaman -->
        <div class="flex flex-col items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800 w-full text-center">TAMBAH PRODUK</h1>
            <button onclick="history.back()" class="flex items-center text-red-500 font-medium hover:text-red-600 transition-colors mt-2">
                <!-- Arrow Left Icon -->
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Produk
            </button>
        </div>

        <!-- Form Kontainer (Pusat Form di tengah) -->
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg border border-red-100 p-6 md:p-10">
            <form id="productForm" method="POST" action="{{ route('seller.produk.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- BAGIAN 1: Informasi Dasar Produk -->
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Produk</h2>
                <div class="space-y-6 pb-6 border-b border-gray-200">
                    <!-- Kategori Produk -->
                    <div class="pb-4">
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori Produk</label>
                        <select id="kategori" name="category_id" required class="form-input text-gray-500 bg-gray-50 border-gray-300 focus:border-red-500">
                            <option value="" disabled selected>Silahkan Pilih</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Nama Produk -->
                    <div class="pb-4">
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" id="nama_produk" name="name" placeholder="Masukkan nama produk" required class="form-input bg-gray-50 border-gray-300 focus:border-red-500">
                    </div>
                    <!-- Region / Provinsi (default dari region toko jika ada) -->
                    <div class="pb-4">
                        <label for="region_id" class="block text-sm font-medium text-gray-700 mb-2">Wilayah Produk (Provinsi)</label>
                        @if(!empty($seller) && $seller->region_id)
                            <select id="region_id" disabled class="form-input bg-gray-100 border-gray-200 text-gray-600">
                                @foreach($regions as $r)
                                    <option value="{{ $r->id }}" @if($r->id == $seller->region_id) selected @endif>{{ $r->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="region_id" value="{{ $seller->region_id }}">
                        @else
                            <select id="region_id" name="region_id" required class="form-input text-gray-700 bg-gray-50 border-gray-300 focus:border-red-500">
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach($regions as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <!-- BAGIAN 1.5: Upload Foto Produk -->
                <h2 class="text-xl font-semibold text-gray-800 mb-4 mt-8">Foto Produk</h2>
                <div class="pb-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Foto (Maks. 5 Foto)</label>
                    <div id="photoPreview" class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-4">
                        <!-- Preview foto akan muncul di sini -->
                    </div>
                    <div id="dropzone" class="dropzone" onclick="document.getElementById('fileInput').click()">
                        <input type="file" id="fileInput" name="image" accept="image/*" class="hidden">
                        <!-- Upload Icon -->
                        <svg class="w-10 h-10 mx-auto text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <p class="text-sm font-medium text-gray-600">Seret & lepas foto di sini, atau klik untuk memilih file.</p>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Ukuran maks 2MB.</p>
                    </div>
                </div>

                <!-- BAGIAN 2: Harga -->
                <h2 class="text-xl font-semibold text-gray-800 mb-4 mt-8">Detail Harga</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-200">
                    <!-- Harga Rp (Ditambah atribut min="0") -->
                    <div class="md:col-span-1 pb-4">
                        <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-2">Harga Rp</label>
                        <input type="number" id="harga_jual" name="price" placeholder="angka" required class="form-input bg-gray-50 border-gray-300 focus:border-red-500" min="0">
                    </div>
                </div>

                <!-- Separator dan Tombol Show More (untuk memperjelas versi desktop) -->
                <div class="flex items-center justify-end mt-8">
                    <button type="button" onclick="toggleMoreFields()" class="text-sm font-medium text-red-500 hover:text-red-600 transition-colors">
                        <span id="toggleText">SHOW MORE</span>
                    </button>
                </div>

                <!-- BAGIAN 3: Detail Tambahan (Stok, Deskripsi) - Tersembunyi default -->
                <div id="moreFields" class="space-y-6 pt-6 hidden pb-6 border-b border-gray-200">
                    <!-- Pengaturan Stok Produk -->
                    <div class="pb-4">
                        <label for="stok_produk" class="block text-sm font-medium text-gray-700 mb-2">Pengaturan Stok Produk</label>
                        <select id="stok_produk" class="form-input text-gray-700 bg-gray-50 border-gray-300 focus:border-red-500">
                            <option value="tanpa_stok">Tanpa Stok</option>
                            <option value="dengan_stok">Atur Jumlah Stok (Manual)</option>
                        </select>
                    </div>
                    <!-- Field stok numeric (tersimpan ke DB) -->
                    <div class="pb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok (angka)</label>
                        <input type="number" id="stock" name="stock" value="0" min="0" class="form-input bg-gray-50 border-gray-300 focus:border-red-500">
                    </div>
                    <!-- Deskripsi Produk -->
                    <div class="pb-4">
                        <label for="deskripsi_produk" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea id="deskripsi_produk" name="description" rows="4" placeholder="Jelaskan produk Anda..." class="form-input resize-y bg-gray-50 border-gray-300 focus:border-red-500"></textarea>
                    </div>
                </div>

                <!-- Footer / Tombol Simpan -->
                <div class="flex justify-end mt-8 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex items-center px-8 py-3 bg-green-600 text-white font-semibold rounded-xl shadow-md hover:bg-green-700 transition-colors">
                        <!-- Simpan Icon -->
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        SIMPAN
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

            <script>
        // Array untuk menyimpan file foto yang diunggah
        let uploadedFiles = [];
        const MAX_FILES = 5;

        document.addEventListener('DOMContentLoaded', () => {
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.getElementById('fileInput');
            
            // Event Listener untuk input file (klik)
            fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

            // Event Listener untuk Drag and Drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => dropzone.classList.add('border-red-500', 'bg-red-200'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => dropzone.classList.remove('border-red-500', 'bg-red-200'), false);
            });

            dropzone.addEventListener('drop', handleDrop, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            // Convert FileList to array
            files = Array.from(files || []);
            // Only accept first file for now (backend stores single image)
            if (files.length > 1) files = [files[0]];
            files = files.filter(file => file.type.startsWith('image/') && file.size <= 2 * 1024 * 1024);

            if (files.length === 0) return;
            uploadedFiles = files;
            previewFile(files[0]);
            updateDropzoneVisibility();
        }

        function previewFile(file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function() {
                const previewContainer = document.getElementById('photoPreview');
                const imgContainer = document.createElement('div');
                imgContainer.className = 'relative group';
                imgContainer.dataset.filename = file.name;
                
                const img = document.createElement('img');
                img.src = reader.result;
                img.className = 'w-full h-24 object-cover rounded-lg border border-gray-200 shadow-sm';

                // Tombol Hapus
                const deleteButton = document.createElement('button');
                deleteButton.innerHTML = '&times;';
                deleteButton.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity';
                deleteButton.onclick = (e) => {
                    e.preventDefault();
                    removeFile(imgContainer.dataset.filename);
                };

                imgContainer.appendChild(img);
                imgContainer.appendChild(deleteButton);
                previewContainer.appendChild(imgContainer);
            }
        }

        function removeFile(fileName) {
            uploadedFiles = uploadedFiles.filter(file => file.name !== fileName);
            
            const elementToRemove = document.querySelector(`[data-filename="${fileName}"]`);
            if (elementToRemove) {
                elementToRemove.remove();
            }
            updateDropzoneVisibility();
        }

        function updateDropzoneVisibility() {
            const dropzone = document.getElementById('dropzone');
            if (uploadedFiles.length >= MAX_FILES) {
                dropzone.classList.add('hidden');
            } else {
                dropzone.classList.remove('hidden');
            }
        }

        // Fungsi untuk menampilkan notifikasi kustom
        function showNotification(message, className) {
            const main = document.querySelector('main');
            let notification = document.getElementById('temp-notification');
            
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'temp-notification';
                notification.className = 'px-4 py-3 rounded-xl mb-6 max-w-4xl mx-auto shadow-sm transition-opacity duration-300 fixed top-4 left-1/2 -translate-x-1/2 z-50';
                main.appendChild(notification);
            }

            notification.className = className + ' px-4 py-3 rounded-xl mb-6 max-w-4xl mx-auto shadow-sm transition-opacity duration-300 fixed top-4 left-1/2 -translate-x-1/2 z-50';
            notification.innerHTML = `
                <strong class="font-medium">Perhatian!</strong> ${message}
                <button onclick="this.parentElement.remove()" class="float-right font-bold text-lg leading-none ml-4">&times;</button>
            `;

            setTimeout(() => {
                if(notification.parentElement) notification.remove();
            }, 5000);
        }

        // Fungsi untuk toggle bagian detail tambahan
        function toggleMoreFields() {
            const fields = document.getElementById('moreFields');
            const toggleText = document.getElementById('toggleText');
            
            if (fields.classList.contains('hidden')) {
                fields.classList.remove('hidden');
                fields.classList.add('animate-fadeIn'); // Hanya untuk efek visual jika ada
                toggleText.textContent = 'SHOW LESS';
            } else {
                fields.classList.add('hidden');
                fields.classList.remove('animate-fadeIn');
                toggleText.textContent = 'SHOW MORE';
            }
        }

        // Fungsi Simulasi Simpan Produk
        // When the form is submitted normally the file input 'image' will be sent to server.
        // Keep the preview UX and client validation; actual saving is performed by the server.
    </script>
</body>
</html>