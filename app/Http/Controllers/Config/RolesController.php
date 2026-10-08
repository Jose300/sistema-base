<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\StoreRoleRequest;
use App\Http\Requests\Config\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('config.roles.index', compact('roles'));
    }

    public function store(StoreRoleRequest $request)
    {
        Role::create(['name' => $request->name]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Rol creado correctamente.'
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit(Role $role)
    {
        return response()->json(['role' => $role]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Rol actualizado correctamente.'
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
