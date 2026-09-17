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
 * Curso "Derecho Mercantil II" (UNP) — actividad interactiva y autocalificada de la
 * Semana 3, basada en la constitución de sociedades: pacto social, estatuto,
 * modalidades de constitución, aportes y capital social (LGS, arts. 5, 11, 22, 25, 51-54),
 * con el caso registral de la panadería Saavedra como hilo conductor.
 *
 * Sigue el mismo patrón que AcademicoSemana2Seeder: updateOrCreate keyed por slug/orden,
 * para que volver a correr este seeder nunca reordene ni reasigne ids y así no se
 * pierdan las respuestas que un alumno ya haya guardado.
 */
class AcademicoMercantilSemana3Seeder extends Seeder
{
    public function run(): void
    {
        $unp = AcademicUniversity::where('slug', 'unp')->first();

        if (! $unp) {
            $this->command?->error('No se encontró la universidad UNP. Corre primero AcademicoSeeder.');

            return;
        }

        $mercantil = AcademicCourse::updateOrCreate(
            ['university_id' => $unp->id, 'slug' => 'derecho-mercantil-ii'],
            ['code_abbr' => 'MER']
        );

        $caseBody = <<<'TXT'
Los hermanos Saavedra quieren constituir una S.A.C. para formalizar la panadería familiar. Uno aporta S/ 40 000 en efectivo, que depositan en una cuenta a nombre de la futura sociedad; el otro aporta el horno industrial y la amasadora, valorizados en un informe que sustenta su precio. Redactan una minuta con el pacto social y el estatuto, la elevan a escritura pública ante notario y la presentan a SUNARP para su inscripción.

El registrador observa el título por dos motivos: (i) el objeto social quedó redactado como «realizar todo tipo de negocios», sin precisar la actividad panadera; y (ii) el aporte del horno y la amasadora no vino acompañado del informe de valorización que sustente el valor asignado. Los hermanos deben decidir cómo subsanar ambas observaciones antes de que la sociedad pueda inscribirse y adquirir personalidad jurídica.

Este es un caso frecuente en la práctica registral peruana: cada requisito de la constitución —desde la precisión del objeto social hasta la valorización de los aportes no dinerarios— protege tanto a los propios socios como a los terceros que contratarán con la sociedad.

BASE NORMATIVA DE REFERENCIA
Ley N.° 26887 (LGS), art. 5 — relación entre el pacto social y el estatuto.
Ley N.° 26887 (LGS), art. 11 — precisión del objeto social.
Ley N.° 26887 (LGS), art. 54 — contenido mínimo del pacto social.
Ley N.° 26887 (LGS), arts. 22 y 25 — aportes: dinerarios, no dinerarios y su valorización.

INSTRUCCIONES
Completen los ejercicios interactivos identificando el contenido del pacto social, la modalidad de constitución, la naturaleza de cada aporte de los hermanos Saavedra y los principios que rigen el capital social. Al final, respondan la pregunta abierta con sus propias palabras. Disponible hoy desde las 7:00 a. m. hasta las 11:59 p. m. Tiempo estimado: 25 a 30 minutos.
TXT;

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $mercantil->id, 'slug' => 'caso-semana-3'],
            [
                'week_number' => 3,
                'type' => 'participacion',
                'title' => 'Actividad Semana 3',
                'case_title' => 'La panadería Saavedra: pacto social, estatuto y capital',
                'unit' => 'Unidad I — Introducción y Constitución de Sociedades',
                'case_body' => $caseBody,
                'status' => 'disponible',
                'access_code' => 'mercantil1709',
                'due_at' => Carbon::parse('2026-09-17 23:59:00', 'America/Lima')->utc(),
                // 24 puntos en total repartidos entre los ejercicios de abajo.
                'pass_percent' => 55,
            ]
        );

        $questions = [
            'Redacten un esquema breve del pacto social y del estatuto de la panadería Saavedra: qué aporta cada hermano, cuál sería el capital social resultante y qué debería decir el objeto social para no ser observado por SUNARP. (Pregunta opcional — valorada hasta con 20 puntos a criterio del docente; no afecta el puntaje automático de los ejercicios).',
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
                'prompt' => 'Según el artículo 5 de la LGS, ¿qué relación existe entre el pacto social y el estatuto?',
                'payload' => [
                    'options' => [
                        'El pacto social contiene al estatuto, que se incorpora como parte integrante de él',
                        'El estatuto contiene al pacto social',
                        'Son documentos independientes, sin relación entre ellos',
                        'El estatuto reemplaza al pacto social una vez inscrita la sociedad',
                    ],
                    'correct' => 0,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => '¿Cuál de las siguientes NO es un requisito exigido por el artículo 54 de la LGS para el pacto social?',
                'payload' => [
                    'options' => [
                        'Los datos de los fundadores',
                        'El monto del capital y los aportes de cada socio',
                        'El registro de una marca para el futuro logo de la sociedad',
                        'El nombramiento de los primeros administradores',
                    ],
                    'correct' => 2,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'Los hermanos Saavedra suscriben todo el capital y otorgan la escritura pública en un solo acto. ¿Qué modalidad de constitución es esta?',
                'payload' => [
                    'options' => [
                        'Constitución simultánea',
                        'Constitución por oferta a terceros',
                        'Constitución por fusión',
                        'Constitución tácita',
                    ],
                    'correct' => 0,
                ],
                'points' => 2,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'El registrador observó el aporte del horno y la amasadora. ¿Qué debieron acompañar los hermanos Saavedra para que ese aporte sea válido?',
                'payload' => [
                    'options' => [
                        'Nada; basta con mencionar el bien en la minuta',
                        'Un informe de valorización que sustente el valor asignado a los bienes',
                        'Una autorización notarial de uso de la maquinaria',
                        'Un contrato de arrendamiento del horno a favor de la sociedad',
                    ],
                    'correct' => 1,
                ],
                'points' => 2,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para cada espacio en blanco.',
                'payload' => [
                    'template' => 'El pacto social ___ al estatuto, y la sociedad se constituye por ___ pública que se ___ en Registros Públicos.',
                    'blanks' => [
                        ['answer' => 'contiene', 'options' => ['contiene', 'excluye', 'reemplaza']],
                        ['answer' => 'escritura', 'options' => ['escritura', 'minuta', 'acta']],
                        ['answer' => 'inscribe', 'options' => ['inscribe', 'deposita', 'archiva']],
                    ],
                ],
                'points' => 2,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para completar el principio de desembolso mínimo.',
                'payload' => [
                    'template' => 'Cada acción suscrita debe estar pagada por lo menos en un ___ %, conforme al principio de desembolso mínimo.',
                    'blanks' => [
                        ['answer' => '25', 'options' => ['25', '50', '10']],
                    ],
                ],
                'points' => 1,
            ],
            [
                'type' => 'fillblank',
                'prompt' => 'Elige la opción correcta para distinguir capital de patrimonio.',
                'payload' => [
                    'template' => 'El capital social es una cifra ___ del estatuto, mientras que el patrimonio es la realidad económica ___ de la sociedad.',
                    'blanks' => [
                        ['answer' => 'fija', 'options' => ['fija', 'variable', 'nula']],
                        ['answer' => 'variable', 'options' => ['variable', 'fija', 'inexistente']],
                    ],
                ],
                'points' => 2,
            ],
            [
                'type' => 'ordering',
                'prompt' => 'Ordena los pasos de la constitución simultánea de una sociedad, tal como los siguieron los hermanos Saavedra.',
                'payload' => [
                    'items' => [
                        ['id' => 'a', 'text' => 'Minuta: pacto social y estatuto, con firma de abogado'],
                        ['id' => 'b', 'text' => 'Aportes: depósito bancario del capital y/o valorización de bienes'],
                        ['id' => 'c', 'text' => 'Escritura pública: el notario eleva la minuta a escritura'],
                        ['id' => 'd', 'text' => 'Inscripción en Registros Públicos (SUNARP): nace la persona jurídica'],
                    ],
                    'correctOrder' => ['a', 'b', 'c', 'd'],
                ],
                'points' => 3,
            ],
            [
                'type' => 'matching',
                'prompt' => 'Toca cada aporte y luego toca la categoría a la que corresponde.',
                'payload' => [
                    'left' => [
                        ['id' => 'a1', 'text' => 'S/ 40 000 depositados en la cuenta bancaria de la sociedad'],
                        ['id' => 'a2', 'text' => 'El horno industrial, con su informe de valorización'],
                        ['id' => 'a3', 'text' => 'La amasadora, con su informe de valorización'],
                        ['id' => 'a4', 'text' => 'El compromiso de uno de los hermanos de trabajar como gerente'],
                        ['id' => 'a5', 'text' => 'Un local comercial aportado con informe de valorización'],
                        ['id' => 'a6', 'text' => 'Una cuenta por cobrar (crédito) cedida a la sociedad'],
                    ],
                    'right' => [
                        ['id' => 'dinerario', 'text' => 'Aporte dinerario'],
                        ['id' => 'no_dinerario', 'text' => 'Aporte no dinerario'],
                        ['id' => 'no_admitido', 'text' => 'No forma capital'],
                    ],
                    'pairs' => [
                        'a1' => 'dinerario',
                        'a2' => 'no_dinerario',
                        'a3' => 'no_dinerario',
                        'a4' => 'no_admitido',
                        'a5' => 'no_dinerario',
                        'a6' => 'no_dinerario',
                    ],
                ],
                'points' => 6,
            ],
            [
                'type' => 'matching',
                'prompt' => 'Empareja cada principio que rige el capital social con su descripción.',
                'payload' => [
                    'left' => [
                        ['id' => 'p1', 'text' => 'Determinación'],
                        ['id' => 'p2', 'text' => 'Integridad (suscripción)'],
                        ['id' => 'p3', 'text' => 'Desembolso mínimo'],
                        ['id' => 'p4', 'text' => 'Estabilidad'],
                    ],
                    'right' => [
                        ['id' => 'r1', 'text' => 'El capital debe constar de forma precisa en el estatuto'],
                        ['id' => 'r2', 'text' => 'Todo el capital debe estar íntegramente suscrito por los socios'],
                        ['id' => 'r3', 'text' => 'Cada acción suscrita debe estar pagada al menos en un 25 %'],
                        ['id' => 'r4', 'text' => 'El capital no puede alterarse sino por los procedimientos legales'],
                    ],
                    'pairs' => ['p1' => 'r1', 'p2' => 'r2', 'p3' => 'r3', 'p4' => 'r4'],
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
        $this->command?->info("Académico: Derecho Mercantil II (UNP) — Actividad Semana 3 sembrada con código de acceso, {$totalPoints} puntos en ".count($exercises).' ejercicios autocalificables y '.count($questions).' pregunta abierta opcional.');
    }
}
