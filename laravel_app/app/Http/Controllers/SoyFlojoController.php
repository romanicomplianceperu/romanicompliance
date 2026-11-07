<?php

namespace App\Http\Controllers;

use App\Models\AcademicActivity;
use App\Models\AcademicCourse;
use App\Models\AcademicSubmission;
use App\Models\AcademicUniversity;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * /soyflojo: vista rápida y para el móvil de los cursos de la UNP. Permite ver los
 * códigos de acceso, mover la fecha de vencimiento de cada actividad y revisar envíos.
 */
class SoyFlojoController extends Controller
{
    public const TZ = 'America/Lima';

    public function index()
    {
        $university = $this->university();
        $courses = $university
            ? $university->courses()->orderBy('name')->with(['activities' => fn ($q) => $q
                ->withCount(['submissions as sent_count' => fn ($s) => $s->whereNotNull('submitted_at')])])->get()
            : collect();

        $courses->each(function ($c) {
            $c->open_count = $c->activities->filter(fn ($a) => self::isOpen($a))->count();
            $c->sent_total = $c->activities->sum('sent_count');
            $c->next_due = $c->activities->filter(fn ($a) => self::isOpen($a) && $a->due_at)->sortBy('due_at')->first()?->due_at;
        });

        return view('soyflojo.index', compact('university', 'courses'));
    }

    public function course(AcademicCourse $course)
    {
        $activities = $course->activities()
            ->withCount([
                'submissions as sent_count' => fn ($s) => $s->whereNotNull('submitted_at'),
                'submissions as draft_count' => fn ($s) => $s->whereNull('submitted_at'),
            ])
            ->reorder()->orderByDesc('week_number')->orderByDesc('id')->get();

        return view('soyflojo.course', compact('course', 'activities'));
    }

    private function university(): ?AcademicUniversity
    {
        return AcademicUniversity::where('slug', 'unp')->first() ?? AcademicUniversity::orderBy('order')->first();
    }

    public function show(Request $request, AcademicActivity $activity)
    {
        $activity->load('course.university', 'exercises', 'questions');
        $tab = $request->query('ver') === 'en-curso' ? 'en-curso' : 'enviados';
        $all = $activity->submissions()->with('members')->get();
        $sent = $all->filter->isSubmitted()->sortByDesc('submitted_at')->values();
        $drafts = $all->reject->isSubmitted()->sortByDesc('created_at')->values();
        $list = $tab === 'enviados' ? $sent : $drafts;

        return view('soyflojo.show', compact('activity', 'tab', 'sent', 'drafts', 'list'));
    }

    /** Cambia la fecha límite (hora de Lima) o la corre con los atajos +1 h, +1 día, +7 días. */
    public function updateDue(Request $request, AcademicActivity $activity)
    {
        $data = $request->validate([
            'due_at' => ['nullable', 'date'],
            'shift' => ['nullable', 'in:1h,1d,7d'],
            'close' => ['nullable', 'boolean'],
        ]);

        // Desactivar: deja de recibir envíos al instante; la fecha se conserva para reactivarla luego.
        if ($request->boolean('close')) {
            $activity->update(['status' => 'cerrada']);

            return $this->backTo($activity)->with('ok', "«{$activity->title}» quedó desactivada. Los alumnos ya no pueden enviarla.");
        }

        if (! empty($data['shift'])) {
            $base = $activity->due_at && $activity->due_at->isFuture() ? $activity->due_at->copy() : now()->setTimezone(self::TZ)->setTime(20, 0)->utc();
            $due = match ($data['shift']) { '1h' => $base->addHour(), '1d' => $base->addDay(), '7d' => $base->addDays(7) };
        } else {
            $due = ! empty($data['due_at']) ? Carbon::parse($data['due_at'], self::TZ)->utc() : null;
        }

        $wasOpen = self::isOpen($activity);
        $changes = ['due_at' => $due];
        // Con una fecha futura la actividad queda activa: abierta y visible para los alumnos.
        if ($due && $due->isFuture()) {
            $changes['status'] = 'disponible';
            $changes['is_hidden'] = false;
        }
        $activity->update($changes);

        $when = $due ? $due->copy()->timezone(self::TZ)->translatedFormat('l j \d\e F, g:i a') : null;
        $msg = ! $due ? 'Sin fecha límite' : (! $wasOpen && self::isOpen($activity->fresh()) ? 'Reactivada hasta el '.$when : 'Nueva fecha límite: '.$when);

        return $this->backTo($activity)->with('ok', "«{$activity->title}» · ".rtrim($msg, '.').'.');
    }

    /** Vuelve a la página anterior, con la actividad editada a la vista. */
    private function backTo(AcademicActivity $activity)
    {
        return redirect()->to(strtok(url()->previous(), '#').'#act-'.$activity->id);
    }

    public function updateSubmission(Request $request, AcademicSubmission $submission)
    {
        $data = $request->validate(['status' => ['required', 'in:pendiente,aprobado,no_aprobado']]);
        $submission->update(['status' => $data['status']]);

        return back()->with('ok', 'Estado del envío actualizado.');
    }

    /** Descarga de notas en CSV (abre en Excel). */
    public function csv(AcademicActivity $activity)
    {
        $activity->load('course', 'exercises');
        $rows = $activity->submissions()->with('members')->whereNotNull('submitted_at')->orderBy('submitted_at')->get();
        $name = \Illuminate\Support\Str::slug($activity->course->name.' semana '.$activity->week_number).'.csv';

        return response()->streamDownload(function () use ($rows, $activity) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Integrantes', 'Correos', 'Teléfonos', 'Modo', 'Enviado (Lima)', 'Puntaje', 'Total', 'Extra', 'Archivo', 'Estado'], ',', '"', '');
            foreach ($rows as $s) {
                $g = $activity->grade($s);
                fputcsv($out, [
                    $s->members->pluck('full_name')->join(' / '),
                    $s->members->pluck('email')->join(' / '),
                    $s->members->pluck('phone')->filter()->join(' / '),
                    $s->mode === 'grupal' ? 'Grupo '.$s->group_code : 'Individual',
                    $s->submitted_at->timezone(self::TZ)->format('d/m/Y H:i'),
                    $g['earned_points'] ?? '', $g['total_points'] ?? '', $g['bonus_points'] ?? '',
                    $s->hasFile() ? $s->fileUrl() : '',
                    $s->status,
                ], ',', '"', '');
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public static function isOpen(AcademicActivity $a): bool
    {
        return $a->status === 'disponible' && ! $a->is_hidden && ! $a->isPastDue();
    }
}
