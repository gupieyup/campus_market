@extends('layouts.app')

@section('content')
<div class="bg-pink-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="md:flex">
                <!-- Product Image Gallery -->
                <div class="md:w-1/2">
                    <div class="p-4">
                        <img id="mainImage" src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg">
                    </div>
                    <div class="flex space-x-2 p-4">
                        <!-- Placeholder for thumbnails -->
                        <img src="{{ $product->image }}" class="w-20 h-20 object-cover rounded-md cursor-pointer border-2 border-pink-500">
                        <img src="{{ $product->image }}" class="w-20 h-20 object-cover rounded-md cursor-pointer">
                        <img src="{{ $product->image }}" class="w-20 h-20 object-cover rounded-md cursor-pointer">
                        <img src="{{ $product->image }}" class="w-20 h-20 object-cover rounded-md cursor-pointer">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="md:w-1/2 p-8">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    <div class="flex items-center mt-2">
                        <div class="flex items-center text-yellow-400">
                            <!-- Star rating -->
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.445a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.539 1.118l-3.367-2.445a1 1 0 00-1.175 0l-3.367 2.445c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.05 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"></path></svg>
                            <!-- ... more stars ... -->
                        </div>
                        <span class="text-gray-600 ml-2">4.9 (234 ratings)</span>
                        <span class="mx-2">|</span>
                        <span class="text-gray-600">500+ Sold</span>
                    </div>
                    <p class="text-4xl font-extrabold text-pink-600 mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    <form action="{{ route('cart.store') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center">
                            <label for="quantity" class="mr-4">Quantity</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-20 border border-gray-300 rounded-md text-center">
                        </div>
                        
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-pink-500 text-white py-3 px-6 rounded-lg shadow-md hover:bg-pink-600 transition duration-300">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Description -->
            <div class="p-8 border-t">
                <h2 class="text-2xl font-bold">Product Description</h2>
                <p class="mt-4 text-gray-700">
                    {{ $product->description }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
