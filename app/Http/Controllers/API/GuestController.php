<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Office;
use App\Models\Service;
use App\Models\ServicesInfo;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Facade;

class GuestController extends Controller
{
    public function getOffices() {
        $offices = Office::all();
        return response()->json($offices);
    }

    public function getServicesForOffice($officeId)
    {
        // Retrieve services only for the specific office
        $services = Service::where('office_id', $officeId)
            ->with('servicesInfos')
            ->get();

        return response()->json($services);
    }

    // public function getServicesByOffice() {
    //     $services = Service::with('office')->get();
    //     return response()->json($services);
    // }

    public function getServiceInfo($office_id, $service_id)
{
    $service = Service::where('office_id', $office_id)
        ->where('id', $service_id)
        ->with('servicesInfo') 
        ->with('transaction') 
        ->first();
        
    dd($service->transaction);

    if (!$service) {
        return response()->json(['error' => 'Service info not found'], 404);
    }

    // dd($service->transaction);
    // Log::info('Transaction Loaded:', [$service->transaction]);

    return response()->json([
        'id' => $service->id,
        'service_name' => $service->service_name,
        'description' => $service->description,
        'office_id' => $service->office_id,
        'classification' => $service->classification,
        'checklist_of_requirements' => $service->checklist_of_requirements,
        'where_to_secure' => $service->where_to_secure,
        'services_infos' => $service->servicesInfos,
        'type_of_transaction' => $service->transaction ? $service->transaction->type_of_transaction : null,  // This will return type_of_transaction
        'status' => $service->status,
        'created_at' => $service->created_at,
        'updated_at' => $service->updated_at,
    ], 200);
}



    
    // public function getServiceInfo($office_id, $service_id) {
        
    //     $service = Service::where('office_id', $office_id)
    //         ->where('id', $service_id)
    //         ->with('serviceInfos')
    //         ->with('transaction')
    //         ->first();

    //     if (!$service) {
    //         return response()->json(['error' => 'Service info not found'], 404);
    //     }
            
    //     return response()->json([
    //     'id' => $service->id,
    //     'service_name' => $service->service_name,
    //     'description' => $service->description,
    //     'office_id' => $service->office_id,
    //     'classification' => $service->classification,
    //     'checklist_of_requirements' => $service->checklist_of_requirements,
    //     'where_to_secure' => $service->where_to_secure,
    //     'services_infos' => $service->serviceInfos,
    //     'type_of_transaction' => $service->transaction->type_of_transaction, // Include the type_of_transaction
    // ], 200);
    //     // return response()->json($service, 200);
    // }

    
    public function getEvents() {
        $events = Event::all();
        return response()->json($events);
    }
    
    public function getEventById($event_id) {
        $event = Event::find($event_id);

        return response()->json($event);
    }

        public function getNotifications()
    {
        try {
            Log::info('Retrieving notifications...');
            $notifications = Notification::with('event')->get()->toArray();
            Log::info('Notifications retrieved successfully.');
            return $notifications;
            // return response()->json([
            //     'success' => true,
            //     'data' => $notifications,
            // ]);
        } catch (\Exception $e) {
            Log::error('Error retrieving notifications: ' . $e->getMessage());
            return [
            'success' => false,
            'error' => 'Failed to load notifications: ' . $e->getMessage(),
        ];
            // return response()->json([
            //     'success' => false,
            //     'error' => 'Failed to load notifications: ' . $e->getMessage(),
            // ], 500);
        }
    }
    
    // public function getNotifications(){
    //     try {
    //         $notifications = Notification::with('events')->get();
    //         return response()->json([
    //             'success' => true,
    //             'data' => $notifications,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'error' => 'Failed to load notifications: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }
}
