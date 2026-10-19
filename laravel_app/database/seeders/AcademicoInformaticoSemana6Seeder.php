<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use App\Models\AcademicActivityExercise;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Illuminate\Database\Seeder;

/**
 * Curso "Derecho Informático" (UNP) — actividad interactiva y autocalificada de la
 * Semana 6, basada en la Resolución Directoral N.° 314-2026-JUS/DGTAIPD-DPDP
 * (Expediente N.° 96-2025-PTT, 17 de marzo de 2026): procedimiento trilateral de tutela
 * en el que la Dirección de Protección de Datos Personales declaró improcedente la
 * cancelación de una denuncia policial registrada en el SIDPOL de la PNP.
 *
 * Cinco ejercicios largos autocalificables (V/F, ordenar, completar con selector,
 * crucigrama y marcar), 4 puntos cada uno = 20 puntos, con puntaje parcial dentro de
 * cada ejercicio; más un sexto ejercicio opcional de subir un archivo PDF/Word que suma
 * +3 puntos extra sobre la nota (no cuenta para los 20). Mismo patrón que
 * AcademicoInformaticoSemana3Seeder: updateOrCreate por slug/orden, de modo que volver a
 * correrlo nunca reordena ni reasigna ids y no se pierden las respuestas ya guardadas.
 */
class AcademicoInformaticoSemana6Seeder extends Seeder
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
Una persona que postulaba a un puesto de trabajo se enteró de que figuraba en el Sistema Informático de Denuncias Policiales (SIDPOL) de la Policía Nacional del Perú con una denuncia en su contra, registrada el 31 de octubre de 2024. Sostiene que la denuncia es falsa, que le ha cerrado puertas laborales y que afecta su imagen como estudiante universitario. El 22 de abril de 2025 pidió a la Dirección de Tecnología de la Información y Comunicaciones de la PNP (DIRTIC) que la anulara; la DIRTIC le respondió que, para anular un antecedente, debía presentar una copia certificada de la resolución judicial o fiscal que acredite que no se estableció responsabilidad penal (sobreseimiento, absolución, archivamiento definitivo o muerte del inculpado), y no lo hizo.

El reclamante acudió entonces a la Autoridad de Protección de Datos Personales. La Dirección de Fiscalización e Instrucción (DFI) advirtió que lo que pedía era, en realidad, el ejercicio del derecho de cancelación y derivó el caso como procedimiento trilateral de tutela a la Dirección de Protección de Datos Personales (DPDP). Tras observar y admitir la reclamación, y recibir la contestación de la PNP, la DPDP resolvió mediante la Resolución Directoral N.° 314-2026-JUS/DGTAIPD-DPDP, de 17 de marzo de 2026, declarar IMPROCEDENTE la reclamación: la denuncia figuraba como pendiente en el SIDPOL, ningún documento de la autoridad competente la calificaba de irregular o falsa, y la DPDP no puede suponerlo. La resolución recuerda además que la PNP, aunque no necesita el consentimiento del titular para registrar denuncias, sigue obligada por los demás principios de la ley (finalidad, proporcionalidad, calidad y seguridad).

BASE NORMATIVA DE REFERENCIA
Constitución Política del Perú, art. 2, inciso 6, y art. 166.
Ley N.° 29733, Ley de Protección de Datos Personales: arts. 2 (definiciones), 5 y 13.5 (consentimiento), 14 (excepciones), 20 (cancelación).
Reglamento de la LPDP, D.S. N.° 016-2024-JUS: arts. 49 (legitimidad), 82 (supresión o cancelación) y 89 (requisitos de la tutela).
TUO de la Ley N.° 27444 (D.S. N.° 004-2019-JUS): arts. 229 a 238 (procedimiento trilateral); art. 237 (apelación).
Decreto Legislativo N.° 1267, Ley de la PNP: arts. 2 y 43. D.S. N.° 025-2019-IN, art. 4.7.1 (anulación de denuncias).
Resolución Directoral N.° 314-2026-JUS/DGTAIPD-DPDP (Expediente N.° 96-2025-PTT), versión pública.

INSTRUCCIONES
Resuelvan los cinco ejercicios interactivos (verdadero o falso, ordenar, completar palabras, crucigrama y marcar): suman 20 puntos y se califican solos, con puntaje parcial dentro de cada ejercicio. Al final encontrarán un sexto ejercicio opcional en el que pueden subir un archivo PDF o Word para ganar +3 puntos extra. Tiempo estimado: 45 a 60 minutos.
TXT;

        $uploadPrompt = <<<'TXT'
