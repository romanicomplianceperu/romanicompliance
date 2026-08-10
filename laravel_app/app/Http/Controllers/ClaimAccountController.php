<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClaimAccountController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        if (! $user->isGuest()) {
            return redirect()->route('dashboard');
        }

        return view('auth.claim-account', compact('user'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        abort_unless($user->isGuest(), 403);

        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'email' => $data['email'],
            'password' => $data['password'],
            'is_guest' => false,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', '¡Tu cuenta ha quedado guardada! Ya puedes iniciar sesión con tu correo y contraseña.');
    }
}
