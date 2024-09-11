@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Create New Event</h1>

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium">Event Title</label>
            <input type="text" id="title" name="title" class="mt-1 block w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Event Description</label>
            <textarea id="description" name="description" class="mt-1 block w-full p-2 border rounded" rows="4" required></textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium">Event Image (optional)</label>
            <input type="file" id="image" name="image" class="mt-1 block w-full p-2 border rounded">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create Event</button>
        </div>
    </form>
@endsection
