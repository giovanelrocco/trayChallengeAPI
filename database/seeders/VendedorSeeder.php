<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Vendedor::factory(10)->create();
    }
}
