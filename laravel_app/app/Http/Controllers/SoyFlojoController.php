<?php

namespace App\Http\Controllers;

use App\Models\AcademicActivity;
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
        $university = AcademicUniversity::where('slug', 'unp')->first() ?? AcademicUniversity::orderBy('order')->first();

        $courses = $university
            ? $university->courses()->orderBy('name')->with(['activities' => fn ($q) => $q
                ->withCount([
                    'submissions as sent_count' => fn ($s) => $s->whereNotNull('submitted_at'),
                    'submissions as draft_count' => fn ($s) => $s->whereNull('submitted_at'),
                ])
                ->withMax('submissions', 'submitted_at')
                ->reorder()->orderByDesc('week_number')->orderByDesc('id')])->get()
            : collect();

        $all = $courses->flatMap->activities;
        $stats = [
            'open' => $all->filter(fn ($a) => $this->isOpen($a))->count(),
            'sent' => $all->sum('sent_count'),
            'next' => $all->filter(fn ($a) => $this->isOpen($a) && $a->due_at)->sortBy('due_at')->first(),
        ];

        return view('soyflojo.index', compact('university', 'courses', 'stats'));
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

        if ($request->boolean('close')) {
            $activity->update(['due_at' => now(), 'status' => 'cerrada']);

            return back()->with('ok', "«{$activity->title}» quedó cerrada.");
        }

        if (! empty($data['shift'])) {
            $base = $activity->due_at && $activity->due_at->isFuture() ? $activity->due_at->copy() : now()->setTimezone(self::TZ)->setTime(20, 0)->utc();
            $due = match ($data['shift']) { '1h' => $base->addHour(), '1d' => $base->addDay(), '7d' => $base->addDays(7) };
        } else {
            $due = ! empty($data['due_at']) ? Carbon::parse($data['due_at'], self::TZ)->utc() : null;
        }

        $changes = ['due_at' => $due];
        // Si la nueva fecha está en el futuro, la actividad vuelve a recibir envíos.
        if ($due && $due->isFuture() && $activity->status === 'cerrada') {
            $changes['status'] = 'disponible';
        }
        $activity->update($changes);

        $msg = $due ? 'Nueva fecha límite: '.$due->copy()->timezone(self::TZ)->translatedFormat('l j \d\e F, g:i a') : 'Sin fecha límite';

        return back()->with('ok', "«{$activity->title}» · ".rtrim($msg, '.').'.');
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
