@extends('layouts.admin')

@section('content')
    <div class=" p-6 rounded-lg ">
        <!-- Navbar for pending requests -->
        <div class="flex space-x-4 ">
            <!-- Navigation for pending categories -->
            <a href="{{ route('pending.offices') }}" class="px-4 py-2 rounded-t-lg @if(request()->routeIs('pending.offices')) bg-[#9fb3fb] text-black @else  text-gray-600 @endif">Offices</a>

            <a href="{{ route('pending.services') }}" class="px-4 py-2 rounded-t-lg @if(request()->routeIs('pending.services')) bg-[#9fb3fb] text-black @else  text-gray-600 @endif">Services</a>
            {{-- <a href="{{ route('pending.events') }}" class="px-4 py-2 rounded-t-lg @if(request()->routeIs('pending.events')) bg-[#9fb3fb] text-white @else bg-[#eef2fe] text-gray-600 @endif">Events</a> --}}
        </div>

        <!-- Content for pending requests -->
        <div class="bg-[#9fb3fb] p-6 ">
            <!-- Placeholder for the specific content based on the selected tab -->
            @yield('pending-content')
        </div>
    </div>
@endsection
