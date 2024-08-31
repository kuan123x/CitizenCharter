@extends('layouts.admin')

@section('content')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-4">
        <!-- Back Button -->
        <a href="{{ route('offices') }}" class="bg-gray-300 text-black py-2 px-4 rounded-lg hover:bg-gray-400">
            ← Back
        </a>

        <!-- Office Name + Services Title -->
        <h1 class="text-2xl font-bold text-center flex-1">
            {{ $office->office_name }} Services
        </h1>

        <!-- Add Service Button (Visible only to Admin or Head) -->
        @role('admin|head')
            <button id="openAddServiceModalButton" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Add Service
            </button>
        @endrole
    </div>

    <hr class="mb-6 border-2 border-gray-300">

    <!-- Services List -->
    <div>
        <div id="servicesList" class="grid grid-cols-1 gap-6">
            @foreach($services as $service)
                <a href="{{ route('services.show', $service->id) }}" class="bg-white shadow-md rounded-lg p-8 border border-gray-200 max-w-6xl mx-auto block hover:shadow-lg transition-shadow duration-300 ease-in-out">
                    <h3 class="text-lg font-semibold mb-2">{{ $service->service_name }}</h3>
                    <p class="text-gray-700 mb-4">{{ $service->description }}</p>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Add Service Modal -->
    @role('admin|head')
        <div id="addServiceModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg w-1/3 p-4">
                <h2 class="text-xl font-bold mb-4">Add New Service</h2>
                <form id="addServiceForm" action="{{ route('services.storeService', $office->id) }}" method="POST">
                    @csrf
                    <div>
                        <label for="service_name">Service Name:</label>
                        <input type="text" name="service_name" id="service_name" required class="border rounded-lg p-2 w-full">
                    </div>

                    <div class="mt-4">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="border rounded-lg p-2 w-full"></textarea>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 mt-4">Add Service</button>
                </form>
                <!-- Close Modal Button -->
                <button id="closeServiceModalButton" class="mt-4 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                    Close
                </button>
            </div>
        </div>
    @endrole

    <script>
        document.getElementById('openAddServiceModalButton').addEventListener('click', function () {
            document.getElementById('addServiceForm').reset();
            document.getElementById('addServiceModal').classList.remove('hidden');
        });

        document.getElementById('closeServiceModalButton').addEventListener('click', function () {
            document.getElementById('addServiceModal').classList.add('hidden');
        });

        document.getElementById('addServiceForm').addEventListener('submit', function (event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Append the new service to the services list
                    let serviceList = document.getElementById('servicesList');
                    let newService = document.createElement('a');
                    newService.href = data.service.url; // Assuming you return a URL in the response
                    newService.className = 'bg-white shadow-md rounded-lg p-8 border border-gray-200 max-w-6xl mx-auto block hover:shadow-lg transition-shadow duration-300 ease-in-out';
                    newService.innerHTML = `
                        <h3 class="text-lg font-semibold mb-2">${data.service.service_name}</h3>
                        <p class="text-gray-700 mb-4">${data.service.description}</p>
                    `;
                    serviceList.appendChild(newService);

                    // Close the modal
                    document.getElementById('addServiceModal').classList.add('hidden');
                } else {
                    // Handle errors here
                    alert('Failed to add service. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    </script>
@endsection
