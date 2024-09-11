{{-- @extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-4">>
        @role('admin')
        <a href="{{ route('offices') }}" class="bg-gray-300 text-black py-2 px-4 rounded-lg hover:bg-gray-400">
            ← Back
        </a>
        @endrole
        <h1 class="text-2xl font-bold text-center flex-1">
            {{ $office->office_name }} Services
        </h1>

        @role('admin|head')
            <button id="openAddServiceModalButton" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Add Service
            </button>
        @endrole
    </div>

    <hr class="mb-6 border-2 border-gray-300">

    <div>
        <div id="servicesList" class="grid grid-cols-1 gap-6">
            @foreach($services as $service)
                <a href="{{ route('services.details', $service->id) }}" class="bg-white shadow-md rounded-lg p-8 border border-gray-200 mx-auto block hover:shadow-lg transition-shadow duration-300 ease-in-out" style="width: 100%;">
                    <h3 class="text-lg font-semibold mb-2">{{ $service->service_name }}</h3>
                    <p class="text-gray-700 mb-4">{{ $service->description }}</p>
                </a>
            @endforeach
        </div>
    </div>

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
                    let serviceList = document.getElementById('servicesList');
                    let newService = document.createElement('a');
                    newService.href = data.service.url;
                    newService.className = 'bg-white shadow-md rounded-lg p-8 border border-gray-200 max-w-6xl mx-auto block hover:shadow-lg transition-shadow duration-300 ease-in-out';
                    newService.innerHTML = `
                        <h3 class="text-lg font-semibold mb-2">${data.service.service_name}</h3>
                        <p class="text-gray-700 mb-4">${data.service.description}</p>
                    `;
                    serviceList.appendChild(newService);

                    document.getElementById('addServiceModal').classList.add('hidden');
                } else {
                    alert('Failed to add service. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    </script>
@endsection --}}
@extends('layouts.admin')

@section('content')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-4">
        <!-- Back Button -->
        @role('admin')
        <a href="{{ route('offices') }}" class="bg-gray-300 text-black py-2 px-4 rounded-lg hover:bg-gray-400">
            ← Back
        </a>
        @endrole

        <!-- Office Name + Services Title -->
        <h1 class="text-2xl font-bold text-center flex-1">
            {{ $office->office_name }} Services
        </h1>

        <!-- Add Service Button (Visible only to Admin or Head) -->
        @role('admin|head')
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600"
                    onclick="document.getElementById('addServiceModal').style.display='flex'">
                Add Service
            </button>
        @endrole
    </div>

    <hr class="mb-6 border-2 border-gray-300">

    <!-- Services List -->
    <div>
        <div id="servicesList" class="grid grid-cols-1 gap-6">
            @foreach($services as $service)
            @if($service->status == 'approved')
                <a href="{{ route('services.details', $service->id) }}" class="bg-white shadow-md rounded-lg p-8 border border-gray-200 mx-auto block hover:shadow-lg transition-shadow duration-300 ease-in-out" style="width: 100%;">
                    <h3 class="text-lg font-semibold mb-2">{{ $service->service_name }}</h3>
                    <p class="text-gray-700 mb-4">{{ $service->description }}</p>
                </a>
            @endif
        @endforeach

        </div>
    </div>

    <!-- Add Service Modal -->
   <!-- Add Service Modal -->
@role('admin|head')
<div id="addServiceModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg w-1/3 p-6">
        <h2 class="text-xl font-bold mb-4">Add New Service</h2>

        <!-- Laravel Form to Add Service -->
        <form action="{{ route('services.storeService', $office->id) }}" method="POST">
            @csrf
            <div>
                <label for="service_name">Service Name:</label>
                <input type="text" name="service_name" id="service_name" required class="border rounded-lg p-2 w-full">
            </div>

            <div class="mt-4">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="border rounded-lg p-2 w-full"></textarea>
            </div>

            <div class="mt-4">
                <label for="classification">Classification:</label>
                <select name="classification" id="classification" required class="border rounded-lg p-2 w-full">
                    <option value="SIMPLE">SIMPLE</option>
                    <option value="COMPLEX">COMPLEX</option>
                    <option value="SIMPLE - COMPLEX">SIMPLE - COMPLEX</option>
                    <option value="HIGHLY TECHNICAL">HIGHLY TECHNICAL</option>
                </select>
            </div>

        <!-- Transaction Dropdown -->
<div class="mt-4">
    <label for="transaction_id">Type of Transaction:</label>
    <select name="transaction_id" id="transaction_id" required class="border rounded-lg p-2 w-full">
        @foreach($transactions as $transaction)
            <option value="{{ $transaction->id }}">{{ $transaction->type_of_transaction }}</option>
        @endforeach
    </select>
</div>



            <div class="mt-4">
                <label for="checklist_of_requirements">Checklist of Requirements:</label>
                <textarea name="checklist_of_requirements" id="checklist_of_requirements" class="border rounded-lg p-2 w-full"></textarea>
            </div>

            <div class="mt-4">
                <label for="where_to_secure">Where to Secure:</label>
                <textarea name="where_to_secure" id="where_to_secure" class="border rounded-lg p-2 w-full"></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 mt-4">Add Service</button>
        </form>

        <!-- Close Modal Button -->
        <button class="mt-4 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600"
                onclick="document.getElementById('addServiceModal').style.display='none'">
            Close
        </button>
    </div>
</div>
@endrole

@endsection



