@extends('pages.pendings')

@section('pending-content')
    <h2 class="text-xl font-semibold mb-4">Pending Services</h2>
    <!-- List of pending services -->
    <div class="space-y-4">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="font-semibold">Service Name 1</h3>
            <p>Description of the pending service...</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="font-semibold">Service Name 2</h3>
            <p>Description of the pending service...</p>
        </div>
        <!-- Repeat as needed -->
    </div>
@endsection
