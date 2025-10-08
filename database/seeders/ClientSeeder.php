<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::create([
            'name' => 'PT. LOGISTIK JAYA',
            'email' => 'logistik@example.com',
            'address' => 'Jakarta, Indonesia',
            'is_shipper' => true,
            'is_consignee' => false,
        ]);

        Client::create([
            'name' => 'PT. GLOBAL IMPORINDO',
            'email' => 'global@example.com',
            'address' => 'Surabaya, Indonesia',
            'is_shipper' => false,
            'is_consignee' => true,
        ]);

        Client::create([
            'name' => 'SARAH (Personal)',
            'email' => 'sarah.p@mail.com',
            'address' => 'Changi, Singapore',
            'is_shipper' => true,
            'is_consignee' => true,
        ]);
    }
}