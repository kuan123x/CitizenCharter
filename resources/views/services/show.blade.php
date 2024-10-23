@extends('layouts.admin')

@section('content')
    <!-- Success and Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

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
            {{ $service->service_name }}
        </h1>

        <!-- Add Service Button (Visible only to Admin or Head) -->
        @role('admin|head')
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600"
                    onclick="document.getElementById('addServiceModal').style.display='flex'">
                Add
            </button>
        @endrole
    </div>

    <hr class="mb-6 border-2 border-gray-300">

    <!-- Services List -->
    <div id="servicesList" class="grid grid-cols-1 gap-6">
        <h2 class="text-justify">{{ $service->description }}</h2>

        <!-- Office Information -->
        <table class="border-collapse w-full">
            <tbody>
                <tr>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">Office or Division:</td>
                    <td class="border border-black px-4 py-2">{{ $service->office ? $service->office->office_name : 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">Classification</td>
                    <td class="border border-black px-4 py-2">{{ $service->classification }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">Type of Transaction:</td>
                    <td class="border border-black px-4 py-2">{{ $service->transaction->type_of_transaction }}</td>
                </tr>
                <tr>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">CHECKLIST OF REQUIREMENTS</td>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">WHERE TO SECURE</td>
                </tr>
                @foreach(json_decode($service->checklist_of_requirements, true) ?? [] as $index => $checklist)
                    <tr>
                        <td class="border border-black px-4 py-2">{{ $checklist }}</td>
                        <td class="border border-black px-4 py-2">
                            {{ json_decode($service->where_to_secure, true)[$index] ?? ($service->office ? $service->office->office_name : 'N/A') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Service Info Table -->
        <table class="border-collapse w-full mt-6">
            <tbody>
                <tr>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">CLIENTS</td>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">AGENCY ACTION</td>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">FEES TO BE PAID</td>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">PROCESSING TIME</td>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">PERSON RESPONSIBLE</td>
                    <td class="border border-black px-4 py-2 bg-blue-300 font-bold">ACTION</td>
                </tr>

                @foreach($service->serviceInfos as $info)
                    @php
                        $clients = json_decode($info->clients, true) ?? [];
                        $agencyActions = json_decode($info->agency_action, true) ?? [];
                        $processingTimes = json_decode($info->processing_time, true) ?? [];
                        $personsResponsible = json_decode($info->person_responsible, true) ?? [];
                    @endphp

                    @foreach($clients as $index => $client)
                        <tr>
                            <td class="border border-black px-4 py-2">{{ $client }}</td>
                            <td class="border border-black px-4 py-2">{{ $agencyActions[$index] ?? '' }}</td>
                            <td class="border border-black px-4 py-2">{{ $info->fees }}</td>                            <td class="border border-black px-4 py-2">{{ $processingTimes[$index] ?? 'N/A' }}</td>
                            <td class="border border-black px-4 py-2">{{ $personsResponsible[$index] ?? 'N/A' }}</td>
                            <td class="border border-black px-4 py-2"></td>
                        </tr>
                    @endforeach
                @endforeach

                <!-- Total Fees and Processing Time -->
                <tr>
                    <td colspan="2" class="border border-gray-300 p-2 text-right font-bold">TOTAL</td>

                    <!-- Calculate the total of numeric fees only -->
                    <td class="border border-gray-300 p-2">
                        @php
                            // Filter only numeric values from the fees
                            $totalFees = $service->serviceInfos->filter(function($info) {
                                return is_numeric($info->fees);
                            })->sum(function($info) {
                                return (float) $info->fees;
                            });
                        @endphp

                        {{ $totalFees > 0 ? number_format($totalFees, 2) : 'Depends' }}
                    </td>

                    <!-- Calculate total processing time -->
                    <td class="border border-gray-300 p-2">
                        @php
                            $totalProcessingTime = 0;

                            // Loop through each serviceInfo's processing_time JSON field and extract numeric values
                            foreach ($service->serviceInfos as $info) {
                                $processingTimes = json_decode($info->processing_time, true);

                                foreach ($processingTimes as $time) {
                                    // Use regex to find numeric values in the time strings (e.g., '5 minutes')
                                    if (preg_match('/(\d+)/', $time, $matches)) {
                                        $totalProcessingTime += (int)$matches[1];
                                    }
                                }
                            }
                        @endphp

                        {{ $totalProcessingTime > 0 ? $totalProcessingTime . ' minutes' : 'Depends' }}
                    </td>

                    <td colspan="2" class="border border-gray-300 p-2"></td>
                </tr>

            </tbody>
        </table>
    </div>

    <!-- Modal for Adding Service Info -->
    <div id="addServiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-xl font-bold mb-4">Add Service Info</h2>

            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('services.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="office_id" value="{{ $service->office->id }}">

                <!-- Form Fields -->
                <div class="mb-4">
                    <label for="clients" class="block text-sm font-medium">Clients</label>
                    <input type="text" id="clients" name="clients" class="mt-1 p-2 block w-full border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="agency_action" class="block text-sm font-medium">Agency Action</label>
                    <input type="text" id="agency_action" name="agency_action" class="mt-1 p-2 block w-full border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="info_title" class="block text-sm font-medium">Info Title</label>
                    <input type="text" id="info_title" name="info_title" class="mt-1 p-2 block w-full border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="fees" class="block text-sm font-medium">Fees</label>
                    <input type="text" id="fees" name="fees" class="mt-1 p-2 block w-full border rounded" required> <!-- Fees input accepts text -->
                </div>

                <div class="mb-4">
                    <label for="processing_time" class="block text-sm font-medium">Processing Time</label>
                    <input type="text" id="processing_time" name="processing_time" class="mt-1 p-2 block w-full border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="person_responsible" class="block text-sm font-medium">Person Responsible</label>
                    <input type="text" id="person_responsible" name="person_responsible" class="mt-1 p-2 block w-full border rounded" required>
                </div>

                <div class="mb-4">
                    <label for="step" class="block text-sm font-medium">Step</label>
                    <input type="text" id="step" name="step" class="mt-1 p-2 block w-full border rounded" required>
                </div>

                <div class="flex justify-end">
                    <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" onclick="document.getElementById('addServiceModal').style.display='none'">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for confirmation -->
    <script>
        function confirmDeletion() {
            return confirm('Are you sure you want to delete this item? This action cannot be undone.');
        }
    </script>
@endsection
