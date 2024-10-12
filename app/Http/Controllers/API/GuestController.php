<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
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
        
        $service = Service::where('office_id', $office_id)
            ->where('id', $service_id)
            ->with('serviceInfos')
            ->first();

        if ($service && $service->serviceInfos->isNotEmpty()) {
            // Get the first serviceInfo object
            $serviceInfo = $service->serviceInfos->first();

            // If serviceInfo exists, return it as JSON
            if ($serviceInfo) {
                return response()->json($serviceInfo);
            }
        }

        return response()->json(['error' => 'Service info not found'], 404);
    }

    
    public function getEvents() {
        $events = Event::all();
        return response()->json($events);
    }
}
