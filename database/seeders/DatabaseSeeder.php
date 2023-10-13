<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'email' => 'test@email.com',
            'password' => 'test123',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        \App\Models\Vendedor::factory()->create();
    }
}
