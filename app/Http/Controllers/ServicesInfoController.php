<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServicesInfo;
use Illuminate\Http\Request;

class ServicesInfoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'clients' => 'required|string|max:255',
            'agency_action' => 'required|string|max:255',
            'info_title' => 'required|string|max:255',
            'fees' => 'required|numeric|min:0',
            'total_fees' => 'required|numeric|min:0',
            'processing_time' => 'required|string|max:255',
            'total_response_time' => 'required|string|max:255',
            'person_responsible' => 'required|string|max:255',
            'step' => 'required|string|max:255',  // Validation for 'step'
            'service_id' => 'required|integer|exists:services,id',
        ]);

        ServicesInfo::create([
            'clients' => $request->clients,
            'agency_action' => $request->agency_action,
            'info_title' => $request->info_title,
            'fees' => $request->fees,
            'total_fees' => $request->total_fees,
            'processing_time' => $request->processing_time,
            'total_response_time' => $request->total_response_time,
            'person_responsible' => $request->person_responsible,
            'step' => $request->step,  // Include 'step' in the creation
            'service_id' => $request->service_id,
        ]);

        return redirect()->route('services.show', $request->service_id)->with('success', 'Service info added successfully');
    }

    public function show($id)
    {
        // Fetch the service by ID
        $service = Service::findOrFail($id);

        // Fetch all service infos related to this service
        $services_infos = ServicesInfo::where('service_id', $id)->get();

        // Pass the data to the view
        return view('services.show', compact('service', 'services_infos'));
    }

    public function destroy($service_id, $info_id)
    {
        $info = ServicesInfo::where('id', $info_id)->where('service_id', $service_id)->firstOrFail();
        $info->delete();

        return redirect()->back()->with('success', 'Service info deleted successfully.');
    }
}
