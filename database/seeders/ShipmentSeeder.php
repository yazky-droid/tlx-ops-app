<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipment;
use App\Models\User;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::first();

        // Shipment 1: Delivered Berhasil terkirim selesai
        Shipment::create([
            'reference_no' => 'TLX-202510-0001',
            'shipper_id' => 3,
            'consignee_id' => 2,
            'destination_port' => 'Changi',
            'cargo_description' => 'Personal Items',
            'weight_kg' => 15.00,
            'volume_cbm' => 0.10,
            'goods_value' => 5000000,
            'cargo_condition' => 'Good Condition',
            'service_type' => 'Air Freight',
            'etd' => now()->subDays(10)->toDateString(),
            'eta' => now()->subDays(5)->toDateString(),
            'current_status' => 'Delivered',
            'user_id' => $adminUser->id ?? 1,
        ]);
        
        // Shipment 2: In Transit dalam proses
        Shipment::create([
            'reference_no' => 'TLX-202510-0002',
            'shipper_id' => 1, 
            'consignee_id' => 2, 
            'destination_port' => 'Malaysia',
            'cargo_description' => 'Heavy Machinery Parts',
            'weight_kg' => 1250.00,
            'volume_cbm' => 2.50,
            'goods_value' => 50000000,
            'cargo_condition' => 'In Transit - Needs Clearance',
            'service_type' => 'Air Freight',
            'etd' => now()->subDays(3)->toDateString(),
            'eta' => now()->addDays(10)->toDateString(),
            'current_status' => 'In Transit',
            'user_id' => $adminUser->id ?? 1,
        ]);
        
        // Shipment 3: Booked 
        Shipment::create([
            'reference_no' => 'TLX-202510-0003',
            'shipper_id' => 1, 
            'consignee_id' => 2,
            'destination_port' => 'CGK',
            'cargo_description' => 'Chemical Sample',
            'weight_kg' => 50.00,
            'volume_cbm' => 0.50,
            'goods_value' => 10000000,
            'cargo_condition' => 'Requires Cold Storage',
            'service_type' => 'Air Freight',
            'etd' => now()->addDays(2)->toDateString(),
            'eta' => now()->addDays(7)->toDateString(),
            'current_status' => 'Booked',
            'user_id' => $adminUser->id ?? 1,
        ]);
    }
}