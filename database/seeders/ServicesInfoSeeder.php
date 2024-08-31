<?php

namespace Database\Seeders;

use App\Models\ServicesInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceId = 1; // Assuming you have a service with ID 1

        ServicesInfo::create([
            'service_id' => $serviceId,
            'step' => 1,
            'info_title' => 'Document Preparation Step 1',
            'clients' => 'Register in the logbook and state your request.',
            'agency_action' => 'Prepares the requested document.',
            'fees' => 0.00,
            'processing_time' => '3 mins',
            'total_fees' => 0.00,
            'total_response_time' => '9 mins',
            'person_responsible' => 'Marisol Sibanta - AO III',
        ]);

        ServicesInfo::create([
            'service_id' => $serviceId,
            'step' => 2,
            'info_title' => 'Document Preparation Step 2',
            'clients' => 'Wait while the requested documents are being prepared by the employee in charge.',
            'agency_action' => 'Signs the prepared document.',
            'fees' => 0.00,
            'processing_time' => '5 mins',
            'total_fees' => 0.00,
            'total_response_time' => '9 mins',
            'person_responsible' => 'Marisol Sibanta - AO III',
        ]);

        ServicesInfo::create([
            'service_id' => $serviceId,
            'step' => 3,
            'info_title' => 'Document Preparation Step 3',
            'clients' => 'Receive the document requested.',
            'agency_action' => 'Releases the requested document.',
            'fees' => 0.00,
            'processing_time' => '1 min',
            'total_fees' => 0.00,
            'total_response_time' => '9 mins',
            'person_responsible' => 'Treasurer’s Office Staff',
        ]);
    }
}
