@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Our Products</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <a href="{{ route('products.show', $product->id) }}">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                </a>
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                    <p class="text-gray-600 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div class="mt-4">
                        <a href="{{ route('products.show', $product->id) }}" class="w-full text-center bg-pink-400 text-white py-2 px-4 rounded-md hover:bg-pink-500">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
