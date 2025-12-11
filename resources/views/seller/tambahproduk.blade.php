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

        /* Style untuk input form (JAMINAN BERKOTAK DAN BERSHADOW) */
        .form-input {
            /* w-full menjamin lebar penuh, border dan shadow menjamin kejelasan kotak */
            @apply w-full px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium focus:ring-red-500 focus:border-red-500 transition-colors shadow-sm; 
        }

        /* Style untuk kotak dropzone */
        .dropzone {
            /* Styling lebih tegas */
            @apply border-2 border-dashed border-red-400 bg-red-50 rounded-xl p-6 text-center cursor-pointer transition-colors hover:border-red-600 hover:bg-red-100;
        }

        /* Tambahkan style untuk preview foto */
        .photo-preview-item {
            @apply relative w-full h-24 p-1 rounded-xl bg-white shadow-md border border-gray-200 overflow-hidden;
        }
        
        .photo-preview-item img {
            @apply w-full h-full object-cover rounded-lg;
        }
        
        .delete-btn {
            @apply absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700 shadow-md;
        }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">

<div class="flex h-screen overflow-hidden">
    @include('seller.layouts.sidebar', ['activeMenu' => 'tambahproduk'])
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
        <div class="flex flex-col items-center mb-8 border-b border-red-200 pb-4">
            <h1 class="text-3xl font-extrabold text-gray-800 w-full text-center">TAMBAH PRODUK</h1>
            <button onclick="history.back()" class="flex items-center text-red-600 font-medium hover:text-red-700 transition-colors mt-2">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Produk
            </button>
        </div>

        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-red-200 p-6 md:p-10">
            <form id="productForm" method="POST" action="{{ route('seller.produk.store') }}" enctype="multipart/form-data">
                @csrf
                
                <h2 class="text-xl font-bold text-red-600 mb-4 pb-2 border-b-2 border-red-100">Informasi Produk</h2>
                <div class="space-y-6 pb-6 mb-6 border-b border-gray-200">
                    
                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">Kategori Produk <span class="text-red-500">*</span></label>
                        {{-- LEBAR PENUH --}}
                        <select id="kategori" name="category_id" required class="form-input border-2 rounded-2xl bg-gray-50 text-gray-700 focus:border-red-500 focus:ring-red-500">
                            <option value="" disabled selected>Silahkan Pilih</option>
                            <option value="1">Makanan & Minuman</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        {{-- LEBAR PENUH --}}
                        <input type="text" id="nama_produk" name="name" placeholder="Masukkan nama produk" required class="form-input border-2 rounded-2xl bg-gray-50 text-gray-700 focus:border-red-500 focus:ring-red-500">
                    </div>
                    
                    <div>
                        <label for="region_id" class="block text-sm font-semibold text-gray-700 mb-2">Wilayah Produk (Provinsi) <span class="text-red-500">*</span></label>
                        @if(!empty($seller) && $seller->region_id)
                            {{-- LEBAR PENUH --}}
                            <select id="region_id" disabled class="form-input border-2 rounded-2xl bg-gray-100 text-gray-600">
                                <option value="1" selected>Jawa Tengah</option>
                            </select>
                            <input type="hidden" name="region_id" value="{{ $seller->region_id }}">
                            <p class="text-xs text-gray-500 mt-1">Provinsi mengikuti pengaturan Toko Anda dan tidak dapat diubah.</p>
                        @else
                            {{-- LEBAR PENUH --}}
                            <select id="region_id" name="region_id" required class="form-input border-2 rounded-2xl bg-gray-50 text-gray-700 focus:border-red-500 focus:ring-red-500">
                                <option value="" disabled selected>Pilih Provinsi</option>
                                <option value="1">Jawa Tengah</option>
                                <option value="2">DKI Jakarta</option>
                            </select>
                        @endif
                    </div>
                </div>

                <h2 class="text-xl font-bold text-red-600 mb-4 mt-8 pb-2 border-b-2 border-red-100">Foto Produk</h2>
                <div class="space-y-4 pb-6 mb-6 border-b border-gray-200">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Unggah Foto (Maks. 5 Foto) <span class="text-red-500">*</span></label>
                    
                    <div id="photoPreview" class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    </div>
                    
                    {{-- Dropzone ini sudah W-FULL --}}
                    <div id="dropzone" class="dropzone" onclick="document.getElementById('fileInput').click()">
                        <input type="file" id="fileInput" name="images[]" accept="image/*" class="hidden" multiple>
                        <div class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-red-400 rounded-2xl bg-red-50 hover:bg-red-100 transition-all cursor-pointer">
                            <svg class="w-10 h-10 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <p class="text-sm font-medium text-gray-700">Seret & lepas foto di sini, atau klik untuk memilih file.</p>
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Ukuran maks 2MB per foto.</p>
                        </div>
                    </div>
                    <p id="fileError" class="text-xs text-red-600 font-semibold hidden">Maksimal 5 foto telah tercapai atau ukuran file terlalu besar.</p>
                </div>

                <h2 class="text-xl font-bold text-red-600 mb-4 mt-8 pb-2 border-b-2 border-red-100">Detail Harga</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 mb-6 border-b border-gray-200">
                    <div class="md:col-span-1">
                        <label for="harga_jual" class="block text-sm font-semibold text-gray-700 mb-2">Harga Rp <span class="text-red-500">*</span></label>
                        {{-- LEBAR PENUH --}}
                        <input type="number" id="harga_jual" name="price" placeholder="angka" required class="form-input bg-white focus:border-red-500" min="0">
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <!-- Tombol SHOW MORE/LESS dihapus, langsung ke bagian bawah -->
                </div>

                <div id="moreFields" class="space-y-6 pt-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-2 border-b border-red-100 pb-2">Detail Tambahan (Opsional)</h3>
                    <div>
                        <label for="stok_produk" class="block text-sm font-semibold text-gray-700 mb-2">Pengaturan Stok Produk</label>
                        <select id="stok_produk" class="form-input border-2 rounded-2xl bg-gray-50 text-gray-700 focus:border-red-500 focus:ring-red-500">
                            <option value="tanpa_stok">Tanpa Stok (Tidak Terbatas)</option>
                            <option value="dengan_stok">Atur Jumlah Stok (Manual)</option>
                        </select>
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Stok (angka)</label>
                        <input type="number" id="stock" name="stock" value="0" min="0" class="form-input border-2 rounded-2xl bg-gray-50 text-gray-700 focus:border-red-500 focus:ring-red-500">
                    </div>
                    <div>
                        <label for="deskripsi_produk" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea id="deskripsi_produk" name="description" rows="7" style="min-height:140px; width:100%; max-width:100%;" placeholder="Jelaskan detail produk Anda secara rinci..." class="form-input border-2 rounded-2xl bg-gray-50 text-gray-700 p-3 resize-y focus:border-red-500"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end mt-8 pt-6 border-t border-red-200">
                    <button type="submit" class="flex items-center px-8 py-3 bg-red-600 text-white font-bold text-lg rounded-xl shadow-lg hover:bg-red-700 transition-colors">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        SIMPAN PRODUK
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    // ... (Fungsi JavaScript yang tidak diubah) ...
    let uploadedFiles = [];
    const MAX_FILES = 5;
    const MAX_SIZE_MB = 2;
    const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;

    document.addEventListener('DOMContentLoaded', () => {
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.add('border-red-600', 'bg-red-200'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.remove('border-red-600', 'bg-red-200'), false);
        });

        dropzone.addEventListener('drop', handleDrop, false);

        document.getElementById('productForm').addEventListener('submit', attachFilesToForm);
        fileInput.addEventListener('change', (e) => handleFiles(e.target.files));
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
        files = Array.from(files || []);
        let filesAdded = 0;
        let largeFileDetected = false;
        
        files.forEach(file => {
            if (uploadedFiles.length < MAX_FILES) {
                if (file.type.startsWith('image/') && file.size <= MAX_SIZE_BYTES) {
                    uploadedFiles.push(file);
                    previewFile(file);
                    filesAdded++;
                } else if (file.size > MAX_SIZE_BYTES) {
                    largeFileDetected = true;
                }
            }
        });

        if (uploadedFiles.length >= MAX_FILES || largeFileDetected) {
            showNotification(`Maksimal ${MAX_FILES} foto telah tercapai. Ukuran maksimum per foto adalah ${MAX_SIZE_MB}MB.`, 'bg-red-100 text-red-800');
        }

        updateDropzoneVisibility();
        document.getElementById('fileInput').value = null; 
    }

    function previewFile(file) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = function() {
            const previewContainer = document.getElementById('photoPreview');
            const imgContainer = document.createElement('div');
            imgContainer.className = 'photo-preview-item group';
            imgContainer.dataset.identifier = file.name + file.lastModified;
            
            const img = document.createElement('img');
            img.src = reader.result;
            
            const deleteButton = document.createElement('button');
            deleteButton.innerHTML = '&times;';
            deleteButton.className = 'delete-btn';
            deleteButton.type = 'button'; 
            deleteButton.onclick = (e) => {
                e.preventDefault();
                removeFile(imgContainer.dataset.identifier);
            };

            imgContainer.appendChild(img);
            imgContainer.appendChild(deleteButton);
            previewContainer.appendChild(imgContainer);
        }
    }

    function removeFile(identifier) {
        uploadedFiles = uploadedFiles.filter(file => (file.name + file.lastModified) !== identifier);
        
        const elementToRemove = document.querySelector(`[data-identifier="${identifier}"]`);
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
    
    function attachFilesToForm(e) {
        if (uploadedFiles.length === 0) {
            e.preventDefault();
            showNotification('Anda harus mengunggah minimal satu Foto Produk.', 'bg-yellow-100 text-yellow-800');
            return;
        }

        const form = e.target;
        
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        const oldInput = form.querySelector('input[name="images[]"]');
        if (oldInput) oldInput.remove();

        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'images[]';
        newInput.multiple = true;
        newInput.files = dataTransfer.files;
        newInput.classList.add('hidden');
        
        form.appendChild(newInput);
    }

    function showNotification(message, className) {
        const body = document.querySelector('body');
        let notification = document.getElementById('temp-notification');
        
        if (!notification) {
            notification = document.createElement('div');
            notification.id = 'temp-notification';
            notification.className = 'px-4 py-3 rounded-xl mb-6 max-w-lg mx-auto shadow-lg transition-opacity duration-300 fixed top-6 left-1/2 -translate-x-1/2 z-[100] opacity-0';
            body.appendChild(notification);
        }

        notification.className = className + ' px-4 py-3 rounded-xl mb-6 max-w-lg mx-auto shadow-lg transition-opacity duration-300 fixed top-6 left-1/2 -translate-x-1/2 z-[100]';
        notification.innerHTML = `
            <strong class="font-medium">Perhatian!</strong> ${message}
            <button type="button" onclick="this.parentElement.remove()" class="float-right font-bold text-xl leading-none ml-4 opacity-70 hover:opacity-100 transition-opacity">&times;</button>
        `;

        setTimeout(() => {
             notification.style.opacity = 1;
        }, 10);

        setTimeout(() => {
             if(notification.parentElement) notification.style.opacity = 0;
        }, 4500);
        setTimeout(() => {
             if(notification.parentElement && notification.style.opacity == 0) notification.remove();
        }, 5000);
    }

    function toggleMoreFields() {
        const fields = document.getElementById('moreFields');
        const toggleText = document.getElementById('toggleText');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (fields.classList.contains('hidden')) {
            fields.classList.remove('hidden');
            toggleText.textContent = 'SHOW LESS';
            toggleIcon.classList.add('rotate-180');
        } else {
            fields.classList.add('hidden');
            toggleText.textContent = 'SHOW MORE';
            toggleIcon.classList.remove('rotate-180');
        }
    }
</script>
</body>
</html>