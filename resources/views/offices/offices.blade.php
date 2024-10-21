@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">
<<<<<<< HEAD:resources/views/pages/offices.blade.php
        <a href="#" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
=======
        <!-- Feedback Button -->
        <a href="{{ route('feedbacks') }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
>>>>>>> c1cfccb02e050b3385f806adf04ee3a10a0c7b9b:resources/views/offices/offices.blade.php
            Feedback
        </a>
        <h1 class="text-2xl font-bold text-center flex-1">List of Offices</h1>
        @role('admin')
            <button id="openAddOfficeModalButton" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Add Office
            </button>
        @endrole
    </div>

    <hr class="mb-6 border-2 border-gray-300">

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($offices as $office)
<<<<<<< HEAD:resources/views/pages/offices.blade.php
            <div class="block bg-[#ccd8fe] p-4 rounded-lg shadow-md hover:bg-[#bbc4fb] cursor-pointer" onclick="window.location='{{ route('offices.show', $office->id) }}'">
                <h2 class="text-xl font-semibold text-center">{{ $office->office_name }}</h2>
                {{-- <p class="text-xl font-semibold text-center">{{ $office->description }}</p> --}}
                <div class="flex justify-center space-x-2 mt-4">
                    <button class="bg-green-500 text-white py-1 px-2 rounded-lg hover:bg-green-600 edit-button" data-id="{{ $office->id }}" data-name="{{ $office->office_name }}" data-description="{{ $office->description }}">
                        Edit
                    </button>
                    <form action="{{ route('admin.offices.destroy', $office->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this office?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded-lg hover:bg-red-600" onclick="event.stopPropagation();">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
=======
            <a href="{{ route('offices.services', $office->id) }}" class="block bg-[#ccd8fe] p-4 rounded-lg shadow-md hover:bg-[#bbc4fb]">
                <h2 class="text-xl font-semibold text-center">{{ $office->office_name }}</h2> 
            </a>
>>>>>>> c1cfccb02e050b3385f806adf04ee3a10a0c7b9b:resources/views/offices/offices.blade.php
        @endforeach
    </div>

    @role('admin')
        <!-- Add Office Modal -->
        <div id="addOfficeModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg w-1/3 p-4">
                <h2 class="text-xl font-bold mb-4">Add New Office</h2>
                <form id="addOfficeForm" action="{{ route('admin.storeOffice') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="office_name" class="block text-sm font-medium">Office Name</label>
                        <input type="text" id="office_name" name="office_name" class="mt-1 p-2 block w-full border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium">Description</label>
                        <input type="text" id="description" name="description" class="mt-1 p-2 block w-full border rounded">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="closeAddOfficeModalButton" class="mr-2 bg-gray-300 text-black px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Office Modal -->
        <div id="editOfficeModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg w-1/3 p-4">
                <h2 class="text-xl font-bold mb-4">Edit Office</h2>
                <form id="editOfficeForm" action="{{ route('admin.offices.update', 'office_id') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_office_id" name="office_id">
                    <div class="mb-4">
                        <label for="edit_office_name" class="block text-sm font-medium">Office Name</label>
                        <input type="text" id="edit_office_name" name="office_name" class="mt-1 p-2 block w-full border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_description" class="block text-sm font-medium">Description</label>
                        <input type="text" id="edit_description" name="description" class="mt-1 p-2 block w-full border rounded">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="closeEditOfficeModalButton" class="mr-2 bg-gray-300 text-black px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endrole

    <script>
        document.getElementById('openAddOfficeModalButton').addEventListener('click', function () {
            document.getElementById('addOfficeForm').reset();
            document.getElementById('addOfficeModal').classList.remove('hidden');
        });

        document.getElementById('closeAddOfficeModalButton').addEventListener('click', function () {
            document.getElementById('addOfficeModal').classList.add('hidden');
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent card click
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const description = this.getAttribute('data-description');

                document.getElementById('edit_office_id').value = id;
                document.getElementById('edit_office_name').value = name;
                document.getElementById('edit_description').value = description;

                // Update the form action dynamically
                document.getElementById('editOfficeForm').action = `/admin/offices/${id}`;

                document.getElementById('editOfficeModal').classList.remove('hidden');
            });
        });

        document.getElementById('closeEditOfficeModalButton').addEventListener('click', function () {
            document.getElementById('editOfficeModal').classList.add('hidden');
        });
    </script>
@endsection