Redacten, como abogados del reclamante, un breve escrito de 1 a 2 páginas (PDF o Word) que responda lo siguiente:
1) ¿Qué documento adicional debió presentar el reclamante ante la PNP según el art. 4.7.1 del D.S. N.° 025-2019-IN, y por qué le habría permitido sustentar la cancelación?
2) Propongan dos argumentos para el recurso de apelación (plazo de 15 días hábiles), apoyándose en el art. 20 de la LPDP y el art. 82 del Reglamento.
3) Expliquen por qué la PNP, aunque no necesita consentimiento para registrar denuncias en el SIDPOL, sigue obligada por los principios de finalidad, proporcionalidad, calidad y seguridad.
Indiquen en la primera línea los nombres de los integrantes del grupo.
TXT;

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $course->id, 'slug' => 'semana-6-tutela-cancelacion-sidpol'],
            [
                'week_number' => 6,
                'type' => 'participacion',
                'title' => 'Actividad Semana 6',
                'case_title' => 'Tutela del derecho de cancelación: la denuncia policial en el SIDPOL',
                'unit' => 'Unidad II — Protección de Datos Personales',
                'case_body' => $caseBody,
                'status' => 'disponible',
                'access_code' => 'tutela1910',
                'due_at' => null,
                // 20 puntos autocalificables (5 ejercicios x 4 pts). El archivo opcional del
                // ejercicio 6 suma +3 extra aparte; el confeti exige 55% (11/20) o más.
                'pass_percent' => 55,
                'upload_prompt' => $uploadPrompt,
                'upload_bonus_points' => 3,
            ]
        );

        $exercises = [
            // ── Ejercicio 1: Verdadero o falso (12 afirmaciones) ─────────────────────────
            [
                'type' => 'vfgroup',
                'prompt' => 'Ejercicio 1 · Verdadero o falso. Marca si cada afirmación sobre la Resolución Directoral N.° 314-2026-JUS/DGTAIPD-DPDP es verdadera o falsa.',
                'payload' => [
                    'statements' => [
                        ['id' => 'v1', 'text' => 'El procedimiento de tutela ante la DPDP es trilateral porque dirime un conflicto entre el titular del dato personal y el titular del banco de datos o responsable del tratamiento.', 'answer' => true],
                        ['id' => 'v2', 'text' => 'La resolución declaró fundada la reclamación y ordenó a la PNP suprimir de inmediato la denuncia del SIDPOL.', 'answer' => false],
                        ['id' => 'v3', 'text' => 'Para iniciar la tutela, el titular debe presentar, entre otros documentos, el cargo de la solicitud que previamente envió al responsable del tratamiento.', 'answer' => true],
                        ['id' => 'v4', 'text' => 'Al registrar denuncias en el SIDPOL, la PNP no realiza tratamiento de datos personales porque actúa en ejercicio de una función pública.', 'answer' => false],
                        ['id' => 'v5', 'text' => 'La PNP no necesita el consentimiento del titular para registrar denuncias en el SIDPOL, pero sigue obligada a respetar los demás principios de la ley.', 'answer' => true],
                        ['id' => 'v6', 'text' => 'El derecho de cancelación es un derecho personalísimo: solo puede ejercerlo el titular de los datos o su representante legal acreditado.', 'answer' => true],
                        ['id' => 'v7', 'text' => 'La DPDP concluyó que la denuncia era falsa porque así lo determinaba expresamente el Oficio N.° 466-2025 del Frente Policial de Ica.', 'answer' => false],
                        ['id' => 'v8', 'text' => 'La DPDP no puede suponer ni concluir que una denuncia es irregular o falsa mientras no exista un pronunciamiento de la autoridad competente que lo determine.', 'answer' => true],
                        ['id' => 'v9', 'text' => 'Según la resolución, una persona es «identificable» cuando, dentro de un grupo de personas, se la distingue de todas las demás.', 'answer' => false],
                        ['id' => 'v10', 'text' => 'Según el art. 82.3 del Reglamento, la supresión implica el cese en el tratamiento de los datos a partir de un bloqueo y su posterior eliminación.', 'answer' => true],
                        ['id' => 'v11', 'text' => 'La competencia para resolver en primera instancia las reclamaciones de tutela de los derechos ARCO corresponde a la Dirección de Protección de Datos Personales.', 'answer' => true],
                        ['id' => 'v12', 'text' => 'Contra la resolución no procede ningún recurso: con ella queda agotada la vía administrativa.', 'answer' => false],
                    ],
                ],
                'points' => 4,
            ],

            // ── Ejercicio 2: Ordenar ideas (9 pasos del procedimiento) ───────────────────
            [
                'type' => 'ordering',
                'prompt' => 'Ejercicio 2 · Ordenar ideas. Ordena cronológicamente los nueve pasos del caso, desde la primera solicitud hasta el recurso que procede contra la resolución. Cada paso en su lugar suma puntos.',
                'payload' => [
                    'partial' => true,
                    'items' => [
                        ['id' => 'o1', 'text' => 'El reclamante pide a la PNP-DIRTIC la anulación (cancelación) de su denuncia registrada en el SIDPOL (22 de abril de 2025).'],
                        ['id' => 'o2', 'text' => 'Presenta un formulario de denuncia ante la DFI, que advierte una solicitud de tutela y la deriva a la DPDP.'],
                        ['id' => 'o3', 'text' => 'La DPDP observa que falta el cargo de la solicitud previa y le da 10 días hábiles para subsanar (Proveído N.° 01).'],
                        ['id' => 'o4', 'text' => 'El reclamante subsana la observación presentando el acuse de registro de su solicitud.'],
                        ['id' => 'o5', 'text' => 'La DPDP admite a trámite el procedimiento trilateral de tutela y corre traslado a la reclamada con 15 días hábiles para contestar (Proveído N.° 02).'],
                        ['id' => 'o6', 'text' => 'La PNP-DIRTIC presenta su contestación (21 de octubre de 2025).'],
                        ['id' => 'o7', 'text' => 'La DPDP requiere a la Comisaría PNP Los Aquijes el Oficio N.° 466-2025 y lo incorpora al expediente.'],
                        ['id' => 'o8', 'text' => 'La DPDP declara improcedente la reclamación y concluye el procedimiento (R.D. N.° 314-2026, 17 de marzo de 2026).'],
                        ['id' => 'o9', 'text' => 'Procede el recurso de apelación dentro de los 15 días de notificada la resolución.'],
                    ],
                    'correctOrder' => ['o1', 'o2', 'o3', 'o4', 'o5', 'o6', 'o7', 'o8', 'o9'],
                ],
                'points' => 4,
            ],

            // ── Ejercicio 3: Completar palabras con barra seleccionable (12 espacios) ────
            [
                'type' => 'fillblank',
                'prompt' => 'Ejercicio 3 · Completar palabras. Toca cada espacio en blanco y elige la opción correcta de la barra seleccionable.',
                'payload' => [
                    'partial' => true,
                    'template' => "El procedimiento de tutela ante la ___ tiene naturaleza ___ y se rige por los artículos 229 a 238 del TUO de la Ley N.° 27444. Para iniciarlo, el titular debe haber reclamado antes ante el ___ del banco de datos o responsable del tratamiento. En el caso, el reclamante pidió la ___ de su denuncia policial registrada en el ___, sistema de la Policía Nacional del Perú.\n\nSegún la resolución, para hablar de datos personales se requiere una ___ vinculable a una persona ___ identificada o identificable. La PNP no necesita el ___ del titular para registrar denuncias, pero siguen vigentes los principios de finalidad, proporcionalidad, ___ y seguridad.\n\nComo no se acreditó que la denuncia fuera irregular o ___, la DPDP declaró ___ la reclamación; contra esa decisión cabe el recurso de ___ dentro de los quince días.",
                    'blanks' => [
                        ['answer' => 'DPDP', 'options' => ['DPDP', 'DFI', 'DIRTIC']],
                        ['answer' => 'trilateral', 'options' => ['trilateral', 'bilateral', 'sancionadora']],
                        ['answer' => 'titular', 'options' => ['titular', 'juez', 'fiscal']],
                        ['answer' => 'cancelación', 'options' => ['cancelación', 'rectificación', 'acceso']],
                        ['answer' => 'SIDPOL', 'options' => ['SIDPOL', 'RENIEC', 'DATAPOL']],
                        ['answer' => 'información', 'options' => ['información', 'sanción', 'resolución']],
                        ['answer' => 'física', 'options' => ['física', 'jurídica', 'colectiva']],
                        ['answer' => 'consentimiento', 'options' => ['consentimiento', 'bloqueo', 'oposición']],
                        ['answer' => 'calidad', 'options' => ['calidad', 'publicidad', 'gratuidad']],
                        ['answer' => 'falsa', 'options' => ['falsa', 'pendiente', 'archivada']],
                        ['answer' => 'improcedente', 'options' => ['improcedente', 'fundada', 'nula']],
                        ['answer' => 'apelación', 'options' => ['apelación', 'reconsideración', 'revisión']],
                    ],
                ],
                'points' => 4,
            ],

            // ── Ejercicio 4: Crucigrama (10 palabras) ────────────────────────────────────
            [
                'type' => 'crossword',
                'prompt' => 'Ejercicio 4 · Crucigrama. Completa las diez palabras con ayuda de las pistas (sin tildes ni espacios). Cada palabra completa suma puntos.',
                'payload' => [
                    'rows' => 16,
                    'cols' => 13,
                    'words' => [
                        ['id' => 'w1', 'number' => 1, 'dir' => 'down', 'row' => 0, 'col' => 5, 'answer' => 'TRILATERAL', 'clue' => 'Naturaleza del procedimiento de tutela: dirime un conflicto entre dos o más administrados.'],
                        ['id' => 'w2', 'number' => 2, 'dir' => 'down', 'row' => 1, 'col' => 8, 'answer' => 'APELACION', 'clue' => 'Recurso que procede contra la resolución dentro de los 15 días de notificada.'],
                        ['id' => 'w3', 'number' => 3, 'dir' => 'down', 'row' => 2, 'col' => 10, 'answer' => 'CONSENTIMIENTO', 'clue' => 'Principio del art. 5 de la LPDP: libre, informado, expreso e inequívoco. La PNP está exceptuada de pedirlo para registrar denuncias.'],
                        ['id' => 'w4', 'number' => 4, 'dir' => 'across', 'row' => 3, 'col' => 0, 'answer' => 'SIDPOL', 'clue' => 'Siglas del Sistema Informático de Denuncias Policiales.'],
                        ['id' => 'w5', 'number' => 5, 'dir' => 'down', 'row' => 4, 'col' => 12, 'answer' => 'RECLAMANTE', 'clue' => 'Así se llama en el procedimiento al titular que pide la tutela de sus datos personales.'],
                        ['id' => 'w6', 'number' => 6, 'dir' => 'down', 'row' => 6, 'col' => 3, 'answer' => 'TUTELA', 'clue' => 'Procedimiento ante la DPDP cuando el responsable deniega total o parcialmente el ejercicio de un derecho ARCO.'],
                        ['id' => 'w7', 'number' => 7, 'dir' => 'across', 'row' => 7, 'col' => 2, 'answer' => 'SUPRESION', 'clue' => 'El art. 20 de la LPDP reconoce el derecho a la ___ de los datos inexactos, incompletos o ya innecesarios.'],
                        ['id' => 'w8', 'number' => 8, 'dir' => 'across', 'row' => 11, 'col' => 0, 'answer' => 'FINALIDAD', 'clue' => 'Principio, junto con proporcionalidad, calidad y seguridad, que la PNP debe respetar aunque no necesite consentimiento.'],
                        ['id' => 'w9', 'number' => 9, 'dir' => 'across', 'row' => 13, 'col' => 1, 'answer' => 'IMPROCEDENTE', 'clue' => 'Sentido de la decisión: la DPDP declaró ___ la reclamación contra la PNP-DIRTIC.'],
                        ['id' => 'w10', 'number' => 10, 'dir' => 'across', 'row' => 15, 'col' => 1, 'answer' => 'CANCELACION', 'clue' => 'Derecho ARCO que ejerció el reclamante para que se suprima su denuncia policial del SIDPOL.'],
                    ],
                ],
                'points' => 4,
            ],

            // ── Ejercicio 5: Marcar (5 preguntas, marca todas las que correspondan) ──────
            [
                'type' => 'multi',
                'prompt' => 'Ejercicio 5 · Marcar. En cada pregunta marca TODAS las opciones que correspondan (pueden ser varias). Cada opción bien decidida suma puntos.',
                'payload' => [
                    'questions' => [
                        [
                            'id' => 'm1',
                            'prompt' => '¿Qué debe presentar el titular para iniciar el procedimiento trilateral de tutela (art. 89 del Reglamento de la LPDP)?',
                            'options' => [
                                'Una sentencia condenatoria contra el responsable del tratamiento',
                                'La solicitud de tutela con los requisitos de la Ley N.° 27444',
                                'Un peritaje oficial de criminalística',
                                'El cargo de la solicitud que previamente envió al responsable del tratamiento',
                                'El documento con la respuesta denegatoria o no satisfactoria del responsable, si la recibió',
                                'Los documentos que acrediten la afectación de su derecho, cuando corresponda',
                            ],
                            'correct' => [1, 3, 4, 5],
                        ],
                        [
                            'id' => 'm2',
                            'prompt' => 'Según la resolución, ¿cuáles de estas afirmaciones sobre los datos personales son correctas?',
                            'options' => [
                                'Solo son datos personales los que el titular mantiene en secreto',
                                'Se requiere la existencia de una información o dato (numérico, alfabético, gráfico, fotográfico, acústico, etc.)',
                                'Basta con que el dato esté en una base de datos digital, aunque no permita identificar a nadie',
                                'La información debe poder vincularse a una persona física identificada o identificable',
                                'Un criterio útil es preguntarse si su conocimiento por terceros puede tener consecuencias para el titular o motivar una decisión que lo afecte',
                                'Una persona es «identificable» cuando, aunque no se la haya identificado todavía, es posible hacerlo directa o indirectamente',
                                'Las personas jurídicas son titulares de datos personales',
                            ],
                            'correct' => [1, 3, 4, 5],
                        ],
                        [
                            'id' => 'm3',
                            'prompt' => '¿Qué sustenta que la PNP registre denuncias en el SIDPOL?',
                            'options' => [
                                'Su función de prevenir, combatir, investigar y denunciar delitos y faltas (art. 2 de la Ley de la PNP)',
                                'Que el SIDPOL es administrado por la Dirección de Protección de Datos Personales',
                                'El Registro Nacional de Seguridad Pública, que incluye antecedentes y referencias policiales',
                                'Que el titular de la denuncia dio su consentimiento previo, expreso y por escrito',
                                'El art. 43 de la Ley de la PNP, que la faculta a emplear sistemas tecnológicos y de información y comunicación policial',
                                'Que el SIDPOL solo puede registrar denuncias de delitos graves',
                            ],
                            'correct' => [0, 2, 4],
                        ],
                        [
                            'id' => 'm4',
                            'prompt' => '¿Por qué razones la DPDP declaró improcedente la reclamación?',
                            'options' => [
                                'El reclamante presentó su solicitud de tutela fuera de plazo',
                                'No existe pronunciamiento de la autoridad competente que determine que la denuncia es irregular o falsa',
                                'El Oficio N.° 466-2025 no dice que la denuncia sea irregular o falsa: solo solicita una auditoría del registro',
                                'La PNP no es titular de un banco de datos personales',
                                'En el SIDPOL la denuncia figura como pendiente, sin documento resultado ni diligenciamiento alguno',
                                'El reclamante no aportó documentación que permita inferir que se trata de una denuncia irregular o falsa',
                            ],
                            'correct' => [1, 2, 4, 5],
                        ],
                        [
                            'id' => 'm5',
                            'prompt' => '¿Qué es cierto sobre el derecho de cancelación?',
                            'options' => [
                                'Es un derecho personalísimo: lo ejerce el titular o su representante acreditado',
                                'Puede ejercerlo cualquier tercero sin acreditar representación',
                                'Procede, entre otros casos, cuando los datos dejaron de ser necesarios o pertinentes para la finalidad con que se recopilaron',
                                'Solo procede cuando el titular ha revocado su consentimiento',
                                'La solicitud puede referirse a todos los datos del titular en un banco de datos o solo a alguna parte de ellos',
                                'Forma parte de los derechos ARCO (acceso, rectificación, cancelación y oposición)',
                            ],
                            'correct' => [0, 2, 4, 5],
                        ],
                    ],
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

        // Si una corrida anterior sembró más ejercicios de los actuales, se retiran los sobrantes.
        AcademicActivityExercise::where('academic_activity_id', $activity->id)
            ->where('order', '>', count($exercises))
            ->delete();

        $totalPoints = array_sum(array_column($exercises, 'points'));
        $this->command?->info("Académico: Derecho Informático (UNP) — Actividad Semana 6 sembrada con código de acceso, {$totalPoints} puntos en ".count($exercises).' ejercicios autocalificables + archivo opcional (+3 extra).');
    }
}
