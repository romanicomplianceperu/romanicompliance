<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A postulación (application) submitted from the public "convocatoria de pasantías"
 * funnel: /academico/convocatoria -> .../postular -> .../gracias.
 *
 * All the option lists below (areas, disponibilidad, habilidades, ciclo, preguntas
 * especializadas) live here as the single source of truth, so the public form, its
 * server-side validation, and the admin panel's read-only labels never drift apart.
 * Adding, renaming or removing an option only ever needs to happen in one place.
 */
class InternshipApplication extends Model
{
    protected $fillable = [
        'full_name', 'phone', 'email', 'interest_area', 'occupation_status',
        'schedule_availability', 'weekly_hours', 'skills', 'academic_cycle',
        'specialized_answers', 'office_word_level', 'office_excel_level',
        'ai_tools', 'ai_tools_other', 'ai_tools_paid', 'cv_path', 'motivation',
        'status', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'schedule_availability' => 'array',
        'skills' => 'array',
        'specialized_answers' => 'array',
        'ai_tools' => 'array',
    ];

    public const INTEREST_AREAS = [
        'penal_economico_corporativo' => 'Derecho Penal Económico y Corporativo (Compliance, ALA/CFT, Due Diligence)',
        'penal' => 'Derecho Penal (litigio y defensa penal)',
    ];

    public const OCCUPATION_STATUSES = [
        'solo_estudio' => 'Solo estudio',
        'estudio_y_trabajo' => 'Estudio y trabajo',
        'trabajo_y_busco_practicas' => 'Trabajo actualmente y busco una pasantía',
    ];

    public const SCHEDULE_BLOCKS = [
        'manana' => 'Mañana',
        'tarde' => 'Tarde',
        'noche' => 'Noche',
    ];

    public const WEEKLY_HOURS = [
        'menos_10' => 'Menos de 10 horas a la semana',
        'entre_10_20' => 'Entre 10 y 20 horas a la semana',
        'mas_20' => 'Más de 20 horas a la semana',
    ];

    public const SKILLS = [
        'redaccion' => 'Redacción de documentos e informes legales',
        'normativa' => 'Revisión y análisis de normativa',
        'investigacion' => 'Investigación (perfiles, antecedentes, fuentes abiertas)',
        'expedientes' => 'Organización y gestión de expedientes',
        'riesgos' => 'Análisis de riesgos y matrices de cumplimiento',
    ];

    public const MAX_SKILLS = 3;

    public const ACADEMIC_CYCLES = [
        '1-2' => '1er y 2do ciclo',
        '3-4' => '3er y 4to ciclo',
        '5-6' => '5to y 6to ciclo',
        '7-8' => '7mo y 8vo ciclo',
        '9-10' => '9no y 10mo ciclo',
        'egresado' => 'Egresado / Bachiller',
    ];

    /**
     * Preguntas de conocimiento específico. Cada una se responde con una de
     * ANSWER_OPTIONS — simples de marcar, sin respuesta "correcta": sirven para que el
     * equipo entienda de dónde parte cada postulante, no para descalificar a nadie.
     */
    public const SPECIALIZED_QUESTIONS = [
        'plaft' => '¿Sabes qué es la prevención de Lavado de Activos y Financiamiento del Terrorismo (LA/FT)?',
        'manual_prevencion' => '¿Conoces qué es un Manual de Prevención de Lavado de Activos?',
        'matriz_riesgos' => '¿Sabes qué es una matriz de riesgos en materia de cumplimiento normativo?',
        'due_diligence' => '¿Conoces el proceso de Debida Diligencia (Due Diligence) a clientes o proveedores?',
        'listas_verificacion' => '¿Has usado listas de verificación como OFAC, ONU o INTERPOL para revisar antecedentes?',
    ];

    public const ANSWER_OPTIONS = [
        'si' => 'Sí',
        'algo' => 'Algo he escuchado',
        'no' => 'No',
    ];

    public const OFFICE_LEVELS = [
        'basico' => 'Básico',
        'intermedio' => 'Intermedio',
        'avanzado' => 'Avanzado',
    ];

