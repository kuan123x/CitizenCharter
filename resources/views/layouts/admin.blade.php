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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="relative min-h-screen md:flex">
        <!-- Sidebar -->
        <aside class="z-10 bg-[#e7ecfe] text-black w-64 px-2 py-4 absolute inset-y-0 left-0 md:relative">
            <div class="flex items-center px-2 mb-4">
                <!-- Logo and Title -->
                <div class="flex items-center space-x-2 flex-1 mt-2">
                    <a href="">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                    <span class="text-lg font-bold mb-2">
                        Citizen's Charter
                    </span>
                </div>
            </div>

            <!-- Displaying Logged-in Username with Initial -->
            <div class="mt-4 flex justify-center items-center space-x-2">
                @if(Auth::check())
                    <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-xl">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                    <div class="text-gray-700 font-semibold">
                        {{ Auth::user()->username }}
                    </div>
                @endif
            </div>

            <!-- Navigation -->
            <nav class="mt-5 flex flex-col items-center space-y-3">
                <a href="{{ route('mvmsp') }}" class="block py-2.5 px-4 rounded text-center w-48 transition-colors duration-300 {{ request()->is('mvmsp') ? 'bg-[#9fb3fb] text-white' : 'bg-[#cfd9fd] hover:bg-[#9fb3fb]' }}">
                    MVMSP
                </a>
                <a href="{{ route('org-chart') }}" class="block py-2.5 px-4 rounded text-center w-48 transition-colors duration-300 {{ request()->is('org-chart') ? 'bg-[#9fb3fb] text-white' : 'bg-[#cfd9fd] hover:bg-[#9fb3fb]' }}">
                    ORG. CHART
                </a>
                <a href="{{ route('elected-officials') }}" class="block py-2.5 px-4 rounded text-center w-48 transition-colors duration-300 {{ request()->is('elected-officials') ? 'bg-[#9fb3fb] text-white' : 'bg-[#cfd9fd] hover:bg-[#9fb3fb]' }}">
                    ELECTED OFFICIALS
                </a>
                <a href="{{ route('offices') }}" class="block py-2.5 px-4 rounded text-center w-48 transition-colors duration-300 {{ request()->routeIs('offices') ? 'bg-[#9fb3fb] text-white' : 'bg-[#cfd9fd] hover:bg-[#9fb3fb]' }}">
                    OFFICES
                </a>
                <a href="{{ route('events.page') }}" class="block py-2.5 px-4 rounded text-center w-48 transition-colors duration-300 {{ request()->is('events') ? 'bg-[#9fb3fb] text-white' : 'bg-[#cfd9fd] hover:bg-[#9fb3fb]' }}">
                    EVENTS
                </a>

                @role('admin')
                <a href="{{ route('pendings') }}" class="block py-2.5 px-4 rounded @if(request()->routeIs('pendings') || request()->routeIs('pending.events') || request()->routeIs('pending.services')) bg-[#9fb3fb] text-white @else bg-[#cfd9fd] text-gray-600 @endif hover:bg-[#9fb3fb] transition-colors duration-300 text-center w-48">PENDINGS</a>
                @endrole
                <a href="{{ route('feedbacks.index') }}" class="block py-2.5 px-4 rounded text-center w-48 transition-colors duration-300 {{ request()->routeIs('feedbacks.index') ? 'bg-[#9fb3fb] text-white' : 'bg-[#cfd9fd] hover:bg-[#9fb3fb]' }}">
                    FEEDBACKS
                </a>

                <a href="/admin/users" class="block py-2.5 px-4 rounded text-center w-48 transition-colors duration-300 {{ request()->is('admin.users.index') ? 'bg-[#9fb3fb] text-white' : 'bg-[#cfd9fd] hover:bg-[#9fb3fb]' }}">
                    USERS
                </a>
            </nav>

            <a href="{{ route('notifications.index') }}" class="relative">
                <i class="fas fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count())
                    <span class="absolute top-0 right-0 bg-red-600 text-white rounded-full px-2 text-xs">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 bg-[#e7ecfe] m-6 p-6 rounded-lg shadow-md min-h-screen">
            <div>
                @yield('content')
            </div>
        </main>
    </div>

    <!-- JavaScript for Notifications Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('notifications-button');
            const dropdown = document.getElementById('notifications-dropdown');

            button.addEventListener('click', function() {
                dropdown.classList.toggle('hidden');
            });

            // Optional: Hide the dropdown when clicking outside of it
            document.addEventListener('click', function(event) {
                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
