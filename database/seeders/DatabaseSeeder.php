<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // panggil file-file seedernya dan run
            $this->call([
            UserSeeder::class, 
            ClientSeeder::class,
            ShipmentSeeder::class,
            InvoiceSeeder::class,
        ]);
    }
}
