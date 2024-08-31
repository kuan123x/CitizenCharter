<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'service_name' => 'ISSUANCE OF CERTIFICATE OF INCOME TAX WITHHELD FROM EMPLOYEES',
            'description' => 'Processing of various documents for residents. asdasdasdasdasdasdasdasdasdasdasd asd asd asd asd asd asd asd asd asd asd asd asd asd asd asd asd asdas das',
            'office_id' => 1, // Example office ID
            'transaction_id' => 1, // Provide a valid transaction_id
            'classification' => 'SIMPLE',
            'checklist_of_requirements' => 'ID, Proof of Residence',
            'where_to_secure' => 'Main Office',
        ]);
        Service::create([
            'service_name' => 'AMBOT UNSA NI NGA OFFICE',
            'description' => 'AMBOPT SA KANDING NGA NAAY BANGS',
            'office_id' => 1, // Example office ID
            'transaction_id' => 1, // Provide a valid transaction_id
            'classification' => 'SIMPLE',
            'checklist_of_requirements' => 'ID, Proof of Residence',
            'where_to_secure' => 'botyok Office',
        ]);
    }
}