    /**
     * Herramientas de IA que el postulante usa. "ninguna" evita forzar a marcar algo
     * cuando no usa ninguna — sin esa opción, alguien honesto no tendría qué marcar.
     * "otra" revela un campo de texto libre en el formulario (ver ai_tools_other).
     */
    public const AI_TOOLS = [
        'chatgpt' => 'ChatGPT',
        'claude' => 'Claude',
        'gemini' => 'Gemini',
        'otra' => 'Otra',
        'ninguna' => 'Ninguna de las anteriores',
    ];

    public const YES_NO = [
        'si' => 'Sí',
        'no' => 'No',
    ];

    public const STATUSES = [
        'pendiente' => 'Pendiente',
        'contactado' => 'Contactado',
        'aceptado' => 'Aceptado',
        'descartado' => 'Descartado',
    ];

    /**
     * La convocatoria se cierra sola en esta fecha (hora de Lima) — pedido explícito del
     * cliente para no tener que apagar el formulario a mano. store()/form() en el
     * controller usan applicationsOpen() para bloquear envíos fuera de plazo.
     */
    public const APPLICATION_DEADLINE = '2026-09-13 12:00:00';

    public const APPLICATION_DEADLINE_LABEL = 'domingo 13 de septiembre, 12:00 p. m.';

    public static function applicationsOpen(): bool
    {
        return \Illuminate\Support\Carbon::now('America/Lima')
            ->lt(\Illuminate\Support\Carbon::parse(self::APPLICATION_DEADLINE, 'America/Lima'));
    }

    public function interestAreaLabel(): string
    {
        return self::INTEREST_AREAS[$this->interest_area] ?? $this->interest_area;
    }

    public function occupationStatusLabel(): string
    {
        return self::OCCUPATION_STATUSES[$this->occupation_status] ?? $this->occupation_status;
    }

    public function weeklyHoursLabel(): string
    {
        return self::WEEKLY_HOURS[$this->weekly_hours] ?? $this->weekly_hours;
    }

    public function academicCycleLabel(): string
    {
        return self::ACADEMIC_CYCLES[$this->academic_cycle] ?? $this->academic_cycle;
    }

    public function scheduleAvailabilityLabels(): array
    {
        return collect($this->schedule_availability ?? [])
            ->map(fn ($key) => self::SCHEDULE_BLOCKS[$key] ?? $key)
            ->all();
    }

    public function skillLabels(): array
    {
        return collect($this->skills ?? [])
            ->map(fn ($key) => self::SKILLS[$key] ?? $key)
            ->all();
    }

    /**
     * [['question' => ..., 'answer' => ...], ...] in the fixed order the questions are
     * defined above, regardless of the order keys happen to sit in the stored JSON.
     */
    public function specializedAnswerPairs(): array
    {
        $answers = $this->specialized_answers ?? [];

        return collect(self::SPECIALIZED_QUESTIONS)
            ->map(fn ($question, $key) => [
                'question' => $question,
                'answer' => self::ANSWER_OPTIONS[$answers[$key] ?? null] ?? 'Sin responder',
            ])
            ->values()
            ->all();
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function officeWordLevelLabel(): string
    {
        return self::OFFICE_LEVELS[$this->office_word_level] ?? $this->office_word_level;
    }

    public function officeExcelLevelLabel(): string
    {
        return self::OFFICE_LEVELS[$this->office_excel_level] ?? $this->office_excel_level;
    }

    public function aiToolsLabels(): array
    {
        return collect($this->ai_tools ?? [])
            ->map(function ($key) {
                if ($key === 'otra' && filled($this->ai_tools_other)) {
                    return 'Otra: '.$this->ai_tools_other;
                }

                return self::AI_TOOLS[$key] ?? $key;
            })
            ->all();
    }

    public function aiToolsPaidLabel(): string
    {
        return self::YES_NO[$this->ai_tools_paid] ?? $this->ai_tools_paid;
    }

    public function cvUrl(): ?string
    {
        return $this->cv_path ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->cv_path) : null;
    }
}
