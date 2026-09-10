<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use App\Models\AcademicActivityExercise;
use App\Models\AcademicActivityQuestion;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Illuminate\Database\Seeder;

/**
 * Curso "Derecho Informático" (UNP) — actividad de participación interactiva y
 * autocalificada de la Semana 5, basada en los microcasos de Protección de Datos
 * Personales (Ley N.° 29733) y los derechos ARCO.
 *
 * Sigue exactamente el mismo patrón que AcademicoSemana2Seeder (Derecho Mercantil II):
 * updateOrCreate keyed por slug/orden, para que volver a correr este seeder nunca
 * reordene ni reasigne los ids de curso/actividad/pregunta/ejercicio y así no se
 * pierdan las respuestas que un alumno ya haya guardado.
 */
class AcademicoDerechoInformaticoSeeder extends Seeder
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
La Ley N.° 29733, Ley de Protección de Datos Personales, distingue entre datos personales generales y datos sensibles, y reconoce los derechos ARCO —Acceso, Rectificación, Cancelación (supresión) y Oposición— como las facultades que concretan la autodeterminación informativa reconocida en el artículo 2, inciso 6, de la Constitución.

El Reglamento aprobado por el D.S. N.° 016-2024-JUS amplió estos derechos incorporando la portabilidad y la desindexación, por lo que hoy suele hablarse de «ARCO-PD»; en esta actividad trabajarán el núcleo clásico ARCO.

BASE NORMATIVA DE REFERENCIA
Ley N.° 29733, Ley de Protección de Datos Personales (arts. 2, 18-24).
Reglamento aprobado por D.S. N.° 016-2024-JUS.
STC 4739-2007-PHD/TC y STC 02631-2009-HD/TC (tc.gob.pe).

INSTRUCCIONES
Completen los ejercicios interactivos clasificando datos personales, identificando el derecho ARCO aplicable a cada situación, ordenando los derechos ARCO y completando las palabras clave de la norma. Al final, respondan las preguntas de reflexión con sus propias palabras. Tiempo estimado: 35 a 40 minutos.
TXT;

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $course->id, 'slug' => 'semana-5-datos-arco'],
            [
                'week_number' => 5,
                'type' => 'participacion',
                'title' => 'Actividad Semana 5',
                'case_title' => 'Protección de Datos Personales y Derechos ARCO',
                'unit' => 'Unidad II — Protección de Datos Personales',
                'modality' => 'Trabajo grupal (5 a 6 integrantes)',
                'group_size' => '5 a 6 estudiantes',
                'case_body' => $caseBody,
                'status' => 'disponible',
                'access_code' => 'digital1009',
                'due_at' => null,
                // 20 puntos en total repartidos entre los ejercicios de abajo; el confeti
                // solo se muestra si el envío alcanza 55% (11/20) o más.
                'pass_percent' => 55,
            ]
        );

        $questions = [
            'Según el D.S. N.° 016-2024-JUS, ¿qué dos derechos se incorporaron a los ARCO clásicos (dando lugar al llamado «ARCO-PD») y en qué consiste cada uno?',
            'Expliquen con sus propias palabras por qué el historial de compras o el nivel de ingresos, siendo datos generales, pueden llegar a tratarse como sensibles «por inferencia».',
            '¿Por qué la Ley N.° 29733 exige un consentimiento expreso, previo, informado y por escrito para los datos sensibles, y no basta el mismo estándar que para los datos generales?',
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
                    'statement' => 'El domicilio y el distrito de residencia de una persona son, en principio, datos personales sensibles.',
                    'answer' => false,
                ],
                'points' => 1,
            ],
            [
                'type' => 'vf',
                'prompt' => 'Lee la afirmación y marca si es verdadera o falsa.',
                'payload' => [
                    'statement' => 'La huella dactilar usada para marcar asistencia es un dato biométrico y se considera un dato sensible.',
                    'answer' => true,
                ],
                'points' => 1,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'Un usuario descubre que una tienda registró mal su apellido y una dirección antigua, y pide que los corrijan. ¿Qué derecho ARCO ejerce?',
                'payload' => [
                    'options' => ['Acceso', 'Rectificación', 'Cancelación (supresión)', 'Oposición'],
                    'correct' => 1,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'Un cliente empezó a recibir publicidad por SMS que nunca autorizó y pide que dejen de usar su número para ese fin. ¿Qué derecho ARCO ejerce?',
                'payload' => [
                    'options' => ['Acceso', 'Rectificación', 'Cancelación (supresión)', 'Oposición'],
                    'correct' => 3,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'Alguien pagó totalmente una deuda y solicita que una central de riesgo elimine el registro que ya no corresponde. ¿Qué derecho ARCO ejerce?',
                'payload' => [
                    'options' => ['Acceso', 'Rectificación', 'Cancelación (supresión)', 'Oposición'],
                    'correct' => 2,
                ],
                'points' => 2,
            ],
            [
                'type' => 'ordering',
                'prompt' => 'Ordena los derechos ARCO en el orden en que los presenta la Ley N.° 29733.',
                'payload' => [
                    'items' => [
                        ['id' => 'a', 'text' => 'Acceso'],
                        ['id' => 'b', 'text' => 'Rectificación'],
                        ['id' => 'c', 'text' => 'Cancelación (supresión)'],
                        ['id' => 'd', 'text' => 'Oposición'],
                    ],
                    'correctOrder' => ['a', 'b', 'c', 'd'],
                ],
                'points' => 3,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para cada espacio en blanco.',
                'payload' => [
                    'template' => 'Los datos sensibles exigen consentimiento ___, ___, informado y por escrito.',
                    'blanks' => [
                        ['answer' => 'expreso', 'options' => ['expreso', 'tácito', 'presunto']],
                        ['answer' => 'previo', 'options' => ['previo', 'posterior', 'simultáneo']],
                    ],
                ],
                'points' => 2,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para completar el nombre de la norma.',
                'payload' => [
                    'template' => 'La Ley N.° 29733 es la Ley de ___ de Datos Personales.',
                    'blanks' => [
                        ['answer' => 'Protección', 'options' => ['Protección', 'Tratamiento', 'Regulación']],
                    ],
                ],
                'points' => 2,
            ],
            [
                'type' => 'matching',
                'prompt' => 'Arrastra cada dato a la categoría que le corresponde: General o Sensible.',
                'payload' => [
                    'left' => [
                        ['id' => 'd1', 'text' => 'Nombre completo y número de DNI de un cliente.'],
                        ['id' => 'd2', 'text' => 'Domicilio y distrito de residencia.'],
                        ['id' => 'd3', 'text' => 'Placa del vehículo y modelo del automóvil.'],
                        ['id' => 'd4', 'text' => 'Diagnóstico médico de diabetes de un paciente.'],
                        ['id' => 'd5', 'text' => 'Afiliación a un partido político.'],
                        ['id' => 'd6', 'text' => 'Huella dactilar usada para marcar asistencia.'],
                    ],
                    'right' => [
                        ['id' => 'general', 'text' => 'General'],
                        ['id' => 'sensible', 'text' => 'Sensible'],
                    ],
                    'pairs' => [
                        'd1' => 'general',
                        'd2' => 'general',
                        'd3' => 'general',
                        'd4' => 'sensible',
                        'd5' => 'sensible',
                        'd6' => 'sensible',
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
        $this->command?->info("Académico: Derecho Informático (UNP) — Actividad Semana 5 sembrada con código de acceso, {$totalPoints} puntos en ".count($exercises).' ejercicios autocalificables y '.count($questions).' preguntas de reflexión.');
    }
}
