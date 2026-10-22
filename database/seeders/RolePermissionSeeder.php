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

        // Permisos base del sistema (Módulos: Mi Perfil, Usuarios, Roles y Permisos)
        $permissions = [
            // Mi Perfil (2)
            [
                'name' => 'ver-perfil',
                'module' => 'Mi Perfil',
                'description' => 'Consultar datos personales y estado de la cuenta'
            ],
            [
                'name' => 'editar-perfil',
                'module' => 'Mi Perfil',
                'description' => 'Modificar datos personales y contraseña del usuario'
            ],

            // Usuarios (4)
            [
                'name' => 'ver-usuarios',
                'module' => 'Usuarios',
                'description' => 'Consultar listado y detalles de usuarios registrados'
            ],
            [
                'name' => 'crear-usuarios',
                'module' => 'Usuarios',
                'description' => 'Registrar nuevas cuentas de usuario en el sistema'
            ],
            [
                'name' => 'editar-usuarios',
                'module' => 'Usuarios',
                'description' => 'Modificar información, roles y estado de usuarios'
            ],
            [
                'name' => 'eliminar-usuarios',
                'module' => 'Usuarios',
                'description' => 'Eliminar o dar de baja cuentas de usuario'
            ],

            // Roles (4)
            [
                'name' => 'ver-roles',
                'module' => 'Roles',
                'description' => 'Consultar listado de roles definidos en la plataforma'
            ],
            [
                'name' => 'crear-roles',
                'module' => 'Roles',
                'description' => 'Registrar nuevos roles de usuario en el sistema'
            ],
            [
                'name' => 'editar-roles',
                'module' => 'Roles',
                'description' => 'Modificar nombres y descripciones de roles'
            ],
            [
                'name' => 'eliminar-roles',
                'module' => 'Roles',
                'description' => 'Eliminar roles del sistema que no estén en uso'
            ],

            // Permisos (2)
            [
                'name' => 'ver-permisos',
                'module' => 'Permisos',
                'description' => 'Consultar matriz general de permisos por rol'
            ],
            [
                'name' => 'asignar-permisos',
                'module' => 'Permisos',
                'description' => 'Activar o desactivar asignación de permisos a roles'
            ],
        ];

        // Eliminar permisos antiguos que no pertenezcan a los módulos base
        $basePermNames = collect($permissions)->pluck('name')->toArray();
        Permission::whereNotIn('name', $basePermNames)->delete();

        foreach ($permissions as $data) {
            Permission::updateOrCreate(
                ['name' => $data['name']],
                [
                    'module' => $data['module'],
                    'description' => $data['description'],
                    'guard_name' => 'web',
                ]
            );
        }

        // Eliminar roles antiguos que no pertenezcan a los roles base por defecto
        Role::whereNotIn('name', ['Develop', 'Admin', 'Usuario'])->delete();

        // Roles exactos del sistema por defecto
        $developRole = Role::firstOrCreate(['name' => 'Develop']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $userRole = Role::firstOrCreate(['name' => 'Usuario']);

        // Develop: CONTROL TOTAL (Todos los permisos base asignados)
        $allPermissions = Permission::all();
        $developRole->syncPermissions($allPermissions);

        // Admin: Todos los permisos base
        $adminRole->syncPermissions($allPermissions);

        // Usuario: Permisos de su perfil
        $userRole->syncPermissions([
            'ver-perfil',
            'editar-perfil',
        ]);

        // Asegurar que los usuarios administradores sigan existiendo y tengan rol Develop
        $admin1 = User::firstOrCreate(
            ['email' => 'jose.perera74@gmail.com'],
            [
                'name' => 'Jose Alexander Perera Guevara',
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

        User::where('email', 'admin@sistema.com')->delete();
    }
}
