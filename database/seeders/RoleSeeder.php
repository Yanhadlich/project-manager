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
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'developer']);
        Role::create(['name' => 'client']);

        Permission::create(['name' => 'view projects']);
        Permission::create(['name' => 'edit projects']);
        Permission::create(['name' => 'delete projects']);
        Permission::create(['name' => 'create projects']);

        Role::findByName('admin')->givePermissionTo(Permission::all());
        Role::findByName('manager')->givePermissionTo(Permission::all());
        Role::findByName('developer')->givePermissionTo(['view projects', 'edit projects', 'create projects']);
        Role::findByName('client')->givePermissionTo(['view projects']);
    }
}
