@extends('pages.pendings')

@section('pending-content')
    <h2 class="text-3xl font-bold text-center mb-6">Pending Events</h2>

    <div class="space-y-6">
        @foreach($pendingEvents as $event)
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <!-- Event Image (fit without cropping) -->
                <img src="{{ $event->image }}" alt="Event Image" class="w-full h-48 object-contain rounded-t-lg mb-6">

                <!-- Event Title and Description -->
                <div class="text-center">
                    <h3 class="text-2xl font-semibold mb-2">{{ $event->title }}</h3>
                    <p class="text-gray-700 mb-4">{{ $event->description }}</p>
                </div>

                <!-- Approve/Reject Buttons -->
                <div class="flex justify-center space-x-4">
                    <!-- Approve Button -->
                    <form action="{{ route('events.approve', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-green-600">
                            Approve
                        </button>
                    </form>

                    <!-- Reject Button -->
                    <form action="{{ route('events.reject', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white font-semibold px-6 py-2 rounded-full hover:bg-red-600">
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
