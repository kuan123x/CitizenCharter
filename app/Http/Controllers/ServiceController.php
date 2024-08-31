<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Service;
use App\Models\ServicesInfo;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function store(Request $request, $officeId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $office = Office::findOrFail($officeId);

        $office->services()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('offices.show', $officeId)->with('success', 'Service added successfully!');
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    public function showService($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $services_infos = ServicesInfo::where('service_id', $serviceId)->get();

        return view('services.show', compact('service', 'services_infos'));
    }
}
