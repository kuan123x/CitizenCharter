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
            {{ $service->service_name }}
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

@endsection
