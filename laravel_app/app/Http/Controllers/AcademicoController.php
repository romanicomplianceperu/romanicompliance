<?php

namespace App\Http\Controllers;

use App\Models\AcademicActivity;
use App\Models\AcademicActivityVisit;
use App\Models\AcademicCourse;
use App\Models\AcademicResponse;
use App\Models\AcademicSubmission;
use App\Models\AcademicSubmissionMember;
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

        if ($gate = $this->courseGate($university, $course)) {
            return $gate;
        }

        return view('academico.course', compact('university', 'course'));
    }

    public function participacion(string $universitySlug, string $courseSlug)
    {
        [$university, $course] = $this->resolve($universitySlug, $courseSlug);

        if ($gate = $this->courseGate($university, $course)) {
            return $gate;
        }

        $activities = $course->activities()->where('type', 'participacion')->get();

        return view('academico.participacion-index', compact('university', 'course', 'activities'));
    }

    /**
     * Find the activity (if any) that gates entry to this course, and return the
     * access-code screen for it when it hasn't been unlocked yet in this session.
     */
    private function findGatingActivity(AcademicCourse $course): ?AcademicActivity
    {
        return $course->activities()
            ->whereNotNull('access_code')
            ->where('status', 'disponible')
            ->orderByDesc('week_number')
            ->first();
    }

    private function courseGate(AcademicUniversity $university, AcademicCourse $course)
    {
        $gatingActivity = $this->findGatingActivity($course);

        if ($gatingActivity && ! session($this->unlockSessionKey($gatingActivity))) {
            return view('academico.access-code', [
                'university' => $university,
                'course' => $course,
                'activity' => $gatingActivity,
                'formAction' => route('academico.course.unlock', [$university->slug, $course->slug]),
            ]);
        }

        return null;
    }

    public function unlockCourse(Request $request, string $universitySlug, string $courseSlug)
    {
        [$university, $course] = $this->resolve($universitySlug, $courseSlug);

        $gatingActivity = $this->findGatingActivity($course);
        abort_unless($gatingActivity, 404);

        $data = $request->validate(['code' => ['required', 'string', 'max:100']]);

        if (! $gatingActivity->checkAccessCode($data['code'])) {
            return back()->withErrors(['code' => 'El código de acceso no es correcto.'])->withInput();
        }

        session([$this->unlockSessionKey($gatingActivity) => true]);

        return redirect()->route('academico.course', [$universitySlug, $courseSlug]);
    }

    public function activity(Request $request, string $universitySlug, string $courseSlug, string $activitySlug)
    {
        [$university, $course] = $this->resolve($universitySlug, $courseSlug);

        $activity = $course->activities()->where('slug', $activitySlug)->firstOrFail();

        AcademicActivityVisit::create([
            'academic_activity_id' => $activity->id,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'visited_at' => now(),
        ]);

        if ($activity->requiresAccessCode()) {
            return $this->activityGated($request, $university, $course, $activity);
        }

        if (! $activity->isAvailable()) {
            return redirect()
                ->route('academico.participacion.index', [$universitySlug, $courseSlug])
                ->with('academico_error', 'Esta actividad no está disponible por ahora.');
        }

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

    private function activityGated(Request $request, AcademicUniversity $university, AcademicCourse $course, AcademicActivity $activity)
    {
        $unlockKey = $this->unlockSessionKey($activity);

        if (! session($unlockKey)) {
            return view('academico.access-code', [
                'university' => $university,
                'course' => $course,
                'activity' => $activity,
                'formAction' => route('academico.activity.unlock', [$university->slug, $course->slug, $activity->slug]),
            ]);
        }

        $submission = $this->currentSubmission($request, $activity);

        if (! $submission) {
            return view('academico.register', compact('university', 'course', 'activity'));
        }

        $submission->load('members');
        $activity->load('questions');

        return view('academico.interactive', [
            'university' => $university,
            'course' => $course,
            'activity' => $activity,
            'submission' => $submission,
            'isClosed' => $activity->isPastDue() && $submission->isSubmitted(),
            'canEdit' => ! $activity->isPastDue() || ! $submission->isSubmitted(),
        ]);
    }

    public function unlockActivity(Request $request, string $universitySlug, string $courseSlug, string $activitySlug)
    {
        [$university, $course] = $this->resolve($universitySlug, $courseSlug);
        $activity = $course->activities()->where('slug', $activitySlug)->firstOrFail();

        $data = $request->validate(['code' => ['required', 'string', 'max:100']]);

        if (! $activity->checkAccessCode($data['code'])) {
            return back()->withErrors(['code' => 'El código de acceso no es correcto.'])->withInput();
        }

        session([$this->unlockSessionKey($activity) => true]);

        return redirect()->route('academico.activity.show', [$universitySlug, $courseSlug, $activitySlug]);
    }

    public function registerSubmission(Request $request, string $universitySlug, string $courseSlug, string $activitySlug)
    {
        [$university, $course] = $this->resolve($universitySlug, $courseSlug);
        $activity = $course->activities()->where('slug', $activitySlug)->firstOrFail();

        abort_unless($activity->requiresAccessCode() && session($this->unlockSessionKey($activity)), 403);

        $data = $request->validate([
            'mode' => ['required', 'in:individual,grupal'],
            'full_name' => ['required_if:mode,individual', 'nullable', 'string', 'max:255'],
            'email' => ['required_if:mode,individual', 'nullable', 'email', 'max:255'],
            'members' => ['required_if:mode,grupal', 'nullable', 'array', 'min:2'],
            'members.*.full_name' => ['required_with:members', 'string', 'max:255'],
            'members.*.email' => ['required_with:members', 'email', 'max:255'],
        ]);

        $submission = new AcademicSubmission([
            'academic_activity_id' => $activity->id,
            'mode' => $data['mode'],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        if ($data['mode'] === 'grupal') {
            $submission->group_code = AcademicSubmission::generateGroupCode($university, $course);
        }

        $submission->save();

        if ($data['mode'] === 'individual') {
            AcademicSubmissionMember::create([
                'academic_submission_id' => $submission->id,
                'full_name' => Str::title(Str::lower(trim($data['full_name']))),
                'email' => $data['email'],
            ]);
        } else {
            foreach ($data['members'] as $member) {
                AcademicSubmissionMember::create([
                    'academic_submission_id' => $submission->id,
                    'full_name' => Str::title(Str::lower(trim($member['full_name']))),
                    'email' => $member['email'],
                ]);
            }
        }

        session([$this->submissionSessionKey($activity) => $submission->id]);

        return redirect()->route('academico.activity.show', [$universitySlug, $courseSlug, $activitySlug]);
    }

    public function saveSubmission(Request $request, string $universitySlug, string $courseSlug, string $activitySlug)
    {
        [, $course] = $this->resolve($universitySlug, $courseSlug);
        $activity = $course->activities()->where('slug', $activitySlug)->firstOrFail();

        $submission = $this->currentSubmission($request, $activity);
        abort_unless($submission, 403);

        $data = $request->validate([
            'answers' => ['nullable', 'string'],
            'action' => ['required', 'in:borrador,enviar'],
        ]);

        if ($data['action'] === 'enviar' && $activity->isPastDue()) {
            return back()->with('academico_error', 'El plazo de entrega venció. Tu avance quedó guardado como borrador, pero ya no se puede enviar.');
        }

        $decoded = null;
        if (! empty($data['answers'])) {
            $decoded = json_decode($data['answers'], true);
        }

        $submission->answers = is_array($decoded) ? $decoded : $submission->answers;

        if ($data['action'] === 'enviar') {
            $submission->submitted_at = now();
        }

        $submission->save();

        return redirect()
            ->route('academico.activity.show', [$universitySlug, $courseSlug, $activitySlug])
            ->with('academico_success', $data['action'] === 'enviar' ? 'Actividad enviada correctamente.' : 'Avance guardado.');
    }

    private function unlockSessionKey(AcademicActivity $activity): string
    {
        return "academico_unlocked_activity_{$activity->id}";
    }

    private function submissionSessionKey(AcademicActivity $activity): string
    {
        return "academico_submission_activity_{$activity->id}";
    }

    private function currentSubmission(Request $request, AcademicActivity $activity): ?AcademicSubmission
    {
        $id = session($this->submissionSessionKey($activity));

        return $id ? AcademicSubmission::find($id) : null;
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
