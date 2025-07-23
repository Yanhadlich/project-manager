<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Administrador');

        $coordinator = User::create([
            'name' => 'Coordenador User',
            'email' => 'coordenador@example.com',
            'password' => Hash::make('password'),
        ]);
        $coordinator->assignRole('Coordenador');

        $client = User::create([
            'name' => 'Cliente User',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password'),
        ]);
        $client->assignRole('Cliente');

        // User::factory(10)->create();
    }
}
