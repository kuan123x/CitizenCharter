<?php

namespace Database\Seeders;

use App\Models\ServicesInfo;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = Service::first();
            $servicesInfo = [
                [
                'service_id' => $service->id,
                'office_id' => $service->office->id,
                'step' => 1.1,
                'info_title' => '',
                'clients' => json_encode([
                    'A. Submit the Disbursement Voucher/ Liquidation of Cash Advance Report and the 
                        supporting documents for Pre-Audit. Wait while the documents are being evaluated and reviewed.',
                    '1. Records/pre-numbers DVs/payrolls and prepares JEV',
                    '2. Pre-audits claim per DVs/payroll and supporting docs',
                    '3. Verifies/controls Obligation of Gen. Fund & SEF and Controls/monitors Trust Fund disbursements',
                    '4. Final review and signature of theAccountant',
                    "B. Submit the Pre-Audited voucher to the Treasurer's Office for signing as to availability of funds and preparation of check.",
                    'C. Secure the approval and signature of the Municipal Mayor',
                    "D. Return the approved/signed check together with the voucher and supporting documents to the Accounting Office for the Withholding Tax Certificate and Accountant's advice.",
                    "E. Sign the voucher, receive the check and accountant's advice"
                ]),
                'agency_action' => json_encode(['Evaluates and Reviews submitted documents.']),
                'fees' => 0,
                'processing_time' => json_encode([
                    '',
                    "Simple - average of 2 minutes; Complex - average of 4 minutes",
                    "Simple - average of 5 minutes; Complex - average of 30 minutes",
                    "General Fund/SEF - average of 2 mins; rust Fund - average of 3 minutes",
                    "Simple - average of 2 minutes; Complex - average of 10 minutes",
                    "5 minutes",
                    "5 minutes",
                    "5 minutes",
                    "2 minutes",
                ]),
                'person_responsible' => json_encode([
                    '',
                    'Melka Marabiles(for General Fund Dvs); Analou Casao (for Trust Fund & SEF Dvs)',
                    'Accounting Staff',
                    'Marisol Sibanta (for General Fund Dvs); Analou Casao (for Trust Fund & SEF Dvs)',
                    'Municipal Accountant',
                    'Maria Lourdes D. Lamanilao (Municipal Treasurer)',
                    'Engr. William R. Jao (Municipal Mayor)',
                    'Accounting Staff & Hennessy D. Muga (Municipal Accountant)',
                    "Treasurer's Office Staff",
                ]),
                'total_fees' => 0,
                'total_response_time' => '64 minutes',
                ]
            ];

            foreach($servicesInfo as $info) {
                ServicesInfo::create($info);
            }
    }
}
