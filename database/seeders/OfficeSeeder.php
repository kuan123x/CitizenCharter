<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = [
            [
                'office_name' => 'Accounting Office',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => "Assessor's Office",
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Business Permits & Licensing Office',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Engineering Office',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Human Resource & Management Office',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => "Mayor's Office",
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'MDRMMO',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'MENRO',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'MESWMO',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'MLGOO',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'MPDCO',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'MSWDO',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Municipal Agriculture',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Municipal Budget',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Municipal Civil Registrar',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Municipal Health Office',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Municipal Treasurer',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Senior Citizen Affairs',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Secretary to the SB',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'STAC',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Toll Roads',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Tubigon Community Hospital',
                // 'description' => 'The central office for all services.',
            ],
            [
                'office_name' => 'Waterworks',
                // 'description' => 'The central office for all services.',
            ],
        ];

        foreach($offices as $office) {
            Office::create($office);
        }
    }
}
