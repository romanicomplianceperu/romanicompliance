<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use App\Models\AcademicActivityExercise;
use App\Models\AcademicActivityQuestion;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Illuminate\Database\Seeder;

/**
 * Curso "Derecho Procesal Administrativo" (UNP) — actividad de participación
 * interactiva y autocalificada de la Semana 2, basada en el debate grupal sobre la
 * STC N.° 00197-2010-PA/TC (caso Flores Arocutipa): principio de legalidad y
 * tipicidad, y derecho a un juez imparcial en el procedimiento administrativo
 * disciplinario.
 *
 * Sigue exactamente el mismo patrón que AcademicoDerechoInformaticoSeeder:
 * updateOrCreate keyed por slug/orden, para que volver a correr este seeder nunca
 * reordene ni reasigne los ids de curso/actividad/pregunta/ejercicio y así no se
 * pierdan las respuestas que un alumno ya haya guardado.
 */
class AcademicoDerechoProcesalAdministrativoSeeder extends Seeder
{
    public function run(): void
    {
        $unp = AcademicUniversity::where('slug', 'unp')->first();

        if (! $unp) {
            $this->command?->error('No se encontró la universidad UNP. Corre primero AcademicoSeeder.');

            return;
        }

        $course = AcademicCourse::updateOrCreate(
            ['university_id' => $unp->id, 'slug' => 'derecho-procesal-administrativo'],
            [
                'code_abbr' => 'PRO',
                'name' => 'Derecho Procesal Administrativo',
                'subtitle' => 'Función Administrativa y Debido Procedimiento',
                'faculty' => 'Facultad de Derecho y Ciencias Políticas',
                'period' => '2026-II',
                'total_weeks' => 16,
                'status' => 'active',
            ]
        );

        $caseBody = <<<'TXT'
Javier Pedro Flores Arocutipa, docente de la Universidad José Carlos Mariátegui (Moquegua), fue sometido a un proceso administrativo disciplinario abierto por Resolución Rectoral N.° 288-2008-R-UJCM, por presuntas faltas vinculadas a la suscripción de un convenio. El docente presentó demanda de amparo alegando la vulneración de su derecho al debido proceso, a un juez imparcial, y de los principios de legalidad y tipicidad.

La resolución que abrió el procedimiento invocó primero el artículo 28° del reglamento —que en realidad regula sanciones a estudiantes, no a docentes—. Ante el reclamo, se «aclaró» que la norma aplicable era el artículo 26°, referido a docentes; pero ese artículo contiene trece supuestos de falta y en ningún momento se precisó por cuál de ellos se procesaba al demandante. Además, el asesor legal Cornejo Rodríguez recomendó investigar y luego integró el Tribunal de Honor que dictaminó abrir el proceso.

LO QUE RESOLVIÓ EL TC (fundada en parte)
Declaró vulnerados los principios de legalidad y tipicidad (art. 2, inc. 24, lit. d de la Constitución), porque no se determinó la falta concreta imputada entre los trece supuestos.
Declaró vulnerado el derecho a un juez imparcial (art. 139.3), en su dimensión objetiva, porque quien recomendó investigar luego juzgó.
Declaró inaplicable la resolución rectoral y nulo el procedimiento disciplinario.

BASE NORMATIVA DE REFERENCIA
STC N.° 00197-2010-PA/TC (Sala Segunda del TC, 24/08/2010) — caso Flores Arocutipa.
Constitución, artículo 2, inciso 24, literal d (legalidad y tipicidad) y artículo 139, inciso 3 (juez imparcial).
TUO de la Ley N.° 27444, Título Preliminar, artículo IV (debido procedimiento administrativo).

INSTRUCCIONES
Completen los ejercicios interactivos identificando qué garantía se vulneró en cada hecho del caso, ordenando la secuencia procesal, completando los conceptos clave de legalidad/tipicidad e imparcialidad, y clasificando cada hecho según el principio comprometido. Al final, respondan las preguntas de debate con sus propias palabras, fundamentando en los considerandos de la sentencia. Tiempo estimado: 35 a 40 minutos.
TXT;

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $course->id, 'slug' => 'semana-2-debate-stc-00197-2010'],
            [
                'week_number' => 2,
                'type' => 'participacion',
                'title' => 'Actividad Semana 2',
                'case_title' => 'Debate: STC N.° 00197-2010-PA/TC — Caso Flores Arocutipa',
                'unit' => 'Unidad I — Fundamentos y Principios del Procedimiento Administrativo',
                'modality' => 'Trabajo grupal (máximo 6 integrantes)',
                'group_size' => 'Hasta 6 estudiantes',
                'case_body' => $caseBody,
                'status' => 'disponible',
                'access_code' => 'procesal1009',
                'due_at' => null,
                // 20 puntos en total repartidos entre los ejercicios de abajo. A pedido de
                // Omar, el confeti se muestra siempre al enviar (sin importar el puntaje),
                // igual que en Derecho Mercantil II — a diferencia de Derecho Informático,
                // que sí exige 55% para mostrarlo.
                'pass_percent' => null,
            ]
        );

        $questions = [
            'Expliquen por qué la sola existencia de una norma con "base legal" (el artículo 26°) no bastaba para sancionar válidamente al docente. Distingan legalidad de tipicidad con sus propias palabras.',
            'Si su grupo defendiera al docente, ¿qué tres argumentos centrales plantearían y en qué normas o considerandos de la sentencia los apoyarían?',
            'Si su grupo asesorara a la universidad, ¿cómo debió redactarse la resolución de apertura para ser válida? Escriban un párrafo breve de motivación "modelo".',
        ];

        foreach ($questions as $order => $prompt) {
            AcademicActivityQuestion::updateOrCreate(
                ['academic_activity_id' => $activity->id, 'order' => $order + 1],
                ['prompt' => $prompt]
            );
        }

        $exercises = [
            [
                'type' => 'vf',
                'prompt' => 'Lee la afirmación y marca si es verdadera o falsa.',
                'payload' => [
                    'statement' => 'El artículo 28° del reglamento, primero invocado para procesar al docente, en realidad regula sanciones aplicables a estudiantes, no a docentes.',
                    'answer' => true,
                ],
                'points' => 1,
            ],
            [
                'type' => 'vf',
                'prompt' => 'Lee la afirmación y marca si es verdadera o falsa.',
                'payload' => [
                    'statement' => 'El Tribunal Constitucional declaró infundada en su totalidad la demanda de amparo del docente.',
                    'answer' => false,
                ],
                'points' => 1,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'El principio de legalidad exige lex scripta, lex previa y lex certa (fundamento 3 de la sentencia). ¿Cuál de las tres se vio comprometida en este caso?',
                'payload' => [
                    'options' => ['Lex scripta', 'Lex previa', 'Lex certa', 'Ninguna: las tres se cumplieron'],
                    'correct' => 2,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => '¿Por qué no bastaba con citar el artículo 26° del reglamento para sancionar válidamente al docente?',
                'payload' => [
                    'options' => [
                        'Porque el artículo no estaba vigente en 2008',
                        'Porque contenía trece supuestos de falta y no se precisó cuál se imputaba (falta la tipicidad)',
                        'Porque el reglamento no había sido publicado',
                        'Porque el docente no fue notificado de la resolución',
                    ],
                    'correct' => 1,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'El asesor legal Cornejo Rodríguez primero recomendó investigar y luego integró el Tribunal de Honor que dictaminó abrir el proceso. Esto vulnera:',
                'payload' => [
                    'options' => [
                        'El derecho a la doble instancia',
                        'El derecho a un juez imparcial, en su dimensión objetiva',
                        'El principio de legalidad',
                        'El derecho de defensa',
                    ],
                    'correct' => 1,
                ],
                'points' => 2,
            ],
            [
                'type' => 'ordering',
                'prompt' => 'Ordena la secuencia de los hechos del caso, tal como ocurrieron.',
                'payload' => [
                    'items' => [
                        ['id' => 'a', 'text' => 'La Resolución Rectoral N.° 288-2008-R-UJCM abre el proceso disciplinario invocando el artículo 28° (norma de estudiantes, no de docentes).'],
                        ['id' => 'b', 'text' => 'Ante el reclamo, la universidad "aclara" que la norma aplicable es el artículo 26°, con trece supuestos de falta sin precisar cuál.'],
                        ['id' => 'c', 'text' => 'El asesor legal que recomendó investigar integra luego el Tribunal de Honor que dictamina abrir el proceso.'],
                        ['id' => 'd', 'text' => 'El Tribunal Constitucional declara fundada en parte la demanda y declara nulo el procedimiento disciplinario.'],
                    ],
                    'correctOrder' => ['a', 'b', 'c', 'd'],
                ],
                'points' => 3,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para cada espacio en blanco.',
                'payload' => [
                    'template' => 'El principio de legalidad exige lex scripta, lex ___ y lex ___.',
                    'blanks' => [
                        ['answer' => 'previa', 'options' => ['previa', 'posterior', 'secundaria']],
                        ['answer' => 'certa', 'options' => ['certa', 'amplia', 'general']],
                    ],
                ],
                'points' => 1,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para completar la exigencia de tipicidad.',
                'payload' => [
                    'template' => 'La tipicidad exige que la conducta esté descrita con ___ suficiente para que cualquiera comprenda qué se prohíbe.',
                    'blanks' => [
                        ['answer' => 'precisión', 'options' => ['precisión', 'ambigüedad', 'generalidad']],
                    ],
                ],
                'points' => 1,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para completar la dimensión de imparcialidad vulnerada.',
                'payload' => [
                    'template' => 'La imparcialidad ___ se vulnera cuando la estructura del sistema no ofrece garantías suficientes para descartar toda duda razonable, sin necesidad de un prejuicio personal demostrado.',
                    'blanks' => [
                        ['answer' => 'objetiva', 'options' => ['objetiva', 'subjetiva', 'procesal']],
                    ],
                ],
                'points' => 1,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para completar el fallo del Tribunal Constitucional.',
                'payload' => [
                    'template' => 'El TC declaró ___ en parte la demanda de amparo del docente.',
                    'blanks' => [
                        ['answer' => 'fundada', 'options' => ['fundada', 'infundada', 'improcedente']],
                    ],
                ],
                'points' => 1,
            ],
            [
                'type' => 'matching',
                'prompt' => 'Toca cada hecho del caso y luego toca el principio que se vulnera: Legalidad y tipicidad, o Juez imparcial.',
                'payload' => [
                    'left' => [
                        ['id' => 'd1', 'text' => 'El artículo 26° contiene trece supuestos de falta y no se precisó cuál se imputaba al docente.'],
                        ['id' => 'd2', 'text' => 'Se invocó primero el artículo 28°, que regula faltas de estudiantes, no de docentes.'],
                        ['id' => 'd3', 'text' => 'La tipicidad exige que la conducta esté descrita con precisión suficiente para saber qué se prohíbe.'],
                        ['id' => 'd4', 'text' => 'El asesor legal que recomendó investigar integró luego el Tribunal de Honor que dictaminó.'],
                        ['id' => 'd5', 'text' => 'La imparcialidad objetiva no exige un prejuicio personal probado, sino dudas razonables sobre la estructura del proceso.'],
                        ['id' => 'd6', 'text' => 'Confundir a quien instruye la investigación con quien resuelve el caso compromete la garantía.'],
                    ],
                    'right' => [
                        ['id' => 'legalidad', 'text' => 'Legalidad y tipicidad'],
                        ['id' => 'imparcial', 'text' => 'Juez imparcial'],
                    ],
                    'pairs' => [
                        'd1' => 'legalidad',
                        'd2' => 'legalidad',
                        'd3' => 'legalidad',
                        'd4' => 'imparcial',
                        'd5' => 'imparcial',
                        'd6' => 'imparcial',
                    ],
                ],
                'points' => 5,
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
        $this->command?->info("Académico: Derecho Procesal Administrativo (UNP) — Actividad Semana 2 sembrada con código de acceso, {$totalPoints} puntos en ".count($exercises).' ejercicios autocalificables y '.count($questions).' preguntas de reflexión.');
    }
}
