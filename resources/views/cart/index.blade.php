@extends('layouts.app')

@extends('layouts.app')

@section('content')
<div class="bg-pink-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-center mb-8">Shopping Cart</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($cartItems->count() > 0)
            <div class="bg-white shadow-lg rounded-lg">
                <div class="p-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3">Product</th>
                                <th class="text-left py-3">Price</th>
                                <th class="text-left py-3">Qty</th>
                                <th class="text-left py-3">Subtotal</th>
                                <th class="text-right py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($cartItems as $item)
                                @php $total += $item->product->price * $item->quantity; @endphp
                                <tr class="border-b">
                                    <td class="py-4 flex items-center">
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-md mr-4">
                                        <div>
                                            <p class="font-semibold">{{ $item->product->name }}</p>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <input type="number" value="{{ $item->quantity }}" min="1" class="w-16 text-center border rounded">
                                    </td>
                                    <td>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                    <td class="text-right">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-gray-50 rounded-b-lg flex justify-end">
                    <div class="text-right">
                        <p class="text-xl font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
                        <a href="{{ route('checkout') }}" class="mt-4 inline-block bg-pink-500 text-white py-3 px-8 rounded-lg shadow-md hover:bg-pink-600 transition duration-300">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center bg-white shadow-lg rounded-lg p-12">
                <h2 class="text-2xl font-semibold">Your Cart is Empty</h2>
                <a href="{{ route('products.index') }}" class="mt-6 inline-block bg-pink-500 text-white py-2 px-6 rounded-lg hover:bg-pink-600">Shop Now</a>
            </div>
        @endif
    </div>
</div>
@endsection
