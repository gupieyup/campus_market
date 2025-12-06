<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .form-input { @apply w-full px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium; }
    </style>
</head>
<body class="bg-red-50">
<div class="flex h-screen overflow-hidden">
    @include('seller.layouts.sidebar', ['activeMenu' => 'produk'])
    <main class="flex-1 p-6 md:p-8">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

            <form method="POST" action="{{ route('seller.produk.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium">Kategori</label>
                    <select name="category_id" class="form-input" required>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @if($product->category_id == $c->id) selected @endif>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Nama Produk</label>
                    <input type="text" name="name" value="{{ $product->name }}" required class="form-input">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Harga</label>
                    <input type="number" name="price" value="{{ $product->price }}" min="0" required class="form-input">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Stok</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" min="0" class="form-input">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-input">{{ $product->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Foto (unggah untuk mengganti)</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ $product->image ?? '/images/products/default.png' }}" class="w-28 h-28 object-cover rounded">
                        <input type="file" name="image" accept="image/*">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('seller.produk') }}" class="px-4 py-2 rounded bg-gray-100">Batal</a>
                    <button type="submit" class="px-6 py-2 rounded bg-green-600 text-white">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
