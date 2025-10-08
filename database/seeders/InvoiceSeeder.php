<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Shipment;
use App\Models\User;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::first(); 
        $shipment1 = Shipment::where('reference_no', 'TLX-202510-0001')->first();
        $shipment2 = Shipment::where('reference_no', 'TLX-202510-0002')->first();

        // Invoice 1: Sudah Lunas (Paid)
        if ($shipment1) {
            Invoice::create([
                'shipment_id' => $shipment1->id,
                'client_id' => $shipment1->consignee_id,
                'invoice_number' => 'INV/202510/0001',
                'issue_date' => now()->subDays(7),
                'due_date' => now()->subDays(2),
                'total_amount' => 1500000.00,
                'status' => 'Paid',
                'created_by' => $adminUser->id ?? 1,
            ]);
        }
        
        // Invoice 2: Draft (Belum Dibayar)
        if ($shipment2) {
            Invoice::create([
                'shipment_id' => $shipment2->id,
                'client_id' => $shipment2->consignee_id,
                'invoice_number' => 'INV/202510/0002',
                'issue_date' => now()->subDays(1),
                'due_date' => now()->addDays(14),
                'total_amount' => 5500000.00,
                'status' => 'Draft',
                'created_by' => $adminUser->id ?? 1,
            ]);
        }
    }
}