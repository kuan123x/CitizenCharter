<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller
{
    // public function index()
    // {
    //     $offices = Office::all();
    //     return view('pages.offices', compact('offices'));
    // }
    // public function index()
    // {
    //     $user = auth()->user();

    //     if ($user->hasRole('head')) {
    //         $office = $user->office;

    //         $services = $office->services;

    //         return view('offices.show', compact('office', 'services'));
    //     }

    //     $offices = Office::all();
    //     return view('pages.offices', compact('offices'));
    // }
    public function index()
{
    $user = auth()->user();

    if ($user->hasRole('head')) {
        // Fetch the office assigned to this head user
        $office = $user->office;

        // Fetch services related to the office
        $services = $office->services;

        // Fetch all transactions for the dropdown
        $transactions = Transaction::all();

        // Pass transactions, office, and services to the view
        return view('offices.show', compact('office', 'services', 'transactions'));
    }

    // If the user is an admin, fetch all offices
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

//     public function show($id)
// {
//     $office = Office::findOrFail($id);
//     $services = $office->services;

//     return view('offices.show', compact('office', 'services'));
// }
public function show($id)
{
    $office = Office::findOrFail($id);
    $services = $office->services; // Assuming you have a relationship set up between Office and Service
    $transactions = Transaction::all(); // Fetch all transactions for the dropdown

    return view('offices.show', compact('office', 'services', 'transactions')); // Pass transactions to the view
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

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'office_name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
    ]);

    $office = Office::findOrFail($id);
    $office->update($validatedData);

    return redirect()->route('admin.offices.index')->with('success', 'Office updated successfully.');
}

public function destroy($id)
{
    $office = Office::findOrFail($id);
    $office->delete();

    return redirect()->route('admin.offices.index')->with('success', 'Office deleted successfully.');
}


}

