<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Shop')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-gray-800 flex flex-col min-h-screen" style="user-select: none;">
    <header class="bg-green-600 text-white p-4">
    <nav class="container mx-auto flex justify-between items-center">
        <div class="flex-1 flex justify-center space-x-6">
            <a href="{{ route('shop.home') }}" class="hover:text-gray-300">Home</a>
            <a href="{{ route('shop.products') }}" class="hover:text-gray-300">Products</a>
            <a href="{{ route('shop.cart') }}" class="hover:text-gray-300">Cart</a>
            <a href="{{ route('shop.orders') }}" class="hover:text-gray-300">Orders</a>
        </div>
        @if (Route::has('login'))
            <div class="flex justify-end space-x-3">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>


    </header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @include('products.partials.success-message') 
        </div>
    </div>

    <main class="container flex-grow mx-auto py-12">
        @yield('content')
    </main>
    <footer class="bg-green-600 text-white p-4 text-center">
        <p>© 2024 LimsLv Web Shop</p>
    </footer>

    <script src="{{ asset('js/ac.js') }}"></script> 
</body>
</html>
