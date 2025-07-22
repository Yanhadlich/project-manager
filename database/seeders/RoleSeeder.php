<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Gerente']);
        Role::create(['name' => 'Desenvolvedor']);
        Role::create(['name' => 'Cliente']);

        Permission::create(['name' => 'view projects']);
        Permission::create(['name' => 'edit projects']);
        Permission::create(['name' => 'delete projects']);
        Permission::create(['name' => 'create projects']);

        Role::findByName('Administrador')->givePermissionTo(Permission::all());
        Role::findByName('Gerente')->givePermissionTo(Permission::all());
        Role::findByName('Desenvolvedor')->givePermissionTo(['view projects', 'edit projects', 'create projects']);
        Role::findByName('Cliente')->givePermissionTo(['view projects']);
    }
}
