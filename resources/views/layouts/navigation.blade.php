<nav x-data="{ open: false }" class="bg-white border-r border-gray-100 h-screen fixed w-72">
    <!-- Sidebar Navigation Menu -->
    <div class="h-full flex flex-col justify-between">
        <div class="px-4 py-6">
            <!-- Logo -->
            <div class="shrink-0 flex items-center mb-8">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="space-y-4">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 rounded-md">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <!-- Add more links as needed -->
            </div>
        </div>

        <!-- Settings Dropdown -->
        <div class="px-4 py-6 border-t border-gray-200">
            <x-dropdown align="right" width="full">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-4 py-2 w-full border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1 ml-auto">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="ml-72 p-6">
    <!-- Your main content goes here -->
</div>
