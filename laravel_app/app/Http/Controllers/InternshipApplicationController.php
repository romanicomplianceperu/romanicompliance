<?php

namespace App\Http\Controllers;

use App\Mail\InternshipApplicationReceived;
use App\Models\InternshipApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InternshipApplicationController extends Controller
{
    /**
     * The address that gets a copy of every new application. If mail isn't configured
     * (or fails for any other reason) the application is still saved and still shows up
     * in the admin panel — see store() below.
     */
    private const NOTIFY_EMAIL = 'omaroliden1@gmail.com';

    public function info()
    {
        // Pulled by e-mail rather than hardcoded so the real production photo, title and
        // bio already on file for each of them (via TeamSeeder) show up automatically —
        // this page never needs to be touched again if either changes.
        $team = User::whereIn('email', ['denis@romanicompliance.com', 'federico.chunga@romanicompliance.com'])
            ->orderBy('team_order')
            ->get();

        return view('academico.convocatoria.info', compact('team'));
    }

    public function form()
    {
        return view('academico.convocatoria.form', [
            'interestAreas' => InternshipApplication::INTEREST_AREAS,
            'occupationStatuses' => InternshipApplication::OCCUPATION_STATUSES,
            'scheduleBlocks' => InternshipApplication::SCHEDULE_BLOCKS,
            'weeklyHours' => InternshipApplication::WEEKLY_HOURS,
            'skills' => InternshipApplication::SKILLS,
            'maxSkills' => InternshipApplication::MAX_SKILLS,
            'academicCycles' => InternshipApplication::ACADEMIC_CYCLES,
            'specializedQuestions' => InternshipApplication::SPECIALIZED_QUESTIONS,
            'answerOptions' => InternshipApplication::ANSWER_OPTIONS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
            'interest_area' => ['required', 'in:'.implode(',', array_keys(InternshipApplication::INTEREST_AREAS))],
            'occupation_status' => ['required', 'in:'.implode(',', array_keys(InternshipApplication::OCCUPATION_STATUSES))],
            'schedule_availability' => ['required', 'array', 'min:1'],
            'schedule_availability.*' => ['in:'.implode(',', array_keys(InternshipApplication::SCHEDULE_BLOCKS))],
            'weekly_hours' => ['required', 'in:'.implode(',', array_keys(InternshipApplication::WEEKLY_HOURS))],
            'skills' => ['required', 'array', 'min:1', 'max:'.InternshipApplication::MAX_SKILLS],
            'skills.*' => ['in:'.implode(',', array_keys(InternshipApplication::SKILLS))],
            'academic_cycle' => ['required', 'in:'.implode(',', array_keys(InternshipApplication::ACADEMIC_CYCLES))],
            'specialized_answers' => ['required', 'array', 'size:'.count(InternshipApplication::SPECIALIZED_QUESTIONS)],
            'specialized_answers.*' => ['in:'.implode(',', array_keys(InternshipApplication::ANSWER_OPTIONS))],
            'motivation' => ['nullable', 'string', 'max:2000'],
        ], [
            // Explicit Spanish messages — the app's base validation-message locale is
            // English, so without these a fallback (non-JS) validation error would read
            // like "The full name field is required." on an otherwise all-Spanish form.
            'full_name.required' => 'El nombre completo es obligatorio.',
            'phone.required' => 'El número de celular es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Escribe un correo electrónico válido.',
            'interest_area.required' => 'Elige un área de interés.',
            'occupation_status.required' => 'Indica tu situación actual.',
            'schedule_availability.required' => 'Marca al menos un horario de disponibilidad.',
            'weekly_hours.required' => 'Indica cuántas horas a la semana puedes dedicar.',
            'skills.required' => 'Marca al menos una habilidad.',
            'skills.max' => 'Marca como máximo '.InternshipApplication::MAX_SKILLS.' habilidades.',
            'academic_cycle.required' => 'Indica en qué ciclo te encuentras.',
            'specialized_answers.required' => 'Responde todas las preguntas de conocimiento previo.',
            'motivation.max' => 'Ese comentario es demasiado largo.',
        ]);

        // Every specialized question must actually be present as a key (not just "5
        // answers total") — validate the key set explicitly since `size` above only
        // checks the count.
        $missingQuestions = array_diff(array_keys(InternshipApplication::SPECIALIZED_QUESTIONS), array_keys($data['specialized_answers']));
        if ($missingQuestions) {
            return back()->withErrors(['specialized_answers' => 'Responde todas las preguntas antes de enviar.'])->withInput();
        }

        $data['ip_address'] = $request->ip();
        $data['user_agent'] = substr((string) $request->userAgent(), 0, 255);

        $application = InternshipApplication::create($data);

        try {
            Mail::to(self::NOTIFY_EMAIL)->send(new InternshipApplicationReceived($application));
        } catch (\Throwable $e) {
            // Never let a mail-server hiccup lose an application — it's already saved and
            // visible in the admin panel either way.
            Log::warning('No se pudo enviar el correo de nueva postulación de practicante: '.$e->getMessage());
        }

        session(['internship_application_name' => $application->full_name]);

        return redirect()->route('academico.convocatoria.thanks');
    }

    public function thanks()
    {
        $name = session('internship_application_name');

        if (! $name) {
            return redirect()->route('academico.convocatoria.info');
        }

        return view('academico.convocatoria.thanks', ['name' => $name]);
    }
}
