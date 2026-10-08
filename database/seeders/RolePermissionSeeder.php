<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'ver-usuarios',
            'ver-roles',
            'ver-permisos',
            'gestionar-configuracion',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $developRole = Role::firstOrCreate(['name' => 'Develop']);
        $developRole->givePermissionTo(Permission::all());

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $vendedorRole = Role::firstOrCreate(['name' => 'Vendedor']);
        $userRole = Role::firstOrCreate(['name' => 'Usuario']);
        $userRole->givePermissionTo(['ver-usuarios']);

        // Create Default Admin Users
        $admin1 = User::firstOrCreate(
            ['email' => 'jose.perera74@gmail.com'],
            [
                'name' => 'Jose Perera',
                'password' => bcrypt('15488395'),
                'status' => 'Activo',
            ]
        );
        $admin1->syncRoles([$developRole]);

        $admin2 = User::firstOrCreate(
            ['email' => 'jesus.cardielg@gmail.com'],
            [
                'name' => 'Jesus Cardiel',
                'password' => bcrypt('15201838'),
                'status' => 'Activo',
            ]
        );
        $admin2->syncRoles([$developRole]);

        // Remove the old test user if it exists
        User::where('email', 'admin@sistema.com')->delete();
    }
}
