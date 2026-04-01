<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="flex min-h-screen">

    <!-- 🔵 Sidebar -->
    <div class="w-64 bg-gray-800 text-white flex flex-col">

        <div class="p-4 text-lg font-bold border-b border-gray-700">
            🏨 Hotel System
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <a href="{{ url('/dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                Dashboard
            </a>

            <a href="{{ url('/rooms') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('rooms.*') ? 'bg-gray-700' : '' }}">
                Rooms
            </a>

            <a href="{{ url('/bookings') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('bookings.*') ? 'bg-gray-700' : '' }}">
                Bookings
            </a>

        </nav>

        <!-- 🔴 Logout -->
        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-3 py-2 rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- 🟢 Main Content -->
    <div class="flex-1 bg-gray-100">

        <!-- Header -->
        <header class="bg-white shadow p-4">
            {{ $header ?? '' }}
        </header>

        <!-- Page Content -->
        <main class="p-6">
            {{ $slot }}
        </main>

    </div>

</div>
</body>
</html>
