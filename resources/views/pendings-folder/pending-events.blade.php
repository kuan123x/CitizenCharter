@extends('layouts.admin')

@section('pending-content')
    <h2 class="text-xl font-semibold mb-4">Pending Events</h2>

    <div class="space-y-4">
        @foreach($pendingEvents as $event)
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="font-semibold">{{ $event->title }}</h3>
                <p>{{ $event->description }}</p>

                <div class="mt-4 flex space-x-2">
                    <!-- Approve Button -->
                    <form action="{{ route('events.approve', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
