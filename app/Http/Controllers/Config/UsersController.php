<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\StoreUserRequest;
use App\Http\Requests\Config\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        return view('config.users.index', compact('users', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        $user->assignRole($request->role);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente.'
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return response()->json([
            'usuario' => $usuario,
            'role' => $usuario->roles->first()?->name
        ]);
    }

    public function update(UpdateUserRequest $request, User $usuario)
    {
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $usuario->update(['password' => bcrypt($request->password)]);
        }

        $usuario->syncRoles($request->role);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente.'
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
