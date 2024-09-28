@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold text-center mb-6">EVENTS</h1>

    <!-- Success or Error Messages -->
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add Event Button to Open Modal -->
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('head'))
        <div class="flex justify-end mb-6">
            <button class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" id="openModal">
                Add Event
            </button>
        </div>
    @endif

    <h2 class="text-xl font-semibold mb-4">Events for you</h2>

    <!-- Event Modal for Creating -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center" id="eventModal">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-xl font-bold mb-4">Create New Event</h2>
            <form action="{{ route('events.store') }}" method="POST">
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
                    <label for="image" class="block text-sm font-medium">Event Image URL</label>
                    <input type="url" id="image" name="image" class="mt-1 block w-full p-2 border rounded" placeholder="Paste image URL here" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                        Create Event
                    </button>
                    <button type="button" class="ml-2 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600" id="closeModal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center" id="editEventModal">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-xl font-bold mb-4">Edit Event</h2>
            <form id="editEventForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="editTitle" class="block text-sm font-medium">Event Title</label>
                    <input type="text" id="editTitle" name="title" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-medium">Event Description</label>
                    <textarea id="editDescription" name="description" class="mt-1 block w-full p-2 border rounded" rows="4" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="editImage" class="block text-sm font-medium">Event Image URL</label>
                    <input type="url" id="editImage" name="image" class="mt-1 block w-full p-2 border rounded" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Save changes
                    </button>
                    <button type="button" class="ml-2 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600" id="closeEditModal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Events Grid Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
        @foreach($approvedEvents as $event)
            <div class="border-2 border-[#9fb3fb] p-4 bg-white shadow-md rounded-lg overflow-hidden cursor-pointer">
                <img src="{{ $event->image }}" alt="Event Image" class="w-full h-32 sm:h-48 object-cover mb-4">
                <div class="p-4">
                    <h2 class="text-lg font-semibold mb-2">{{ $event->title }}</h2>
                    <p class="text-sm text-gray-700">{{ Str::limit($event->description, 80) }}</p>
                </div>
                <div class="flex justify-center space-x-2 mt-2">
                    <button class="bg-green-500 text-white py-1 px-2 rounded-lg hover:bg-green-600 edit-button" data-id="{{ $event->id }}" data-title="{{ $event->title }}" data-description="{{ $event->description }}" data-image="{{ $event->image }}">
                        Edit
                    </button>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded-lg hover:bg-red-600" onclick="event.stopPropagation();">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Script -->
    <script>
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');
        const closeEditModalButton = document.getElementById('closeEditModal');
        const modal = document.getElementById('eventModal');
        const editModal = document.getElementById('editEventModal');
        const editEventForm = document.getElementById('editEventForm');

        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        closeEditModalButton.addEventListener('click', () => {
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent triggering the card click event
                const id = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');
                const description = button.getAttribute('data-description');
                const image = button.getAttribute('data-image');

                document.getElementById('editTitle').value = title;
                document.getElementById('editDescription').value = description;
                document.getElementById('editImage').value = image;

                // Update form action
                editEventForm.action = `/events/${id}`;

                editModal.classList.remove('hidden');
                editModal.classList.add('flex');
            });
        });

        // Close modals when clicking outside
        [modal, editModal].forEach(modalElement => {
            modalElement.addEventListener('click', (e) => {
                if (e.target === modalElement) {
                    modalElement.classList.add('hidden');
                    modalElement.classList.remove('flex');
                }
            });
        });
    </script>
@endsection
