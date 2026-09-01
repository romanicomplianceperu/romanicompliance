<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GuestEnrollController extends Controller
{
    /**
     * Inicio rápido sin cuenta: crea (o reutiliza) un usuario liviano a
     * partir del nombre y, opcionalmente, el correo. Reutiliza exactamente
     * el mismo motor de inscripción/progreso/certificados que ya usa el
     * resto de la plataforma, en vez de duplicar lógica para invitados.
     */
    public function start(Request $request, Course $course)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $user = $request->user();

        if ($user && $user->is_guest) {
            // Ya existe una sesión de invitado activa (cookie "recordarme" de
            // una visita anterior). Si el nombre o correo recién escritos no
            // coinciden con esa identidad, no la reutilizamos en silencio:
            // probablemente es otra persona en el mismo navegador/dispositivo.
            $sameEmail = ! empty($data['email']) && $user->email === $data['email'];
            $sameName = Str::lower(trim($data['full_name'])) === Str::lower($user->name);

            if (! $sameEmail && ! $sameName) {
                $user = null;
            }
        }

        if (! $user) {
            $user = $data['email'] ?? null
                ? User::where('email', $data['email'])->first()
                : null;

            if (! $user) {
                $user = User::create([
                    'name' => Str::title(Str::lower(trim($data['full_name']))),
                    'email' => $data['email'] ?: 'invitado-'.Str::random(12).'@guest.romanicompliance.com',
                    'role' => 'student',
                    'is_guest' => true,
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user, remember: true);
        }

        $course->enrollments()->firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'active', 'progress_percent' => 0]
        );

        return redirect()->route('courses.show', ['course' => $course, 'bienvenida' => 1]);
    }
}
