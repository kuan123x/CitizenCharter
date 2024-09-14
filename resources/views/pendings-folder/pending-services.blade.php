{{-- @extends('pages.pendings')

@section('pending-content')
    <h2 class="text-xl font-semibold mb-4">Pending Services</h2>

    <div class="space-y-4">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="font-semibold">Service Name 1</h3>
            <p>Description of the pending service...</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="font-semibold">Service Name 2</h3>
            <p>Description of the pending service...</p>
        </div>

    </div>
@endsection --}}
@extends('pages.pendings')

@section('pending-content')
    <h1 class="text-2xl font-bold mb-4">Pending Services</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success:</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($pendingServices->isEmpty())
        <p>No pending services available.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200 rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Service Name</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingServices as $service)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $service->service_name }}</td>
                        <td class="py-2 px-4 border-b">{{ $service->description }}</td>
                        <td class="py-2 px-4 border-b">
                            <!-- Approve Button -->
                            <form action="{{ route('services.approve', $service->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
                            </form>

                            <!-- Reject Button -->
                            <form action="{{ route('services.reject', $service->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

