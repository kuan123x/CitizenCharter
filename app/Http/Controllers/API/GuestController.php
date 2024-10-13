<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Service;
use App\Models\ServicesInfo;
use App\Models\Transaction;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function getOffices() {
        $offices = Office::all();
        return response()->json($offices);
    }

    public function getServicesByOffice() {
        $services = Service::with('office')->get();
        return response()->json($services);
    }

    public function getServiceInfo($office_id, $service_id) {
    // Fetch the service with its related serviceInfo
        $service = Service::where('office_id', $office_id)
            ->where('id', $service_id)
            ->with('serviceInfos') // Assuming serviceInfos is a relation
            ->first();

        if ($service && $service->serviceInfos) {
            // Assuming you're interested in the first service info
            return response()->json($service->serviceInfos->first()); // Return the first service info object
        } else {
            return response()->json(['error' => 'Service info not found'], 404);
        }
    }
}
