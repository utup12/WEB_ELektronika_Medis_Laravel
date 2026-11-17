<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionUserSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'I Putu Adhi Baswara', 'email' => 'iputu.2026@student.uny.ac.id'],
            ['name' => 'Fatchul Arifin', 'email' => 'fatchul@uny.ac.id'],
        ] as $lecturer) {
            User::query()->firstOrCreate(
                ['name' => $lecturer['name']],
                [...$lecturer, 'password' => Hash::make('admin123'), 'role' => 'lecturer'],
            );
        }
    }
}
