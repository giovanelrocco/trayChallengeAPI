<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Venda::factory(5)->create();
    }
}
