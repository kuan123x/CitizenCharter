@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold text-center mb-6">Events</h1>

    {{-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
        @foreach($approvedEvents as $event)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" class="w-full h-32 sm:h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-lg font-semibold">{{ $event->title }}</h2>
                    <p>{{ $event->description }}</p>
                </div>
            </div>
        @endforeach
    </div> --}}
@endsection
