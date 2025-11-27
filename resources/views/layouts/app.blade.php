<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'CampusMarket')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow" style="background-color: #FFEBEE;">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <a href="/" class="text-lg font-semibold text-gray-800">CampusMarket</a>
                    </div>
                    <div class="flex items-center">
                        <div class="relative">
                            <input type="text" class="border rounded-md py-1 px-3" placeholder="Search Products...">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                        <a href="{{ route('cart.index') }}" class="ml-4 text-gray-600 hover:text-gray-800">
                            <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('profile') }}" class="ml-4 text-gray-600 hover:text-gray-800">
                            Profile Account
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <footer class="bg-gray-200" style="background-color: #E0E0E0;">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold">CampusMarket</h3>
                    </div>
                    <div>
                        <h4 class="font-semibold">Account</h4>
                        <ul class="mt-2 space-y-1">
                            <li><a href="#" class="text-gray-600">Cart</a></li>
                            <li><a href="#" class="text-gray-600">My Order</a></li>
                            <li><a href="#" class="text-gray-600">Shipping Details</a></li>
                            <li><a href="#" class="text-gray-600">Bookmark</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold">Useful Link</h4>
                        <ul class="mt-2 space-y-1">
                            <li><a href="#" class="text-gray-600">About Us</a></li>
                            <li><a href="#" class="text-gray-600">FAQ</a></li>
                            <li><a href="#" class="text-gray-600">Promotions</a></li>
                            <li><a href="#" class="text-gray-600">New Products</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
