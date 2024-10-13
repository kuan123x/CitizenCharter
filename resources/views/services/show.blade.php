@extends('layouts.admin')

@section('content')
    <div class="mx-auto p-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success:</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('offices') }}" class="text-3xl">←</a>
            <h1 class="text-2xl font-bold text-center flex-grow">{{ strtoupper($service->service_name) }}</h1>
            <hr class="mt-2 mb-4">
            <button onclick="document.getElementById('addModal').style.display='block'" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Add
            </button>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p><strong>Office or Division:</strong> {{ $service->office->name }}</p>
                <hr class="my-3">
                <p><strong>Classification:</strong> {{ $service->classification }}</p>
                <hr class="my-2">
                <p><strong>Type of Transaction:</strong> {{ $service->transaction->type_of_transaction ?? 'N/A' }}</p>

                <hr class="my-2">
            </div>
            <div class="col-span-2">
                <p><strong>Checklist of Requirements:</strong> {{ $service->checklist_of_requirements ?: 'NONE' }}</p>
                <p><strong>Where to Secure:</strong> {{ $service->where_to_secure }}</p>
            </div>
        </div>

        <table class="w-full table-fixed border-collapse border border-gray-300">
            <thead class="bg-#9fb3fb">
                <tr>
                    <th class="border border-gray-300 p-2">CLIENTS</th>
                    <th class="border border-gray-300 p-2">INFO TITLE</th>
                    <th class="border border-gray-300 p-2">AGENCY ACTION</th>
                    <th class="border border-gray-300 p-2">FEES TO BE PAID</th>
                    <th class="border border-gray-300 p-2">PROCESSING TIME</th>
                    <th class="border border-gray-300 p-2">PERSON RESPONSIBLE</th>
                    <th class="border border-gray-300 p-2">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services_infos as $info)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $info->clients }}</td>
                        <td class="border border-gray-300 p-2">{{ $info->info_title }}</td>
                        <td class="border border-gray-300 p-2">{{ $info->agency_action }}</td>
                        <td class="border border-gray-300 p-2">{{ $info->fees > 0 ? number_format($info->fees, 2) : 'None' }}</td>
                        <td class="border border-gray-300 p-2">{{ $info->processing_time }}</td>
                        <td class="border border-gray-300 p-2">{{ $info->person_responsible }}</td>
                        <td class="border border-gray-300 p-2 text-center">
                            <button class="bg-green-500 text-white py-1 px-2 rounded hover:bg-green-600" onclick="openEditModal({{ $info->id }})">Edit</button>
                            <form action="{{ route('services.info.delete', ['service_id' => $service->id, 'info_id' => $info->id]) }}" method="POST" style="display:inline;" onsubmit="return confirmDeletion();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="border border-gray-300 p-2 text-right font-bold">TOTAL</td>
                    <td class="border border-gray-300 p-2">{{ $services_infos->sum('fees') > 0 ? number_format($services_infos->sum('fees'), 2) : 'None' }}</td>
                    <td class="border border-gray-300 p-2">{{ $services_infos->sum(function($info) { return (int) filter_var($info->processing_time, FILTER_SANITIZE_NUMBER_INT); }) }} mins</td>
                    <td colspan="2" class="border border-gray-300 p-2"></td>
                </tr>
            </tfoot>
        </table>

        <!-- Add Modal -->
        <div id="addModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
                    <h2 class="text-2xl font-bold mb-4">Add Service Info</h2>
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <div class="mb-4">
                            <label for="clients" class="block text-gray-700">Clients</label>
                            <input type="text" id="clients" name="clients" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="agency_action" class="block text-gray-700">Agency Action</label>
                            <input type="text" id="agency_action" name="agency_action" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="info_title" class="block text-gray-700">Info Title</label>
                            <input type="text" id="info_title" name="info_title" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="step" class="block text-gray-700">Step</label>
                            <input type="text" id="step" name="step" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="fees" class="block text-gray-700">Fees</label>
                            <input type="text" id="fees" name="fees" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="total_fees" class="block text-gray-700">Total Fees</label>
                            <input type="text" id="total_fees" name="total_fees" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="processing_time" class="block text-gray-700">Processing Time</label>
                            <input type="text" id="processing_time" name="processing_time" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="total_response_time" class="block text-gray-700">Total Response Time</label>
                            <input type="text" id="total_response_time" name="total_response_time" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label for="person_responsible" class="block text-gray-700">Person Responsible</label>
                            <input type="text" id="person_responsible" name="person_responsible" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="mr-4 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400" onclick="document.getElementById('addModal').style.display='none'">Cancel</button>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
                    <h2 class="text-2xl font-bold mb-2">Edit Service Info</h2>
                    <form id="editForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <div class="mb-2">
                            <label for="edit_clients" class="block text-gray-700">Clients</label>
                            <input type="text" id="edit_clients" name="clients" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-2">
                            <label for="edit_agency_action" class="block text-gray-700">Agency Action</label>
                            <input type="text" id="edit_agency_action" name="agency_action" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-2">
                            <label for="edit_info_title" class="block text-gray-700">Info Title</label>
                            <input type="text" id="edit_info_title" name="info_title" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-2">
                            <label for="edit_step" class="block text-gray-700">Step</label>
                            <input type="text" id="edit_step" name="step" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-2">
                            <label for="edit_fees" class="block text-gray-700">Fees</label>
                            <input type="text" id="edit_fees" name="fees" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-2">
                            <label for="edit_total_fees" class="block text-gray-700">Total Fees</label>
                            <input type="text" id="edit_total_fees" name="total_fees" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-2">
                            <label for="edit_processing_time" class="block text-gray-700">Processing Time</label>
                            <input type="text" id="edit_processing_time" name="processing_time" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-2">
                            <label for="edit_total_response_time" class="block text-gray-700">Total Response Time</label>
                            <input type="text" id="edit_total_response_time" name="total_response_time" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="mb-2">
                            <label for="edit_person_responsible" class="block text-gray-700">Person Responsible</label>
                            <input type="text" id="edit_person_responsible" name="person_responsible" class="w-full border border-gray-300 p-2 rounded-lg">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="mr-4 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400" onclick="document.getElementById('editModal').style.display='none'">Cancel</button>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDeletion() {
            return confirm('Are you sure you want to delete this item? This action cannot be undone.');
        }

        function openEditModal(infoId) {
            const info = @json($services_infos);
            const selectedInfo = info.find(item => item.id === infoId);

            document.getElementById('editForm').action = `/services/${selectedInfo.service_id}/info/${selectedInfo.id}`;
            document.getElementById('edit_clients').value = selectedInfo.clients;
            document.getElementById('edit_agency_action').value = selectedInfo.agency_action;
            document.getElementById('edit_info_title').value = selectedInfo.info_title;
            document.getElementById('edit_step').value = selectedInfo.step;
            document.getElementById('edit_fees').value = selectedInfo.fees;
            document.getElementById('edit_total_fees').value = selectedInfo.total_fees;
            document.getElementById('edit_processing_time').value = selectedInfo.processing_time;
            document.getElementById('edit_total_response_time').value = selectedInfo.total_response_time;
            document.getElementById('edit_person_responsible').value = selectedInfo.person_responsible;

            document.getElementById('editModal').style.display = 'block';
        }
    </script>
@endsection
