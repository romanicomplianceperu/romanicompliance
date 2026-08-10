<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        if ($request->user()->hasCompletedPhoneProfile()) {
            return redirect()->route('dashboard');
        }

        $next = $request->string('next')->toString();
        $next = ($next && parse_url($next, PHP_URL_HOST) === parse_url(url('/'), PHP_URL_HOST)) ? $next : null;

        return view('profile.complete', compact('next'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s()-]{6,30}$/'],
        ]);

        $request->user()->update(['phone' => $data['phone']]);

        $next = $request->string('next')->toString();
        $next = ($next && parse_url($next, PHP_URL_HOST) === parse_url(url('/'), PHP_URL_HOST)) ? $next : route('dashboard');

        return redirect($next)->with('success', 'Perfil completado. ¡Ya puedes inscribirte en cursos!');
    }
}
