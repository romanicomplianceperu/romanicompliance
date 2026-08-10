<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function index()
    {
        $administrators = User::where('role', 'admin')->orderBy('name')->get();

        return view('admin.administrators.index', compact('administrators'));
    }

    public function create()
    {
        return view('admin.administrators.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.administradores.index')->with('success', 'Administrador creado correctamente.');
    }

    public function destroy(Request $request, User $administrator)
    {
        abort_unless($administrator->role === 'admin', 404);

        if ($administrator->id === $request->user()->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        if (User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Debe existir al menos un administrador.');
        }

        $administrator->delete();

        return redirect()->route('admin.administradores.index')->with('success', 'Administrador eliminado.');
    }
}
