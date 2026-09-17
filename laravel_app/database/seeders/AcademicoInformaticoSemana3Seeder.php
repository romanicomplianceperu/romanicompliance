<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use App\Models\AcademicActivityExercise;
use App\Models\AcademicActivityQuestion;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Curso "Derecho Informático" (UNP) — actividad interactiva y autocalificada de la
 * Semana 3, basada en la protección constitucional de la persona frente a la
 * informática: intimidad, vida privada, autodeterminación informativa (art. 2, incs.
 * 6 y 7) y el hábeas data (art. 200.3), con su tipología (STC 6164-2007-HD/TC) y su
 * aplicación real (STC 02631-2009-HD/TC, caso INFOCORP).
 *
 * Sigue el mismo patrón que AcademicoDerechoInformaticoSeeder: updateOrCreate keyed
 * por slug/orden, para que volver a correr este seeder nunca reordene ni reasigne ids
 * y así no se pierdan las respuestas que un alumno ya haya guardado.
 */
class AcademicoInformaticoSemana3Seeder extends Seeder
{
    public function run(): void
    {
        $unp = AcademicUniversity::where('slug', 'unp')->first();

        if (! $unp) {
            $this->command?->error('No se encontró la universidad UNP. Corre primero AcademicoSeeder.');

            return;
        }

        $course = AcademicCourse::updateOrCreate(
            ['university_id' => $unp->id, 'slug' => 'derecho-informatico'],
            [
                'code_abbr' => 'INF',
                'name' => 'Derecho Informático',
                'subtitle' => 'Protección de Datos Personales',
                'faculty' => 'Facultad de Derecho y Ciencias Políticas',
                'period' => '2026-II',
                'total_weeks' => 16,
                'status' => 'active',
            ]
        );

        $caseBody = <<<'TXT'
Una clínica publica en su web, «por transparencia», la lista de pacientes atendidos junto con su diagnóstico. Por separado, una tienda de electrodomésticos vende a terceros la base de datos de correos de sus clientes para fines de publicidad, sin haber pedido autorización. Y un banco reporta a una central de riesgo que una persona sigue siendo «deudora», a pesar de que ya pagó por completo su deuda —el registro erróneo la descalifica como sujeto de crédito.

Los tres casos parecen distintos, pero todos ponen a prueba los mismos derechos: el núcleo protegido de la intimidad y la vida privada (art. 2.7), el control sobre los propios datos que da la autodeterminación informativa (art. 2.6), y la garantía procesal que hace exigible ese control ante un juez, el hábeas data (art. 200.3).

El tercer caso reproduce lo resuelto realmente por el Tribunal Constitucional en la STC 02631-2009-HD/TC: acreditado el pago, el TC amparó el derecho a la autodeterminación informativa y ordenó corregir el dato inexacto — un ejemplo real de hábeas data rectificador.

BASE NORMATIVA DE REFERENCIA
Constitución Política del Perú, art. 2, incisos 5, 6 y 7.
Constitución Política del Perú, art. 200, inciso 3 — hábeas data.
Código Procesal Constitucional, art. 62 — reclamo previo de fecha cierta.
STC 6164-2007-HD/TC (tipología del hábeas data) y STC 02631-2009-HD/TC (caso INFOCORP), tc.gob.pe.

INSTRUCCIONES
Completen los ejercicios interactivos identificando qué derecho se afecta en cada situación, clasificando casos según intimidad o autodeterminación informativa, ordenando la tipología del hábeas data y completando las palabras clave de la norma. Al final, respondan la pregunta abierta con sus propias palabras. Disponible hoy desde las 7:00 a. m. hasta las 11:59 p. m. Tiempo estimado: 25 a 30 minutos.
TXT;

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $course->id, 'slug' => 'semana-3-proteccion-constitucional'],
            [
                'week_number' => 3,
                'type' => 'participacion',
                'title' => 'Actividad Semana 3',
                'case_title' => 'Intimidad, autodeterminación informativa y hábeas data',
                'unit' => 'Unidad I — Fundamentos del Derecho Informático y la Sociedad de la Información',
                'case_body' => $caseBody,
                'status' => 'disponible',
                'access_code' => 'informatico1709',
                'due_at' => Carbon::parse('2026-09-17 23:59:00', 'America/Lima')->utc(),
                // 24 puntos en total repartidos entre los ejercicios de abajo.
                'pass_percent' => 55,
            ]
        );

        $questions = [
            'Si una universidad publicara en su portal web los nombres y las notas finales de todos los alumnos de un curso «para transparencia académica», ¿qué derecho o derechos constitucionales se verían afectados y por qué? Fundamenten citando los artículos pertinentes. (Pregunta opcional — valorada hasta con 20 puntos a criterio del docente; no afecta el puntaje automático de los ejercicios).',
        ];

        foreach ($questions as $order => $prompt) {
            AcademicActivityQuestion::updateOrCreate(
                ['academic_activity_id' => $activity->id, 'order' => $order + 1],
                ['prompt' => $prompt]
            );
        }

        $exercises = [
            [
                'type' => 'mcq',
                'prompt' => 'La clínica publica en su web la lista de pacientes con su diagnóstico, «por transparencia». ¿Qué derecho se vulnera principalmente?',
                'payload' => [
                    'options' => [
                        'La intimidad personal (art. 2.7)',
                        'La libertad de expresión',
                        'El derecho de propiedad',
                        'El debido proceso',
                    ],
                    'correct' => 0,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'La tienda vende a terceros la base de correos de sus clientes, sin autorización, para publicidad. ¿Qué derecho se vulnera?',
                'payload' => [
                    'options' => [
                        'La autodeterminación informativa (art. 2.6)',
                        'La intimidad personal exclusivamente',
                        'Únicamente el derecho al honor',
                        'Ninguno: es libre uso comercial de datos de contacto',
                    ],
                    'correct' => 0,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'Según el artículo 200, inciso 3, de la Constitución, ¿contra qué derechos procede el hábeas data?',
                'payload' => [
                    'options' => [
                        'Los derechos del art. 2, incisos 5 y 6',
                        'Únicamente el derecho del art. 2, inciso 7',
                        'Todos los derechos fundamentales, sin excepción',
                        'Solo actos de entidades privadas, nunca del Estado',
                    ],
                    'correct' => 0,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'En la STC 02631-2009-HD/TC, el TC ordenó corregir un reporte crediticio falso en la central de riesgo. ¿Qué tipo de hábeas data se aplicó?',
                'payload' => [
                    'options' => [
                        'Informativo',
                        'Aditivo',
                        'Rectificador',
                        'Exclutorio / cancelatorio',
                    ],
                    'correct' => 2,
                ],
                'points' => 2,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para cada espacio en blanco.',
                'payload' => [
                    'template' => 'La ___ es el círculo más reservado, el «núcleo duro» de la vida privada, mientras que la vida privada es más ___.',
                    'blanks' => [
                        ['answer' => 'intimidad', 'options' => ['intimidad', 'autodeterminación', 'publicidad']],
                        ['answer' => 'amplia', 'options' => ['amplia', 'estrecha', 'pública']],
                    ],
                ],
                'points' => 2,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para completar el requisito previo del hábeas data.',
                'payload' => [
                    'template' => 'Antes de acudir al juez, el titular debe reclamar por documento de fecha ___ y esperar la ___, conforme al art. 62 del Código Procesal Constitucional.',
                    'blanks' => [
                        ['answer' => 'cierta', 'options' => ['cierta', 'dudosa', 'reciente']],
                        ['answer' => 'respuesta', 'options' => ['respuesta', 'sentencia', 'denuncia']],
                    ],
                ],
                'points' => 2,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para completar la definición de autodeterminación informativa.',
                'payload' => [
                    'template' => 'El art. 2, inciso 6, de la Constitución reconoce el derecho a la ___ informativa: el control sobre los datos aunque no sean ___.',
                    'blanks' => [
                        ['answer' => 'autodeterminación', 'options' => ['autodeterminación', 'publicidad', 'intimidad']],
                        ['answer' => 'secretos', 'options' => ['secretos', 'públicos', 'falsos']],
                    ],
                ],
                'points' => 1,
            ],
            [
                'type' => 'ordering',
                'prompt' => 'Ordena los cuatro tipos de hábeas data según la sistematización de la STC 6164-2007-HD/TC.',
                'payload' => [
                    'items' => [
                        ['id' => 'a', 'text' => 'Informativo — recabar qué datos existen sobre uno'],
                        ['id' => 'b', 'text' => 'Aditivo — añadir o actualizar datos faltantes'],
                        ['id' => 'c', 'text' => 'Rectificador — corregir datos falsos o inexactos'],
                        ['id' => 'd', 'text' => 'Exclutorio / cancelatorio — suprimir datos indebidos'],
                    ],
                    'correctOrder' => ['a', 'b', 'c', 'd'],
                ],
                'points' => 3,
            ],
            [
                'type' => 'matching',
                'prompt' => 'Toca cada situación y luego toca si afecta principalmente la Intimidad o la Autodeterminación informativa.',
                'payload' => [
                    'left' => [
                        ['id' => 's1', 'text' => 'Publicar el diagnóstico médico de un paciente'],
                        ['id' => 's2', 'text' => 'Vender el correo de un cliente sin autorización'],
                        ['id' => 's3', 'text' => 'Difundir la orientación sexual de una persona sin su consentimiento'],
                        ['id' => 's4', 'text' => 'Usar el domicilio de un cliente para publicidad no autorizada'],
                        ['id' => 's5', 'text' => 'Revelar las creencias religiosas de un trabajador'],
                        ['id' => 's6', 'text' => 'Compartir el historial de compras de un cliente con un tercero'],
                    ],
                    'right' => [
                        ['id' => 'intimidad', 'text' => 'Intimidad'],
                        ['id' => 'autodeterminacion', 'text' => 'Autodeterminación informativa'],
                    ],
                    'pairs' => [
                        's1' => 'intimidad',
                        's2' => 'autodeterminacion',
                        's3' => 'intimidad',
                        's4' => 'autodeterminacion',
                        's5' => 'intimidad',
                        's6' => 'autodeterminacion',
                    ],
                ],
                'points' => 6,
            ],
            [
                'type' => 'matching',
                'prompt' => 'Empareja cada tipo de hábeas data con lo que permite hacer.',
                'payload' => [
                    'left' => [
                        ['id' => 't1', 'text' => 'Informativo'],
                        ['id' => 't2', 'text' => 'Aditivo'],
                        ['id' => 't3', 'text' => 'Rectificador'],
                        ['id' => 't4', 'text' => 'Exclutorio / cancelatorio'],
                    ],
                    'right' => [
                        ['id' => 'r1', 'text' => 'Recabar qué datos existen y con qué finalidad'],
                        ['id' => 'r2', 'text' => 'Añadir datos faltantes o desactualizados'],
                        ['id' => 'r3', 'text' => 'Corregir datos falsos o imprecisos'],
                        ['id' => 'r4', 'text' => 'Suprimir datos cuya conservación es indebida'],
                    ],
                    'pairs' => ['t1' => 'r1', 't2' => 'r2', 't3' => 'r3', 't4' => 'r4'],
                ],
                'points' => 4,
            ],
        ];

        foreach ($exercises as $order => $exercise) {
            AcademicActivityExercise::updateOrCreate(
                ['academic_activity_id' => $activity->id, 'order' => $order + 1],
                [
                    'type' => $exercise['type'],
                    'prompt' => $exercise['prompt'],
                    'payload' => $exercise['payload'],
                    'points' => $exercise['points'],
                ]
            );
        }

        $totalPoints = array_sum(array_column($exercises, 'points'));
        $this->command?->info("Académico: Derecho Informático (UNP) — Actividad Semana 3 sembrada con código de acceso, {$totalPoints} puntos en ".count($exercises).' ejercicios autocalificables y '.count($questions).' pregunta abierta opcional.');
    }
}
