<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $transactions = Transaction::where('type_of_transaction', 'type_of_transaction');
        $g2gTransaction = Transaction::where('type_of_transaction', 'G2G-Government to Government')->first();
        $accounting = Office::where('office_name', "Accounting Office")->first();
        $assessors = Office::where('id', 2)->first();

        $accountingServices = [
            [
                'service_name' => 'PROCESSING OF CLAIMS (MUNICIPAL TRANSACTIONS)',
                'description' => "To safeguard the use and disposition of the Municipal Government's assets and to determine its liabilities from claims, pre-audit is undertaken by the Municipal Accountant to determine that all necessary supporting documents of vouchers/claims are submitted.",
                'office_id' => $accounting->id,  // Accounting Office 
                'classification' => 'SIMPLE',
                'transaction_id' => $g2gTransaction->id,
                'checklist_of_requirements' => json_encode([
                    '1. Disbursement vouchers, payrolls & supporting documents',
                    '2. Pre-numbered and pre-audited DVs and payrolls',
                    '3. Duly filed up/dated/signed support  ing documents',
                    "4. Audited DV's with duly accomplished Obligation Request (OBR) by the MBO",
                    '5. Audited & obligated DVs, payrolls and duly filled up/signed/dated supporting documents',
                ]),
                'where_to_secure' => json_encode(['Accounting Office'])
            ],
            [
                'service_name' => 'ISSUANCE OF CERTIFICATE OF INCOME TAX WITHHELD FROM EMPLOYEES',
                'description' => "Government employees' income taxes are withheld pursuant to the National Internal Revenue Code. The Certificate of Compensation Payment/Tax withheld is annually given to show proof that tax due to employees had been paid.",
                'office_id' => $accounting->id,  // Accounting Office
                'classification' => 'SIMPLE',
                'transaction_id' => $g2gTransaction->id,
                'checklist_of_requirements' => json_encode([
                    'None',
                ]),
                'where_to_secure' => json_encode(['Accounting Office'])
            ],
            [
                'service_name' => 'ISSUANCE OF CERTIFICATE OF NET TAKE HOME PAY',
                'description' => "Employees shall secure from the Municipal Accounting Office the certificate of net take home pay for whatever purpose it may serve them.",
                'office_id' => $accounting->id,  // Accounting Office
                'classification' => 'SIMPLE',
                'transaction_id' => $g2gTransaction->id,
                'checklist_of_requirements' => json_encode([
                    'None',
                ]),
                'where_to_secure' => json_encode(['Accounting Office']),
            ],
            [
                'service_name' => 'PROCESSING OF CLAIMS (MUNICIPAL TRANSACTIONS)',
                'description' => "All claims shall be approved by the Punong Barangay (PB) and certified as to validity, propriety and legality of the claim by the Municipal Accountant. In case of claim chargeable against SK Fund, the SK Chairman shall initial under the name of the PB. All disbursements shall be covered with duly processed and approved DVs/payrolls. The BT shall be responsible for paying claims against the Barangay.",
                'office_id' => $accounting->id,  // Accounting Office
                'classification' => 'SIMPLE',
                'transaction_id' => $g2gTransaction->id,
                'checklist_of_requirements' => json_encode([
                    '1. Disbursement Vouchers with complete supporting documents.',
                    '2. Transmittal Letter',
                    '3. Punong Barangay Certification (Duplicate for the Municipal Accountant and Quadruplicate for COA SA)',
                    "4. Personal appearance of the Barangay Treasurer",
                ]),
                'where_to_secure' => json_encode(['Accounting Office']),
            ],
        ];

        $assessorServices = [
            [
                'service_name' => 'ISSUANCE OF CERTIFIED TRUE COPIES OF TAX DECLARATIONS',
                'description' => "To provide system-generated certified true copies to the transacting clients.",
                'office_id' => $assessors->id, 
                'classification' => 'SIMPLE',
                'transaction_id' => $g2gTransaction->id,
                'checklist_of_requirements' => json_encode([
                    '1. Official receipt for the certification fee',
                    '2. Real Property tax must be paid until the current year.',
                    '3. Special Power of Attorney is required if the requesting party is not the tax declarant.',
                ]),
                'where_to_secure' => json_encode([
                    '1. Municipal Treasurer’s Office',
                    '2. Notary Public',
                    '3. To be prepared by a Notary Public']),
            ],
            [
                'service_name' => 'REQUEST FOR ISSUANCE OF TAX DECLARATIONS FOR NEW DISCOVERIES OF LAND',
                'description' => "The objective for the issuance of tax declaration for the newly discovered lands is to properly account all real properties within the municipality.",
                'office_id' => $assessors->id, 
                'classification' => 'SIMPLE',
                'transaction_id' => $g2gTransaction->id,
                'checklist_of_requirements' => json_encode([
                    'FOR UNTITLED PROPERTY:',
                    '1. Sketch Plan', 
                    '2. A & D certification from DENR (original copy)',
                    '3. Affidavit of ownership',
                    '4. Affidavit of Adjoining Owners (all adjoining owners must sign in the affidavit)',
                    '',
                    'FOR TITLED PROPERTY:',
                    '1. Sketch Plan',
                    '2. Photo copy of the title authenticated by the 
                    Municipal Assessor',
                    '3. Document that support the ownership of the 
                    title (if in case the document is insufficient 
                    additional affidavit is required)',
                    'FOR NEW DISCOVERIES OF LAND WITH ERRONEOUS SURVEY CLAIMANT(UNTITLED PROPERTY):',
                    '1. Sketch Plan',
                    '2. Certification from DENR as to A & D',
                    '3. Affidavit of Ownership',
                    '4. Affidavit of Adjoining owners',
                    '5. Affidavit of waiver from the cadastral survey claimant',
                    '6. Certification from the barangay captain',
                    'NEW DISCOVERIES OF FISHPONDS WITH FLA:',
                    '1. Approved Plans FLA/Sketch plan duly signed by Geodetic Engineer with certificate from DENR/DA/BFAR',
                    '2. Letter request from applicant with proper endorsement from the Municipal Assessor (masso level) Note: It should be indicated in the declared owner portion of the FAAS and TD that the applicant is only a beneficial user-developer and not the declared owner.',
                    'NEW DISCOVERIES OF FISHPONDS WITHOUT FLA:',
                    '1. Sketch Map',
                    '2.  Findings of the Municipal Assessor
                    Note: It should be indicated in the declared owner portion of the FAAS and TD that the applicant is only a beneficial user-developer and not a declared owner.
                    Note: All the documents submitted must be in two (2) copies',
                ]),
                'where_to_secure' => json_encode([
                    '',
                    '1. CENRO – DENR',
                    '2. CENRO – DENR',
                    '3. To be prepared by a Notary Public',
                    '4. To be prepared by a Notary Public',
                    '',
                    '1. Municipal Assessor’s',
                    '2. From the Owner',
                    '3. From the Owner',
                    '',
                    '1. CENRO – DENR',
                    '2. CENRO – DENR',
                    '3. To be prepared by a Notary Public',
                    '4. To be prepared by a Notary Public',
                    '5. To be prepared by a Notary Public',
                    '6. Barangay captain where the property is located',
                    '',
                    '1. CENRO – DENR',
                    '2. From the applicant',
                    '',
                    '1. Geodetic Engineer',
                    "2. Municipal Assessor's Office",
                    ])
            ],
        ];

        foreach ($accountingServices as $accountingS) {
            Service::create($accountingS);
        }

        foreach ($assessorServices as $assessorS) {
            Service::create($assessorS);
        }
    }
}


        
