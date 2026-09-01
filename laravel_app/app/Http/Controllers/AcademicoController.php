<?php

namespace App\Http\Controllers;

use App\Models\AcademicActivity;
use App\Models\AcademicCourse;
use App\Models\AcademicResponse;
use App\Models\AcademicUniversity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AcademicoController extends Controller
{
    public function index()
    {
        return view('academico.index');
    }

    public function visitante()
    {
        return view('academico.visitante');
    }

    public function alumno()
    {
        $universities = AcademicUniversity::orderBy('order')->get();

        return view('academico.alumno', compact('universities'));
    }

    public function university(string $universitySlug)
    {
        $university = AcademicUniversity::where('slug', $universitySlug)->firstOrFail();

        abort_unless($university->isActive(), 404);

        $courses = $university->courses()->get();

        return view('academico.university', compact('university', 'courses'));
    }

    public function course(string $universitySlug, string $courseSlug)
    {
        [$university, $course] = $this->resolve($universitySlug, $courseSlug);

        return view('academico.course', compact('university', 'course'));
    }

    public function participacion(string $universitySlug, string $courseSlug)
    {
        [$university, $course] = $this->resolve($universitySlug, $courseSlug);

        $activities = $course->activities()->where('type', 'participacion')->get();

        return view('academico.participacion-index', compact('university', 'course', 'activities'));
    }

    public function activity(Request $request, string $universitySlug, string $courseSlug, string $activitySlug)
    {
        [$university, $course] = $this->resolve($universitySlug, $courseSlug);

        $activity = $course->activities()->where('slug', $activitySlug)->firstOrFail();
        $activity->load('questions.responses');

        $user = $request->user();
        $responses = [];
        if ($user) {
            foreach ($activity->questions as $question) {
                $responses[$question->id] = $question->responseFor($user);
            }
        }

        return view('academico.activity', compact('university', 'course', 'activity', 'responses'));
    }

    public function identify(Request $request)
    {
        $intended = $request->query('intended', route('academico.index'));

        return view('academico.identify', compact('intended'));
    }

    public function identifyStore(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'intended' => ['nullable', 'string'],
        ]);

        $user = $request->user();

        if (! $user) {
            $user = ! empty($data['email'])
                ? User::where('email', $data['email'])->first()
                : null;

            if (! $user) {
                $user = User::create([
                    'name' => Str::title(Str::lower(trim($data['full_name']))),
                    'email' => $data['email'] ?: 'estudiante-'.Str::random(12).'@guest.romanicompliance.com',
                    'role' => 'student',
                    'is_guest' => true,
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user, remember: true);
        }

        return redirect($data['intended'] ?? route('academico.index'));
    }

    public function respond(Request $request, string $universitySlug, string $courseSlug, string $activitySlug)
    {
        [, $course] = $this->resolve($universitySlug, $courseSlug);
        $activity = $course->activities()->where('slug', $activitySlug)->firstOrFail();

        if (! $request->user()) {
            $activityUrl = route('academico.activity.show', [$universitySlug, $courseSlug, $activitySlug]);

            return redirect()->route('academico.identify', ['intended' => $activityUrl]);
        }

        $data = $request->validate([
            'question_id' => ['required', 'integer'],
            'body' => ['nullable', 'string', 'max:8000'],
            'action' => ['required', 'in:borrador,enviar'],
        ]);

        $question = $activity->questions()->findOrFail($data['question_id']);

        $response = AcademicResponse::updateOrCreate(
            ['academic_activity_question_id' => $question->id, 'user_id' => $request->user()->id],
            [
                'body' => $data['body'] ?? '',
                'status' => $data['action'] === 'enviar' ? 'enviada' : 'borrador',
                'submitted_at' => $data['action'] === 'enviar' ? now() : null,
            ]
        );

        return back()->with('academico_success', $data['action'] === 'enviar' ? 'Participación registrada correctamente.' : 'Borrador guardado.');
    }

    private function resolve(string $universitySlug, string $courseSlug): array
    {
        $university = AcademicUniversity::where('slug', $universitySlug)->firstOrFail();
        abort_unless($university->isActive(), 404);

        $course = AcademicCourse::where('university_id', $university->id)->where('slug', $courseSlug)->firstOrFail();
        abort_unless($course->isActive(), 404);

        return [$university, $course];
    }
}
