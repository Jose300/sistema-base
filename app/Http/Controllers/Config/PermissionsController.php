<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::paginate(10);
        return view('config.permissions.index', compact('roles', 'permissions'));
    }

    public function toggle(Request $request)
    {
        try {
            $role = Role::findById($request->role_id);
            $permission = Permission::findById($request->permission_id);

            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
                $status = 'revoked';
            } else {
                $role->givePermissionTo($permission);
                $status = 'assigned';
            }

            return response()->json([
                'success' => true,
                'status' => $status,
                'message' => 'Permiso actualizado correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
