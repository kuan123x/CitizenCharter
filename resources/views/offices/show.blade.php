@extends('layouts.admin')

@section('content')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-4">
        @role('admin')
        <a href="{{ route('offices') }}" class="bg-gray-300 text-black py-2 px-4 rounded-lg hover:bg-gray-400">← Back</a>
        @endrole

<<<<<<< HEAD
        <h1 class="text-2xl font-bold text-center flex-1">{{ $office->office_name }} Services</h1>
=======
        <!-- Office Name + Services Title -->
        <h1 class="text-2xl font-bold text-center flex-1">
            {{ $service->service_name }}
        </h1>
>>>>>>> c1cfccb02e050b3385f806adf04ee3a10a0c7b9b

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
<<<<<<< HEAD
            @foreach($services as $service)
            @if($service->status == 'approved')
                <div class="bg-white shadow-md rounded-lg p-8 border border-gray-200 cursor-pointer" onclick="window.location.href='{{ route('services.details', $service->id) }}'">
                    <h3 class="text-lg font-semibold mb-2">{{ $service->service_name }}</h3>
                    <p class="text-gray-700 mb-4">{{ $service->description }}</p>

                    @role('admin|head')
                    <div class="flex justify-center mt-4">
                        <button class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 mr-2"
                                onclick="event.stopPropagation(); editService({{ $service->id }});">
                            Edit
                        </button>

                        <form action="{{ route('services.delete', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600" onclick="event.stopPropagation();">
                                Delete
                            </button>
                        </form>
                    </div>
                    @endrole
                </div>
            @endif
            @endforeach
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg w-1/3 p-6">
            <h2 class="text-xl font-bold mb-4">Edit Service</h2>

            <form id="editServiceForm" action="#" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_service_name">Service Name:</label>
                    <input type="text" name="service_name" id="edit_service_name" required class="border rounded-lg p-2 w-full">
                </div>

                <div class="mt-4">
                    <label for="edit_description">Description:</label>
                    <textarea name="description" id="edit_description" class="border rounded-lg p-2 w-full"></textarea>
                </div>

                <div class="mt-4">
                    <label for="edit_classification">Classification:</label>
                    <select name="classification" id="edit_classification" required class="border rounded-lg p-2 w-full">
                        <option value="SIMPLE">SIMPLE</option>
                        <option value="COMPLEX">COMPLEX</option>
                        <option value="SIMPLE - COMPLEX">SIMPLE - COMPLEX</option>
                        <option value="HIGHLY TECHNICAL">HIGHLY TECHNICAL</option>
                    </select>
                </div>

                <div class="mt-4">
                    <label for="edit_transaction_id">Type of Transaction:</label>
                    <select name="transaction_id" id="edit_transaction_id" required class="border rounded-lg p-2 w-full">
                        @foreach($transactions as $transaction)
                            <option value="{{ $transaction->id }}">{{ $transaction->type_of_transaction }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="edit_checklist_of_requirements">Checklist of Requirements:</label>
                    <textarea name="checklist_of_requirements" id="edit_checklist_of_requirements" class="border rounded-lg p-2 w-full"></textarea>
                </div>

                <div class="mt-4">
                    <label for="edit_where_to_secure">Where to Secure:</label>
                    <textarea name="where_to_secure" id="edit_where_to_secure" class="border rounded-lg p-2 w-full"></textarea>
                </div>

                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 mt-4">Save changes</button>
            </form>

            <button class="mt-4 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600" onclick="document.getElementById('editServiceModal').style.display='none'">Close</button>
        </div>
    </div>

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

    <script>
        function editService(serviceId) {
            fetch(`/services/edit/${serviceId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_service_name').value = data.service_name;
                    document.getElementById('edit_description').value = data.description;
                    document.getElementById('edit_classification').value = data.classification;
                    document.getElementById('edit_transaction_id').value = data.transaction_id;
                    document.getElementById('edit_checklist_of_requirements').value = data.checklist_of_requirements;
                    document.getElementById('edit_where_to_secure').value = data.where_to_secure;

                    // Update form action to point to the correct service update route
                    document.getElementById('editServiceForm').action = `/services/${serviceId}`;

                    // Show the edit modal
                    document.getElementById('editServiceModal').style.display = 'flex';
                })
                .catch(error => console.error('Error fetching service data:', error));
        }

        // Function to close modals
        window.onclick = function(event) {
            const addModal = document.getElementById('addServiceModal');
            const editModal = document.getElementById('editServiceModal');
            if (event.target === addModal) {
                addModal.style.display = 'none';
            }
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        }
    </script>
=======
            <!-- <h2>Service Name: {{ $service->service_name }}</h2> -->
            <h2 class="text-justify">{{ $service -> description }}</h2>
            <table class="border-collapse w-full">
                <tbody>
                    <tr>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">Office or Division:</td>
                        <td class="border border-black px-4 py-2">{{ $service -> office ? $service->office->office_name : 'N/A'  }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">Classification</td>
                        <td class="border border-black px-4 py-2">{{ $service -> classification  }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">Type of Transaction:</td>
                        <td class="border border-black px-4 py-2">{{ $service -> transaction->type_of_transaction  }}</td>
                    </tr>
                    <tr>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">CHECKLIST OF REQUIREMENTS</td>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">WHERE TO SECURE</td>
                    </tr>
                    @foreach(json_decode($service->checklist_of_requirements) as $index => $checklist)
                        <tr>
                            <td class="border border-black px-4 py-2">{{ $checklist }}</td>
                            <td class="border border-black px-4 py-2">{{ json_decode($service->where_to_secure)[$index] ?? $service->office ? $service->office->office_name : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="border-collapse w-full">
                <tbody>
                    <tr>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">CLIENTS</td>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">AGENCY ACTION</td>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">FEES TO BE PAID</td>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">PROCESSING TIME</td>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">PERSON RESPONSIBLE</td>
                        <td class="border border-black px-4 py-2 bg-blue-300 font-bold">ACTION</td>
                    </tr>
                    @foreach ($service->serviceInfos as $info)
                        @foreach(json_decode($info->clients) as $index => $client)
                            <tr>
                                <td class="border border-black px-4 py-2">{{ $client }}</td>
                                <td class="border border-black px-4 py-2">
                                    {{ json_decode($info->agency_action)[$index] ?? '' }}
                                </td>
                                <td class="border border-black px-4 py-2">{{ json_decode($info->fees)[$index] ?? '' }}</td>
                                <td class="border border-black px-4 py-2">
                                    {{ json_decode($info->processing_time)[$index] ?? '' }}
                                </td>
                                <td class="border border-black px-4 py-2">
                                    {{ json_decode($info->person_responsible)[$index] ?? '' }}
                                </td>
                                <td class="border border-black px-4 py-2"></td>
                            </tr>
                            <tr>
                                @if ($loop->last) {{-- Check if it's the last iteration of the inner loop --}}
                                    <td class="border border-black px-4 py-2"></td>
                                    <td class="border border-black px-4 py-2">TOTAL</td>
                                    <td class="border border-black px-4 py-2">{{ $info->total_fees }}</td>
                                    <td class="border border-black px-4 py-2">{{ $info->total_response_time }}</td>
                                    <td class="border border-black px-4 py-2"></td>
                                    <td class="border border-black px-4 py-2"></td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

>>>>>>> c1cfccb02e050b3385f806adf04ee3a10a0c7b9b
@endsection
