@extends('layouts.admin')

@section('content')
    <div class="mx-auto p-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('services.show', $service->id) }}" class="text-3xl">
                ←
            </a>
            <h1 class="text-2xl font-bold text-center flex-grow">
                {{ strtoupper($service->service_name) }}
            </h1>
            <hr class="mt-2 mb-4">
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Add
            </button>
        </div>

        <!-- Service Details -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p><strong>Office or Division:</strong> ACCOUNTING OFFICE</p>
                <hr class="my-3">
                <p><strong>Classification:</strong> SIMPLE</p>
                <hr class="my-2">
                <p><strong>Type of Transaction:</strong> G2G-Government to Government</p>
                <hr class="my-2">
            </div>

            <div class="col-span-2">
                <p><strong>Checklist of Requirements:</strong> NONE</p>
                <p><strong>Where to Secure:</strong> ACCOUNTING OFFICE</p>
            </div>
        </div>

        <!-- Table Section -->
        <table class="w-full table-fixed border-collapse border border-gray-300">
            <thead class="bg-#9fb3fb">
                <tr>
                    <th class="border border-gray-300 p-2">CLIENTS</th>
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
                        <td class="border border-gray-300 p-2">{{ $info->agency_action }}</td>
                        <td class="border border-gray-300 p-2">{{ $info->fees > 0 ? number_format($info->fees, 2) : 'None' }}</td>
                        <td class="border border-gray-300 p-2">{{ $info->processing_time }}</td>
                        <td class="border border-gray-300 p-2">{{ $info->person_responsible }}</td>
                        <td class="border border-gray-300 p-2 text-center">
                            <button class="bg-green-500 text-white py-1 px- 2 rounded hover:bg-green-600">Edit</button>
                            <button class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="border border-gray-300 p-2 text-right font-bold">TOTAL</td>
                    <td class="border border-gray-300 p-2">
                        {{ $services_infos->sum('fees') > 0 ? number_format($services_infos->sum('fees'), 2) : 'None' }}
                    </td>
                    <td class="border border-gray-300 p-2">
                        {{ $services_infos->sum(function($info) {
                            return (int) filter_var($info->processing_time, FILTER_SANITIZE_NUMBER_INT);
                        }) }} mins
                    </td>
                    <td colspan="2" class="border border-gray-300 p-2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
