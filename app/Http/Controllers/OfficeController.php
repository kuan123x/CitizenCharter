<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Service;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        return view('pages.offices', compact('offices'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'office_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Office::create($validatedData);

        return redirect()->route('admin.offices.index')->with('success', 'Office added successfully.');
    }

    public function show($id)
{
    $office = Office::findOrFail($id);
    $services = $office->services; // Assuming you have a relationship set up between Office and Service

    return view('offices.show', compact('office', 'services'));
}

public function storeService(Request $request, $officeId)
{
    try {
        // Validate the request
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the service
        $service = new Service();
        $service->service_name = $request->service_name;
        $service->description = $request->description;
        $service->office_id = $officeId;
        $service->save();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'service' => $service,
        ]);
    } catch (\Exception $e) {
        // Return a JSON error response
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while adding the service.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


}

