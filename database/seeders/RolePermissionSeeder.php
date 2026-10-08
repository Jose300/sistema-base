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

        // Create Default Admin User
        $admin = User::firstOrCreate(
            ['email' => 'jose.perera74@gmail.com'],
            [
                'name' => 'Jose Perera',
                'password' => bcrypt('123456789'),
                'status' => 'Activo',
            ]
        );

        // Assign Develop role to the user
        $admin->syncRoles([$developRole]);

        // Remove the old test user if it exists
        User::where('email', 'admin@bodega.com')->delete();
    }
}
