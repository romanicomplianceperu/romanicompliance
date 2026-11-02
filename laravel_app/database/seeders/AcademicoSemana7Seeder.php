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
 * UNP — Actividad de la Semana 7 de los tres cursos del Dr. Romani:
 *   · Derecho Informático        → El hábeas data (Unidad II)
 *   · Derecho Mercantil II       → El Directorio y la Gerencia (Unidad II)
 *   · Derecho Procesal Administrativo → Nulidad y anulabilidad del acto administrativo (Unidad II)
 *
 * Cada actividad tiene 5 ejercicios largos autocalificables (verdadero o falso, ordenar,
 * completar con selector, crucigrama y marcar; 4 pts c/u = 20 puntos, con puntaje parcial),
 * más un caso complejo con preguntas de desarrollo que revisa el docente y la entrega
 * OBLIGATORIA del trabajo en PDF o Word (se califica aparte, sin puntos extra automáticos). Plazo de los tres cursos: viernes
 * 6 de noviembre de 2026, 8:00 p. m. (hora de Lima); se puede cambiar desde el panel admin
 * (Académico → actividad → «Fecha y hora límite»).
 *
 * Mismo patrón que las demás: updateOrCreate por slug/orden, así que volver a correrlo
 * nunca reordena ni reasigna ids y no se pierden las respuestas ya guardadas.
 */
class AcademicoSemana7Seeder extends Seeder
{
    public function run(): void
    {
        $unp = AcademicUniversity::where('slug', 'unp')->first();

        if (! $unp) {
            $this->command?->error('No se encontró la universidad UNP. Corre primero AcademicoSeeder.');

            return;
        }

        foreach ([$this->informatico(), $this->mercantil(), $this->procesal()] as $config) {
            $this->seed($unp, $config);
        }

        // Solo estas tres actividades (basadas en las diapositivas de la Semana 7) quedan
        // habilitadas. En la Semana 7 solo existe «SEMANA 7 - TRABAJO CALIFICADO»: cualquier
        // otra actividad de Semana 7 creada aparte se cierra y se OCULTA por completo. Las
        // demás semanas se cierran pero siguen listadas, con la etiqueta gris «Vencida».
        // Todo se puede revertir una por una desde el panel admin (Académico → actividad).
        $keep = array_map(fn ($c) => $c['activity']['slug'], [$this->informatico(), $this->mercantil(), $this->procesal()]);

        $hidden = AcademicActivity::whereNotIn('slug', $keep)->where('week_number', 7)
            ->update(['status' => 'cerrada', 'is_hidden' => true]);
        $closed = AcademicActivity::whereNotIn('slug', $keep)->where('week_number', '!=', 7)->where('status', '!=', 'cerrada')
            ->update(['status' => 'cerrada']);
        $this->command?->info("Académico: {$hidden} actividad(es) de Semana 7 ocultas y {$closed} de otras semanas marcadas como vencidas.");
    }

    private function seed(AcademicUniversity $unp, array $config): void
    {
        $course = AcademicCourse::updateOrCreate(
            ['university_id' => $unp->id, 'slug' => $config['course']['slug']],
            $config['course']['attrs']
        );

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $course->id, 'slug' => $config['activity']['slug']],
            [
                'week_number' => 7,
                'type' => 'participacion',
                'title' => 'SEMANA 7 - TRABAJO CALIFICADO',
                'case_title' => $config['activity']['case_title'],
                'unit' => $config['activity']['unit'],
                'case_body' => $config['activity']['case_body'],
                'status' => 'disponible',
                'is_hidden' => false,
                'access_code' => $config['activity']['access_code'],
                // Viernes 6 de noviembre de 2026, 8:00 p. m. (Lima). Editable desde el admin.
                'due_at' => Carbon::parse('2026-11-06 20:00:00', 'America/Lima')->utc(),
                'pass_percent' => 55,
                'upload_prompt' => $config['activity']['upload_prompt'],
                // Entrega del trabajo (PDF/Word) OBLIGATORIA para enviar; la califica el docente,
                // por eso no suma puntos extra automáticos.
                'upload_required' => true,
                'upload_bonus_points' => null,
            ]
        );

        foreach ($config['questions'] as $order => $prompt) {
            AcademicActivityQuestion::updateOrCreate(
                ['academic_activity_id' => $activity->id, 'order' => $order + 1],
                ['prompt' => $prompt]
            );
        }
        AcademicActivityQuestion::where('academic_activity_id', $activity->id)
            ->where('order', '>', count($config['questions']))
            ->delete();

        foreach ($config['exercises'] as $order => $exercise) {
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
        AcademicActivityExercise::where('academic_activity_id', $activity->id)
            ->where('order', '>', count($config['exercises']))
            ->delete();

        $total = array_sum(array_column($config['exercises'], 'points'));
        $this->command?->info("Académico: {$course->name} (UNP) — Actividad Semana 7 sembrada: {$total} pts autocalificables en ".count($config['exercises']).' ejercicios, '.count($config['questions']).' preguntas del caso y entrega obligatoria del trabajo.');
    }

    // ───────────────────────────── DERECHO INFORMÁTICO ─────────────────────────────

    private function informatico(): array
    {
        $caseBody = <<<'TXT'
Marina Quispe, estudiante con discapacidad auditiva y becaria de la «Universidad Norte Andina», descubre que su vida digital se le ha vuelto en contra en tres frentes a la vez. Las cuatro entidades y las fechas de este caso son hipotéticas; lo que sí es real es la jurisprudencia del Tribunal Constitucional que deben aplicar.

LOS HECHOS
Frente 1 — La universidad. En enero de 2026 la universidad publicó en su portal web, en una lista abierta, el nombre completo y la condición de salud (tipo de discapacidad) de todos los becarios. El 3 de marzo Marina envió una carta notarial pidiendo que retiren sus datos. Venció el plazo legal sin respuesta y la lista sigue visible.
Frente 2 — La central de riesgo. El banco «Banca Andina» le negó un crédito para capital de trabajo porque la central de riesgo «InfoScore S.A.» la reporta como deudora de un crédito educativo que ella canceló hace 14 meses. Marina solo reclamó por teléfono al call center de InfoScore; no guarda ningún documento de ese reclamo.
Frente 3 — La municipalidad. Para saber con qué recursos se financian las becas, pidió por mesa de partes a la Municipalidad Provincial copia del convenio firmado con la universidad. Pasaron dos meses sin respuesta; tiene el cargo sellado de su solicitud.
Frente 4 — Las redes. Un usuario con miles de seguidores compartió una captura de la lista y el hecho circula: hay comentarios que la ridiculizan. Marina teme además que, en unos días, un portal de noticias publique «el reportaje» con los nombres, lo cual ya fue anunciado en un correo del medio dirigido a la universidad (Marina tiene copia).
Marina ha consultado a un amigo, que le sugiere presentar una sola demanda de amparo «por afectación al honor». Otro le recomienda acudir solo a la Autoridad de Protección de Datos Personales.

JURISPRUDENCIA DE REFERENCIA
STC 02631-2009-HD/TC: un reporte en central de riesgo no reflejaba la situación real de la persona y le impedía acceder al crédito; el TC reafirmó que la autodeterminación informativa comprende el derecho a que los datos sean veraces, exactos y actualizados, y que quien administra el banco de datos responde por la calidad de lo que difunde. Ordenó corregir o suprimir el dato.
STC 04739-2007-PHD/TC: define la autodeterminación informativa como las facultades de control de la información personal y la distingue de la intimidad; es la sentencia que estructura la materia y los tipos de hábeas data.
(Resúmenes del material de clase. Lean el texto completo y gratuito de ambas sentencias en tc.gob.pe.)

BASE NORMATIVA DE REFERENCIA
Constitución Política del Perú, art. 2, incisos 5 y 6, y art. 200, inciso 3.
Código Procesal Constitucional (Ley N.° 31307): hábeas data, reclamo previo de fecha cierta, medida cautelar.
Ley N.° 29733, Ley de Protección de Datos Personales y su Reglamento (D.S. N.° 016-2024-JUS): datos sensibles, derechos ARCO, tutela ante la ANPD.

INSTRUCCIONES
1) Resuelvan los cinco ejercicios interactivos (20 puntos, se califican solos). 2) Contesten las preguntas del caso en los cuadros de texto: las revisa directamente su docente. 3) Suban su trabajo completo en PDF o Word: la entrega es OBLIGATORIA para poder enviar la actividad. Plazo: viernes 6 de noviembre, 8:00 p. m. Tiempo estimado: 90 minutos.
TXT;

        $questions = [
            'Frente por frente (universidad, central de riesgo y municipalidad): identifiquen el derecho afectado (art. 2.5 o 2.6), el tipo de hábeas data que corresponde y contra quién se dirige. Presenten su respuesta en un cuadro de tres filas.',
            '¿Cumplió Marina el requisito del reclamo previo de fecha cierta en cada frente? Expliquen qué ocurriría hoy si demanda a InfoScore con el solo reclamo telefónico, y qué debió hacer. ¿Tiene ya acreditado el reclamo en el frente de la municipalidad? Fundamenten.',
            'Redacten el petitorio (principal y accesorios) de la demanda contra la universidad e indiquen con qué argumentos pedirían la medida cautelar: verosimilitud del derecho y peligro en la demora. ¿Qué ordenaría exactamente la medida?',
            '¿Es correcto el consejo de presentar un amparo «por afectación al honor» en lugar de un hábeas data? Fundamenten la vía elegida con el criterio del núcleo del conflicto y expliquen qué podría pasar si se elige mal.',
            'A partir de la STC 02631-2009-HD/TC y la STC 04739-2007-PHD/TC, desarrollen los argumentos de fondo contra InfoScore sobre veracidad del dato y responsabilidad del titular del banco de datos por su calidad. ¿Qué tipo de hábeas data y qué orden concreta pedirían?',
            '¿Procede una acción preventiva ante el anunciado reportaje del portal de noticias («amenaza»)? Expliquen cuándo una amenaza es «cierta e inminente», qué pruebas aportarían y cómo se tensiona este caso con la libertad de información (derecho al olvido y ponderación).',
            '¿Conviene que Marina acuda además a la ANPD (tutela administrativa)? ¿Son vías excluyentes o acumulables? Propongan la estrategia conjunta y su orden en el tiempo.',
        ];

        $uploadPrompt = <<<'TXT'
Trabajo del caso (PDF o Word, máximo 5 páginas). Redacten como equipo la DEMANDA DE HÁBEAS DATA de Marina contra la universidad, con: sumilla, petitorio principal y accesorios, fundamentos de hecho, fundamentos de derecho (art. 2.6 y 200.3 de la Constitución, Código Procesal Constitucional, Ley 29733, STC 04739-2007-PHD/TC y STC 02631-2009-HD/TC), medios probatorios, y el pedido de medida cautelar con su justificación.
Al final agreguen un cuadro-resumen con la estrategia de los otros tres frentes (central de riesgo, municipalidad y portal de noticias).
Indiquen en la primera línea los nombres de los integrantes del grupo.
TXT;

        return [
            'course' => [
                'slug' => 'derecho-informatico',
                'attrs' => [
                    'code_abbr' => 'INF',
                    'name' => 'Derecho Informático',
                    'subtitle' => 'Protección de Datos Personales',
                    'faculty' => 'Facultad de Derecho y Ciencias Políticas',
                    'period' => '2026-II',
                    'total_weeks' => 16,
                    'status' => 'active',
                ],
            ],
            'activity' => [
                'slug' => 'semana-7-habeas-data',
                'case_title' => 'El hábeas data: reclamo previo, tipo y medida cautelar',
                'unit' => 'Unidad II — La tutela constitucional de los datos personales',
                'access_code' => 'digital20262',
                'case_body' => $caseBody,
                'upload_prompt' => $uploadPrompt,
            ],
            'questions' => $questions,
            'exercises' => [
                [
                    'type' => 'vfgroup',
                    'prompt' => 'Ejercicio 1 · Verdadero o falso. Marca si cada afirmación sobre el hábeas data es verdadera o falsa.',
                    'payload' => [
                        'statements' => [
                            ['id' => 'v1', 'text' => 'El hábeas data procede únicamente contra autoridades públicas; no contra empresas privadas como una central de riesgo.', 'answer' => false],
                            ['id' => 'v2', 'text' => 'El art. 200, inciso 3, de la Constitución protege los derechos reconocidos en el art. 2, incisos 5 y 6.', 'answer' => true],
                            ['id' => 'v3', 'text' => 'El hábeas data rectificador sirve para corregir un dato inexacto o falso que causa perjuicio.', 'answer' => true],
                            ['id' => 'v4', 'text' => 'Antes de demandar, el titular debe reclamar al responsable por documento de fecha cierta; olvidarlo es una causa frecuente de improcedencia.', 'answer' => true],
                            ['id' => 'v5', 'text' => 'El amparo es el proceso especializado en protección de datos y el hábeas data es el proceso residual.', 'answer' => false],
                            ['id' => 'v6', 'text' => 'El hábeas data es un proceso sumario y de tramitación preferente.', 'answer' => true],
                            ['id' => 'v7', 'text' => 'Para acudir al juez se debe agotar siempre la vía administrativa ante la ANPD.', 'answer' => false],
                            ['id' => 'v8', 'text' => 'En el hábeas data el Estado está exento de la condena de costas y costos.', 'answer' => true],
                            ['id' => 'v9', 'text' => 'Basta un temor genérico («quizá algún día usen mis datos») para que proceda el hábeas data preventivo.', 'answer' => false],
                            ['id' => 'v10', 'text' => 'El hábeas data cancelatorio o excluyente permite suprimir datos sensibles o de tratamiento indebido.', 'answer' => true],
                            ['id' => 'v11', 'text' => 'La tutela ante la ANPD y el hábeas data son excluyentes: elegir una impide acudir a la otra.', 'answer' => false],
                            ['id' => 'v12', 'text' => 'La STC 04739-2007-PHD/TC define la autodeterminación informativa como facultades de control de la información personal y la distingue de la intimidad.', 'answer' => true],
                        ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'ordering',
                    'prompt' => 'Ejercicio 2 · Ordenar ideas. Ordena el camino completo del hábeas data, desde el reclamo previo hasta la ejecución de la sentencia. Cada paso en su lugar suma puntos.',
                    'payload' => [
                        'partial' => true,
                        'items' => [
                            ['id' => 'o1', 'text' => 'Reclamo previo por documento de fecha cierta (carta notarial o cargo de mesa de partes) al responsable del banco de datos.'],
                            ['id' => 'o2', 'text' => 'Vence el plazo legal sin respuesta, o el responsable responde negando el pedido: queda habilitada la vía.'],
                            ['id' => 'o3', 'text' => 'Se presenta la demanda ante el juez constitucional, identificando el tipo de hábeas data y el petitorio concreto.'],
                            ['id' => 'o4', 'text' => 'Si la lesión es urgente, el juez resuelve la medida cautelar pedida con la demanda (verosimilitud y peligro en la demora).'],
                            ['id' => 'o5', 'text' => 'Trámite sumarísimo y preferente, resuelto sobre prueba documental, y sentencia que ordena acceder, rectificar o suprimir.'],
                            ['id' => 'o6', 'text' => 'Apelación de la sentencia dentro de tres días hábiles.'],
                            ['id' => 'o7', 'text' => 'Ejecución de la sentencia: el juez vela por su cumplimiento y aplica apremios si el responsable no cumple.'],
                            ['id' => 'o8', 'text' => 'Si tras la sentencia se repite la lesión, se pide su represión como acto homogéneo, sin nuevo proceso.'],
                        ],
                        'correctOrder' => ['o1', 'o2', 'o3', 'o4', 'o5', 'o6', 'o7', 'o8'],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'fillblank',
                    'prompt' => 'Ejercicio 3 · Completar palabras. Toca cada espacio en blanco y elige la opción correcta de la barra seleccionable.',
                    'payload' => [
                        'partial' => true,
                        'template' => "El hábeas data está previsto en el art. ___, inciso 3, de la Constitución y protege el acceso a la información ___ y la autodeterminación informativa. Procede contra cualquier autoridad, funcionario o ___, incluidos los privados.\n\nAntes de demandar se debe reclamar por documento de fecha ___ y esperar el plazo legal. Si el dato es falso se pide el hábeas data ___; si debe eliminarse, el hábeas data ___. El proceso es ágil y se resuelve sobre prueba ___.\n\nEn lesiones urgentes se solicita una medida ___, y contra la sentencia procede apelación en ___ días hábiles.",
                        'blanks' => [
                            ['answer' => '200', 'options' => ['200', '2', '139']],
                            ['answer' => 'pública', 'options' => ['pública', 'privada', 'reservada']],
                            ['answer' => 'persona', 'options' => ['persona', 'juez', 'fiscal']],
                            ['answer' => 'cierta', 'options' => ['cierta', 'dudosa', 'reciente']],
                            ['answer' => 'rectificador', 'options' => ['rectificador', 'informativo', 'aditivo']],
                            ['answer' => 'cancelatorio', 'options' => ['cancelatorio', 'informativo', 'aditivo']],
                            ['answer' => 'documental', 'options' => ['documental', 'pericial', 'testimonial']],
                            ['answer' => 'cautelar', 'options' => ['cautelar', 'coercitiva', 'sancionadora']],
                            ['answer' => 'tres', 'options' => ['tres', 'quince', 'diez']],
                        ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'crossword',
                    'prompt' => 'Ejercicio 4 · Crucigrama. Completa las diez palabras con ayuda de las pistas (sin tildes ni espacios). Cada palabra completa suma puntos.',
                    'payload' => [
                    'rows' => 15,
                    'cols' => 12,
                    'words' => [
                        ['id' => 'w1', 'number' => 1, 'dir' => 'down', 'row' => 0, 'col' => 6, 'answer' => 'CANCELATORIO', 'clue' => 'Tipo de hábeas data que busca suprimir o excluir datos sensibles o de tratamiento indebido.'],
                        ['id' => 'w2', 'number' => 2, 'dir' => 'across', 'row' => 1, 'col' => 3, 'answer' => 'VERACIDAD', 'clue' => 'Cualidad de un dato que corresponde a la realidad; la STC 02631-2009-HD/TC la reafirma como contenido de la autodeterminación informativa.'],
                        ['id' => 'w3', 'number' => 3, 'dir' => 'down', 'row' => 1, 'col' => 8, 'answer' => 'INFORMATIVO', 'clue' => 'Tipo de hábeas data para saber qué datos existen sobre uno, quién los tiene y con qué fin.'],
                        ['id' => 'w4', 'number' => 4, 'dir' => 'down', 'row' => 1, 'col' => 10, 'answer' => 'AMPARO', 'clue' => 'Proceso residual que protege los demás derechos constitucionales; no debe confundirse con el hábeas data.'],
                        ['id' => 'w5', 'number' => 5, 'dir' => 'down', 'row' => 3, 'col' => 2, 'answer' => 'NOTARIAL', 'clue' => 'Carta ___: ejemplo de documento de fecha cierta para el reclamo previo.'],
                        ['id' => 'w6', 'number' => 6, 'dir' => 'down', 'row' => 3, 'col' => 4, 'answer' => 'SUMARISIMO', 'clue' => 'Trámite del hábeas data: proceso ___ y de tramitación preferente.'],
                        ['id' => 'w7', 'number' => 7, 'dir' => 'down', 'row' => 7, 'col' => 0, 'answer' => 'CAUTELAR', 'clue' => 'Tipo de medida provisional que se pide con la demanda ante una lesión urgente (dato de salud expuesto, crédito bloqueado).'],
                        ['id' => 'w8', 'number' => 8, 'dir' => 'across', 'row' => 8, 'col' => 0, 'answer' => 'ADITIVO', 'clue' => 'Tipo de hábeas data para incorporar o actualizar un dato que falta o está desactualizado.'],
                        ['id' => 'w9', 'number' => 9, 'dir' => 'down', 'row' => 8, 'col' => 10, 'answer' => 'RECLAMO', 'clue' => 'Requisito previo de procedibilidad: el ___ por documento de fecha cierta al responsable del banco de datos.'],
                        ['id' => 'w10', 'number' => 10, 'dir' => 'across', 'row' => 14, 'col' => 0, 'answer' => 'RECTIFICADOR', 'clue' => 'Tipo de hábeas data para corregir un dato inexacto o falso que causa perjuicio.'],
                    ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'multi',
                    'prompt' => 'Ejercicio 5 · Marcar. En cada pregunta marca TODAS las opciones que correspondan (pueden ser varias). Cada opción bien decidida suma puntos.',
                    'payload' => [
                        'questions' => [
                            [
                                'id' => 'm1',
                                'prompt' => '¿Qué derechos protege el hábeas data según el art. 200, inciso 3, de la Constitución?',
                                'options' => [
                                    'La libertad de tránsito',
                                    'La autodeterminación informativa (art. 2.6)',
                                    'El acceso a la información pública (art. 2.5)',
                                    'El derecho de propiedad',
                                    'La libertad de reunión',
                                ],
                                'correct' => [1, 2],
                            ],
                            [
                                'id' => 'm2',
                                'prompt' => '¿Cuáles son tipos de hábeas data reconocidos por el Tribunal Constitucional?',
                                'options' => [
                                    'Sancionador',
                                    'Informativo',
                                    'Reservador',
                                    'Punitivo',
                                    'Rectificador',
                                    'Aditivo',
                                    'Cancelatorio o excluyente',
                                ],
                                'correct' => [1, 2, 4, 5, 6],
                            ],
                            [
                                'id' => 'm3',
                                'prompt' => 'Antes de demandar, ¿qué conviene tener listo (checklist del litigante)?',
                                'options' => [
                                    'Una sentencia firme de la ANPD',
                                    'El reclamo previo por documento de fecha cierta',
                                    'Un título de propiedad',
                                    'La constancia de que venció el plazo o hubo negativa',
                                    'La prueba documental del dato lesivo',
                                    'La evaluación de si hace falta una medida cautelar',
                                ],
                                'correct' => [1, 3, 4, 5],
                            ],
                            [
                                'id' => 'm4',
                                'prompt' => '¿Qué rasgos tiene el proceso de hábeas data?',
                                'options' => [
                                    'Es una garantía constitucional, no un proceso civil genérico',
                                    'Exige agotar primero la vía administrativa',
                                    'Procede también contra personas y empresas privadas',
                                    'Tiene una amplia y compleja etapa probatoria',
                                    'Es sumario y de tramitación preferente',
                                ],
                                'correct' => [0, 2, 4],
                            ],
                            [
                                'id' => 'm5',
                                'prompt' => '¿Qué establecen las sentencias del TC estudiadas en clase?',
                                'options' => [
                                    'La STC 04739-2007-PHD/TC define la autodeterminación informativa como facultades de control de la información personal',
                                    'El hábeas data solo procede contra el Estado',
                                    'La STC 02631-2009-HD/TC consagra la veracidad del dato como contenido del derecho',
                                    'La autodeterminación informativa es lo mismo que la intimidad',
                                    'El titular del banco de datos responde por la calidad del dato que difunde',
                                    'Un dato inexacto en una central de riesgo debe mantenerse hasta que el banco lo revise',
                                ],
                                'correct' => [0, 2, 4],
                            ],
                        ],
                    ],
                    'points' => 4,
                ],
            ],
        ];
    }

    // ───────────────────────────── DERECHO MERCANTIL II ─────────────────────────────

    private function mercantil(): array
    {
        $caseBody = <<<'TXT'
«Agroexportadora Pampa Verde S.A.» es una sociedad anónima (no una S.A.C.) dedicada a la exportación de frutas. Todas las personas, cifras y fechas de este caso son hipotéticas y han sido diseñadas para que apliquen los artículos 153 a 190 de la Ley General de Sociedades.

LOS HECHOS
Capital: 1 000 000 de acciones con derecho a voto. Accionistas: Grupo Zegarra (550 000 acciones), Inversiones Rivas S.A.C. (250 000) y el señor Manuel Torres (200 000).
En la junta de 2025 se eligieron cinco directores con voto acumulativo (cada acción dio cinco votos). El señor Torres concentró todos sus votos en una sola candidata: la señora Elena Montes, que resultó elegida. Los otros cuatro directores son el presidente, Carlos Zegarra; dos directores del Grupo Zegarra; y el señor Julio Ríos, propuesto por Inversiones Rivas, quien además trabaja como servidor en el área de fiscalización de la SUNAT que audita a la sociedad.
El 15 de febrero de 2025 el directorio aprobó por 3 votos a favor (Zegarra y los dos directores del grupo), 1 en contra y 1 abstención un contrato de «consultoría logística» con «Logística Zegarra E.I.R.L.», empresa del presidente, con un pago adelantado de S/ 1 200 000 sin ninguna prestación verificable. El presidente votó a favor y no manifestó su interés. La señora Montes votó en contra, pero el acta solo dice «se aprobó por mayoría»; diez días después envió una carta notarial a la sociedad dejando constancia de su desacuerdo. El señor Ríos se abstuvo de votar sin pedir que constara nada.
El gerente general, el señor Salas, ejecutó el pago, ocultó la operación en los reportes a la junta y, meses después, usó S/ 300 000 de la sociedad para pagar deudas de su propia empresa personal. También firmó un contrato de garantía con el banco «Banca Austral» que excedía las facultades inscritas en SUNARP; el banco conocía esa limitación porque su propio informe legal la señalaba.
Un proveedor, «Empaques Sur S.A.C.», cobró con un cheque de la sociedad sin fondos y quedó perjudicado en S/ 80 000.
Hoy es noviembre de 2026. El señor Torres acaba de descubrir todo al revisar los libros. La mayoría de la junta, controlada por el Grupo Zegarra, ya anunció que no acordará demandar a nadie.

BASE NORMATIVA DE REFERENCIA
Ley N.° 26887, Ley General de Sociedades: arts. 153-157 y 164 (directorio y voto acumulativo), 161 (impedimentos), 171-180 (deberes, responsabilidad y conflicto de interés), 177-178 (responsabilidad solidaria y exención), 181 y 184 (pretensiones social e individual), 185-190 (gerencia).
Código Penal, art. 198 (administración fraudulenta) y Ley N.° 30424 (responsabilidad administrativa de la persona jurídica).

INSTRUCCIONES
1) Resuelvan los cinco ejercicios interactivos (20 puntos, se califican solos). 2) Contesten las preguntas del caso en los cuadros de texto: las revisa directamente su docente. 3) Suban su trabajo completo en PDF o Word: la entrega es OBLIGATORIA para poder enviar la actividad. Plazo: viernes 6 de noviembre, 8:00 p. m. Tiempo estimado: 90 minutos.
TXT;

        $questions = [
            'Voto acumulativo (art. 164): con las cifras del caso, demuestren numéricamente si el señor Torres podía asegurar un puesto en el directorio aunque el Grupo Zegarra y Rivas votaran juntos. Muestren el cálculo de votos totales, votos de cada bloque y por qué la mayoría no podía copar los cinco cargos.',
            '¿Tenía impedimento el señor Ríos para ser director (art. 161)? Expliquen la razón de ser del impedimento (independencia, lealtad, idoneidad) y las consecuencias para el directorio y para los acuerdos en los que participó.',
            'Directorio: analicen uno por uno a los cinco directores bajo los arts. 177, 178 y 180. ¿Quién responde, quién se exime y por qué? Resuelvan especialmente (a) el caso de la señora Montes, que dejó constancia solo por carta notarial diez días después, y (b) el del señor Ríos, que se abstuvo sin dejar constancia. Incluyan el deber de abstención del presidente.',
            'Gerencia: ¿de qué responde el señor Salas según el art. 190? Clasifiquen sus conductas. Sobre el contrato de garantía con Banca Austral: ¿obliga a la sociedad pese a exceder las facultades del gerente? Expliquen el rol de la buena fe del tercero y de las facultades inscritas en SUNARP.',
            'Pretensiones (arts. 181 y 184): ¿qué pretensión corresponde a la sociedad y cuál a Empaques Sur S.A.C.? Como el Grupo Zegarra controla la junta, ¿cómo puede el señor Torres ejercer la pretensión social? Calculen si, solo o aliado con Inversiones Rivas, alcanza el porcentaje exigido y expliquen quién recibe lo recuperado.',
            'Caducidad (art. 184): calculen hasta qué fecha puede demandarse, desde cuándo corre el plazo y por qué importa que sea de caducidad y no de prescripción. Propongan el cronograma de acciones del señor Torres.',
            'Más allá de lo civil: ¿qué delitos podrían configurarse (por ejemplo, administración fraudulenta, art. 198 del Código Penal)? ¿Qué relevancia tiene la Ley N.° 30424 para la sociedad y qué medidas de compliance habrían evitado el caso?',
        ];

        $uploadPrompt = <<<'TXT'
Trabajo del caso (PDF o Word, máximo 5 páginas). Redacten como equipo un INFORME JURÍDICO dirigido al accionista Manuel Torres, con: (1) resumen de los hechos relevantes, (2) mapa de responsables —cada director y el gerente— con su fundamento legal y la posible exención, (3) pretensiones disponibles (social e individual), quién las ejerce y con qué porcentaje, (4) cronograma de acciones con la fecha límite de caducidad, y (5) riesgos y recomendaciones de gobierno corporativo.
Indiquen en la primera línea los nombres de los integrantes del grupo.
TXT;

        return [
            'course' => [
                'slug' => 'derecho-mercantil-ii',
                'attrs' => [
                    'code_abbr' => 'MER',
                    'name' => 'Derecho Mercantil II',
                    'subtitle' => 'Sociedades',
                    'faculty' => 'Facultad de Derecho y Ciencias Políticas',
                    'period' => '2026-II',
                    'total_weeks' => 16,
                    'status' => 'active',
                ],
            ],
            'activity' => [
                'slug' => 'semana-7-directorio-gerencia',
                'case_title' => 'Pampa Verde S.A.: quién administra y de qué responde',
                'unit' => 'Unidad II — La administración de la sociedad anónima',
                'access_code' => 'mercantil0611',
                'case_body' => $caseBody,
                'upload_prompt' => $uploadPrompt,
            ],
            'questions' => $questions,
            'exercises' => [
                [
                    'type' => 'vfgroup',
                    'prompt' => 'Ejercicio 1 · Verdadero o falso. Marca si cada afirmación sobre el Directorio y la Gerencia es verdadera o falsa.',
                    'payload' => [
                        'statements' => [
                            ['id' => 'v1', 'text' => 'El Directorio es un órgano colegiado: decide en conjunto, por mayoría de votos.', 'answer' => true],
                            ['id' => 'v2', 'text' => 'El directorio debe tener no menos de dos miembros.', 'answer' => false],
                            ['id' => 'v3', 'text' => 'En la S.A.C. puede prescindirse del directorio; sus funciones las asume la gerencia.', 'answer' => true],
                            ['id' => 'v4', 'text' => 'El voto acumulativo (art. 164) sirve para que la mayoría se asegure todos los puestos del directorio.', 'answer' => false],
                            ['id' => 'v5', 'text' => 'Los directores responden de forma limitada y mancomunada por sus acuerdos contrarios a la ley.', 'answer' => false],
                            ['id' => 'v6', 'text' => 'Queda exento de responsabilidad el director que, habiendo participado, dejó constancia de su desacuerdo en el acta o por carta notarial (art. 178).', 'answer' => true],
                            ['id' => 'v7', 'text' => 'El director que guarda silencio «para no incomodar» queda exento de responsabilidad.', 'answer' => false],
                            ['id' => 'v8', 'text' => 'El director con interés personal en un asunto debe manifestarlo y abstenerse de votar (art. 180).', 'answer' => true],
                            ['id' => 'v9', 'text' => 'Los directores responden por el simple fracaso comercial del negocio (riesgo empresarial).', 'answer' => false],
                            ['id' => 'v10', 'text' => 'El gerente puede ser removido libremente por el directorio o la junta (art. 187).', 'answer' => true],
                            ['id' => 'v11', 'text' => 'En la pretensión social, lo recuperado ingresa al bolsillo del accionista que demandó.', 'answer' => false],
                            ['id' => 'v12', 'text' => 'La responsabilidad de directores y gerentes caduca a los dos años del acuerdo o acto dañoso; es plazo de caducidad, no de prescripción.', 'answer' => true],
                        ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'ordering',
                    'prompt' => 'Ejercicio 2 · Ordenar ideas. Ordena el camino de la pretensión social, desde el acto dañoso hasta el destino de lo recuperado. Cada paso en su lugar suma puntos.',
                    'payload' => [
                        'partial' => true,
                        'items' => [
                            ['id' => 'o1', 'text' => 'Ocurre el acuerdo o acto dañoso del directorio o de la gerencia (aquí empieza a correr el plazo de caducidad).'],
                            ['id' => 'o2', 'text' => 'El socio detecta y documenta la gestión dañina: actas, libros, extractos y estados financieros.'],
                            ['id' => 'o3', 'text' => 'Pide que se convoque a junta para que decida si la sociedad ejerce la pretensión social.'],
                            ['id' => 'o4', 'text' => 'La junta acuerda demandar al director o gerente, lo que implica su remoción automática; o la junta no actúa.'],
                            ['id' => 'o5', 'text' => 'Si la junta no actúa, accionistas que representen al menos un tercio del capital ejercen directamente la pretensión.'],
                            ['id' => 'o6', 'text' => 'La demanda se presenta dentro de los dos años, antes de que caduque el derecho.'],
                            ['id' => 'o7', 'text' => 'Sentencia que condena solidariamente a los administradores responsables.'],
                            ['id' => 'o8', 'text' => 'Lo recuperado ingresa al patrimonio de la sociedad.'],
                        ],
                        'correctOrder' => ['o1', 'o2', 'o3', 'o4', 'o5', 'o6', 'o7', 'o8'],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'fillblank',
                    'prompt' => 'Ejercicio 3 · Completar palabras. Toca cada espacio en blanco y elige la opción correcta de la barra seleccionable.',
                    'payload' => [
                        'partial' => true,
                        'template' => "El Directorio es un órgano ___ que debe tener no menos de ___ miembros y cuyo período no excede de ___ años. El voto ___ (art. 164) permite a la minoría elegir directores. El directorio dirige; la ___ ejecuta y representa a la sociedad.\n\nLos directores responden de manera ilimitada y ___ (art. 177), salvo quien dejó ___ de su desacuerdo en el acta (art. 178). El director con interés personal debe ___ de votar (art. 180).\n\nEl gerente responde por los ___ sociales y la veracidad de los libros (art. 190). La acción de responsabilidad ___ a los dos años.",
                        'blanks' => [
                            ['answer' => 'colegiado', 'options' => ['colegiado', 'unipersonal', 'consultivo']],
                            ['answer' => 'tres', 'options' => ['tres', 'dos', 'cinco']],
                            ['answer' => 'tres', 'options' => ['tres', 'cinco', 'diez']],
                            ['answer' => 'acumulativo', 'options' => ['acumulativo', 'secreto', 'múltiple']],
                            ['answer' => 'gerencia', 'options' => ['gerencia', 'junta', 'auditoría']],
                            ['answer' => 'solidaria', 'options' => ['solidaria', 'mancomunada', 'subsidiaria']],
                            ['answer' => 'constancia', 'options' => ['constancia', 'silencio', 'copia']],
                            ['answer' => 'abstenerse', 'options' => ['abstenerse', 'retirarse', 'renunciar']],
                            ['answer' => 'fondos', 'options' => ['fondos', 'bonos', 'dividendos']],
                            ['answer' => 'caduca', 'options' => ['caduca', 'prescribe', 'se suspende']],
                        ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'crossword',
                    'prompt' => 'Ejercicio 4 · Crucigrama. Completa las diez palabras con ayuda de las pistas (sin tildes ni espacios). Cada palabra completa suma puntos.',
                    'payload' => [
                    'rows' => 13,
                    'cols' => 17,
                    'words' => [
                        ['id' => 'w1', 'number' => 1, 'dir' => 'across', 'row' => 0, 'col' => 1, 'answer' => 'SOLIDARIA', 'clue' => 'Responsabilidad de los directores: ilimitada y ___ (art. 177).'],
                        ['id' => 'w2', 'number' => 2, 'dir' => 'down', 'row' => 0, 'col' => 8, 'answer' => 'INDIVIDUAL', 'clue' => 'Pretensión (art. 184) del accionista o tercero directamente dañado en su patrimonio.'],
                        ['id' => 'w3', 'number' => 3, 'dir' => 'down', 'row' => 0, 'col' => 12, 'answer' => 'GERENTE', 'clue' => 'Órgano ejecutivo que ejecuta los acuerdos y representa a la sociedad; es de remoción libre.'],
                        ['id' => 'w4', 'number' => 4, 'dir' => 'across', 'row' => 2, 'col' => 0, 'answer' => 'CADUCIDAD', 'clue' => 'Plazo de dos años para demandar a directores y gerentes; no se interrumpe ni se suspende.'],
                        ['id' => 'w5', 'number' => 5, 'dir' => 'down', 'row' => 2, 'col' => 5, 'answer' => 'IMPEDIMENTO', 'clue' => 'Causa que inhabilita para ser director (art. 161), como la quiebra o la incapacidad.'],
                        ['id' => 'w6', 'number' => 6, 'dir' => 'down', 'row' => 2, 'col' => 15, 'answer' => 'SOCIAL', 'clue' => 'Pretensión (art. 181) cuando el daño lo sufre la sociedad; lo recuperado ingresa a su patrimonio.'],
                        ['id' => 'w7', 'number' => 7, 'dir' => 'across', 'row' => 5, 'col' => 7, 'answer' => 'DIRECTORIO', 'clue' => 'Órgano colegiado que dirige y administra la sociedad anónima (no menos de tres miembros).'],
                        ['id' => 'w8', 'number' => 8, 'dir' => 'down', 'row' => 6, 'col' => 2, 'answer' => 'LEALTAD', 'clue' => 'Deber fiduciario de anteponer el interés de la sociedad al propio.'],
                        ['id' => 'w9', 'number' => 9, 'dir' => 'across', 'row' => 8, 'col' => 2, 'answer' => 'ACUMULATIVO', 'clue' => 'Voto que permite concentrar todos los votos en una sola persona al elegir el directorio (art. 164).'],
                        ['id' => 'w10', 'number' => 10, 'dir' => 'across', 'row' => 11, 'col' => 2, 'answer' => 'ABSTENCION', 'clue' => 'Deber del director con interés personal en un asunto: manifestarlo y tener ___ de votar (art. 180).'],
                    ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'multi',
                    'prompt' => 'Ejercicio 5 · Marcar. En cada pregunta marca TODAS las opciones que correspondan (pueden ser varias). Cada opción bien decidida suma puntos.',
                    'payload' => [
                        'questions' => [
                            [
                                'id' => 'm1',
                                'prompt' => '¿Cuáles son deberes del director?',
                                'options' => [
                                    'Garantizar utilidades anuales a los accionistas',
                                    'Diligencia de un ordenado comerciante y un representante leal',
                                    'Lealtad: anteponer el interés de la sociedad al propio',
                                    'Votar siempre con la mayoría para evitar conflictos',
                                    'Reserva sobre los negocios sociales',
                                    'Abstenerse de votar cuando tiene interés personal',
                                ],
                                'correct' => [1, 2, 4, 5],
                            ],
                            [
                                'id' => 'm2',
                                'prompt' => '¿Quiénes no pueden ser directores (art. 161)?',
                                'options' => [
                                    'Los accionistas minoritarios',
                                    'Los incapaces',
                                    'Los quebrados',
                                    'Los mayores de 65 años',
                                    'Los servidores públicos de entidades que fiscalizan a la sociedad',
                                    'Quien tenga pleito pendiente con la sociedad como demandante',
                                ],
                                'correct' => [1, 2, 4, 5],
                            ],
                            [
                                'id' => 'm3',
                                'prompt' => 'Según los arts. 177 y 178, ¿quién responde por un acuerdo del directorio contrario a la ley?',
                                'options' => [
                                    'El director que votó en contra y dejó constancia en el acta',
                                    'El director que votó a favor del acuerdo lesivo',
                                    'El director que no participó en el acuerdo',
                                    'El director que participó y guardó silencio «para no incomodar»',
                                    'El presidente que votó a favor del acuerdo en el que tenía interés personal',
                                ],
                                'correct' => [1, 3, 4],
                            ],
                            [
                                'id' => 'm4',
                                'prompt' => '¿De qué responde el gerente según el art. 190?',
                                'options' => [
                                    'Del fracaso comercial del negocio, aunque haya actuado con diligencia',
                                    'De la veracidad y regularidad de los libros y registros',
                                    'De la conservación de los fondos sociales',
                                    'Del empleo de recursos sociales en negocios distintos del objeto',
                                    'De las decisiones de la junta en las que votó en contra',
                                    'Del ocultamiento de irregularidades',
                                ],
                                'correct' => [1, 2, 3, 5],
                            ],
                            [
                                'id' => 'm5',
                                'prompt' => '¿Qué es cierto de la pretensión social?',
                                'options' => [
                                    'La ejerce la sociedad, previo acuerdo de junta',
                                    'El resarcimiento es para el accionista que demandó',
                                    'Si la junta no actúa, pueden ejercerla accionistas que representen al menos un tercio del capital',
                                    'No tiene plazo para ejercerse',
                                    'El acuerdo de promoverla implica la remoción automática del demandado',
                                    'Lo recuperado ingresa al patrimonio de la sociedad',
                                ],
                                'correct' => [0, 2, 4, 5],
                            ],
                        ],
                    ],
                    'points' => 4,
                ],
            ],
        ];
    }

    // ─────────────────────── DERECHO PROCESAL ADMINISTRATIVO ───────────────────────

    private function procesal(): array
    {
        $caseBody = <<<'TXT'
Don Eusebio Cárdenas, pensionista de 71 años, vive solo de su pensión de jubilación que le otorgó la ONP. Los hechos de este caso, las resoluciones, números y fechas son hipotéticos y se inspiran en lo resuelto por el Tribunal Constitucional en la STC 05089-2011-PA/TC, donde la ONP dejó sin efecto la pensión de un administrado mediante una resolución que no expuso de forma suficiente los hechos probados ni las razones jurídicas de la decisión.

LOS HECHOS
Resolución A (2 de abril de 2019): la ONP otorga la pensión de jubilación a don Eusebio. Por error material, consigna mal un dígito de su DNI. La resolución se notificó y, al no ser impugnada, quedó firme el 30 de abril de 2019.
Resolución B (15 de junio de 2023): el Jefe de la Oficina de Pensiones —el mismo funcionario de la oficina que emitió la Resolución A, no un superior jerárquico— declara «nula» la Resolución A y suspende el pago de la pensión. Su único fundamento es: «revisado el expediente, se advierte una irregularidad que afecta la validez de lo resuelto». No cita hecho concreto ni norma.
La Resolución B se notificó al domicilio anterior de don Eusebio, donde ya no vive; él recién la conoció el 8 de agosto de 2023, cuando el banco le informó que no habían depositado su pensión.
Al ser consultada, la entidad ensaya tres defensas a la vez: (i) que la Resolución A es nula por haber consignado mal el DNI; (ii) que, en todo caso, tenía una nueva política y «revocaba» la pensión por razones de oportunidad; (iii) que si el plazo para anular de oficio hubiera vencido, igual podía hacerlo porque «el interés público lo exige».
Don Eusebio no tiene más ingresos y sufre una enfermedad crónica: la falta de pago pone en riesgo su tratamiento.

JURISPRUDENCIA DE REFERENCIA
STC 05089-2011-PA/TC (Sala Segunda del TC, 24 de agosto de 2012): la ONP dejó sin efecto la pensión de un administrado con una resolución sin motivación suficiente; el TC recordó que la motivación es garantía constitucional y presupuesto de validez del acto, que un acto sin motivación suficiente es arbitrario e ilegal, y que su falta no es un defecto menor conservable sino causal de nulidad. Declaró fundada la demanda y anuló la resolución.
(Resumen del material de clase. Lean el texto completo y gratuito en tc.gob.pe.)

BASE NORMATIVA DE REFERENCIA
TUO de la Ley N.° 27444, Ley del Procedimiento Administrativo General: arts. 3 (requisitos de validez), 10 (causales de nulidad), 12 y 13 (efectos), 14 (conservación), 212 (rectificación de errores), 213 (nulidad de oficio), 218 (recursos y plazo) y 226 (suspensión de la ejecución).

INSTRUCCIONES
1) Resuelvan los cinco ejercicios interactivos (20 puntos, se califican solos). 2) Contesten las preguntas del caso en los cuadros de texto: las revisa directamente su docente. 3) Suban su trabajo completo en PDF o Word: la entrega es OBLIGATORIA para poder enviar la actividad. Plazo: viernes 6 de noviembre, 8:00 p. m. Tiempo estimado: 90 minutos.
TXT;

        $questions = [
            'Califiquen el vicio de cada resolución: ¿el error en el dígito del DNI de la Resolución A es causal de nulidad (art. 10) o vicio no trascendente que se enmienda (art. 14 y art. 212)? ¿Y los vicios de la Resolución B (incompetencia del funcionario y falta de motivación)? Presenten un cuadro con el requisito de validez afectado (art. 3), la calificación y la consecuencia.',
            '¿Podía la ONP declarar de oficio la nulidad de la Resolución A en junio de 2023? Verifiquen cada requisito del art. 213 (causal del art. 10, agravio al interés público o a derechos fundamentales, órgano competente, plazo de dos años desde la firmeza) y calculen desde qué fecha corría el plazo y cuándo venció.',
            'Si la entidad realmente quería invalidar la Resolución A, ¿qué vía le quedaba una vez vencido el plazo? Expliquen el proceso de lesividad y cómo se defiende el administrado. Respondan además a la tercera defensa de la entidad («el interés público lo exige»).',
            'Resolución B: determinen las causales de nulidad aplicables, expliquen su efecto declarativo y retroactivo (arts. 12 y 13) y qué ocurre con los pagos de pensión no realizados desde la suspensión. Expliquen por qué la STC 05089-2011-PA/TC sirve de fundamento directo.',
            'La entidad dijo que «revocaba» la pensión por razones de oportunidad: diferencien nulidad y revocación, y expliquen por qué ese argumento no salva la actuación. ¿Qué incidencia tiene la notificación de la Resolución B en un domicilio donde don Eusebio ya no vivía?',
            'Estrategia de impugnación: ¿qué recurso presentarían (reconsideración o apelación), en qué plazo (art. 218) y desde cuándo se cuenta? ¿Cómo y por qué piden la suspensión de los efectos (art. 226)? Ordenen los pasos del escrito según el método de cuatro pasos visto en clase.',
            'Vía judicial: ¿contencioso-administrativo o amparo? Fundamenten con la regla general, el carácter residual del amparo y los hechos de don Eusebio (pensión, enfermedad crónica y acto inmotivado), citando la STC 05089-2011-PA/TC.',
        ];

        $uploadPrompt = <<<'TXT'
Trabajo del caso (PDF o Word, máximo 5 páginas). Redacten como equipo el RECURSO DE APELACIÓN de don Eusebio contra la Resolución B, con: sumilla, petitorio (declarar la nulidad y restituir el pago de la pensión), fundamentos de hecho, fundamentos de derecho —calificación del vicio como nulidad (art. 10, incisos pertinentes), falta de motivación (STC 05089-2011-PA/TC), incompetencia, vencimiento del plazo de oficio (art. 213) y notificación defectuosa—, el pedido de suspensión de efectos (art. 226) con su justificación, y la vía judicial que se reserva (contencioso-administrativo o amparo).
Indiquen en la primera línea los nombres de los integrantes del grupo.
TXT;

        return [
            'course' => [
                'slug' => 'derecho-procesal-administrativo',
                'attrs' => [
                    'code_abbr' => 'PRO',
                    'name' => 'Derecho Procesal Administrativo',
                    'subtitle' => 'Función Administrativa y Debido Procedimiento',
                    'faculty' => 'Facultad de Derecho y Ciencias Políticas',
                    'period' => '2026-II',
                    'total_weeks' => 16,
                    'status' => 'active',
                ],
            ],
            'activity' => [
                'slug' => 'semana-7-nulidad-acto-administrativo',
                'case_title' => 'La pensión anulada: nulidad, plazo y vía correcta',
                'unit' => 'Unidad II — La invalidez del acto y sus vías de ataque',
                'access_code' => 'procesal0611',
                'case_body' => $caseBody,
                'upload_prompt' => $uploadPrompt,
            ],
            'questions' => $questions,
            'exercises' => [
                [
                    'type' => 'vfgroup',
                    'prompt' => 'Ejercicio 1 · Verdadero o falso. Marca si cada afirmación sobre la nulidad y anulabilidad del acto administrativo es verdadera o falsa.',
                    'payload' => [
                        'statements' => [
                            ['id' => 'v1', 'text' => 'En lo administrativo la invalidez se gradúa y la conservación del acto es un principio rector.', 'answer' => true],
                            ['id' => 'v2', 'text' => 'Las causales de nulidad de pleno derecho del art. 10 son tasadas: solo ellas producen nulidad.', 'answer' => true],
                            ['id' => 'v3', 'text' => 'Toda ilegalidad, por mínima que sea, produce la nulidad de pleno derecho del acto.', 'answer' => false],
                            ['id' => 'v4', 'text' => 'La nulidad se declara con efecto retroactivo (ex tunc): el acto se tiene por no producido desde su origen.', 'answer' => true],
                            ['id' => 'v5', 'text' => 'Un error material que no cambia el sentido de la decisión debe llevar a anular el acto.', 'answer' => false],
                            ['id' => 'v6', 'text' => 'Según la STC 05089-2011-PA/TC, la falta de motivación es causal de nulidad y no un defecto menor conservable.', 'answer' => true],
                            ['id' => 'v7', 'text' => 'La revocación deja sin efecto un acto válido por razones de oportunidad o interés público, hacia el futuro, y no por un vicio.', 'answer' => true],
                            ['id' => 'v8', 'text' => 'La nulidad de oficio (art. 213) la declara el mismo funcionario que emitió el acto.', 'answer' => false],
                            ['id' => 'v9', 'text' => 'La nulidad de oficio puede declararse dentro de los dos años contados desde que el acto quedó firme.', 'answer' => true],
                            ['id' => 'v10', 'text' => 'El plazo de dos años de la nulidad de oficio se cuenta desde la fecha en que se dictó el acto, no desde su firmeza.', 'answer' => false],
                            ['id' => 'v11', 'text' => 'Vencido el plazo de la nulidad de oficio, la entidad solo puede pedir la nulidad en el proceso judicial de lesividad.', 'answer' => true],
                            ['id' => 'v12', 'text' => 'Es obligatorio interponer reconsideración antes de la apelación.', 'answer' => false],
                        ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'ordering',
                    'prompt' => 'Ejercicio 2 · Ordenar ideas. Ordena el itinerario de una impugnación por nulidad: el método de cuatro pasos y las vías hasta el Poder Judicial. Cada paso en su lugar suma puntos.',
                    'payload' => [
                        'partial' => true,
                        'items' => [
                            ['id' => 'o1', 'text' => 'Calificar el vicio: ¿causal de nulidad (art. 10) o defecto conservable (art. 14)?'],
                            ['id' => 'o2', 'text' => 'Encuadrar los hechos en el inciso del art. 10 que corresponda (incompetencia, falta de motivación, etc.).'],
                            ['id' => 'o3', 'text' => 'Elegir la vía y controlar el plazo: recurso en 15 días hábiles o, si la entidad se excede, oponer el vencimiento del plazo de oficio.'],
                            ['id' => 'o4', 'text' => 'Pedir lo accesorio: la suspensión de los efectos del acto (art. 226).'],
                            ['id' => 'o5', 'text' => 'Reconsideración ante el mismo órgano que emitió el acto, con nueva prueba (optativa).'],
                            ['id' => 'o6', 'text' => 'Apelación ante el superior jerárquico, que agota la vía administrativa.'],
                            ['id' => 'o7', 'text' => 'Proceso contencioso-administrativo ante el Poder Judicial, donde el juez tiene la última palabra sobre la legalidad.'],
                        ],
                        'correctOrder' => ['o1', 'o2', 'o3', 'o4', 'o5', 'o6', 'o7'],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'fillblank',
                    'prompt' => 'Ejercicio 3 · Completar palabras. Toca cada espacio en blanco y elige la opción correcta de la barra seleccionable.',
                    'payload' => [
                        'partial' => true,
                        'template' => "En lo administrativo la invalidez se ___ y rige la ___ del acto. Las causales de nulidad están en el art. ___ del TUO de la Ley N.° 27444. La nulidad opera con efecto ___ (ex tunc), salvo los derechos de ___ de buena fe.\n\nEl vicio no ___ no anula el acto: se enmienda (art. 14). La nulidad de oficio la declara el órgano ___ al que emitió el acto, dentro de ___ años contados desde que el acto quedó ___.\n\nVencido ese plazo, la entidad debe demandar en el proceso de ___.",
                        'blanks' => [
                            ['answer' => 'gradúa', 'options' => ['gradúa', 'extingue', 'presume']],
                            ['answer' => 'conservación', 'options' => ['conservación', 'caducidad', 'publicidad']],
                            ['answer' => '10', 'options' => ['10', '3', '14']],
                            ['answer' => 'retroactivo', 'options' => ['retroactivo', 'prospectivo', 'suspensivo']],
                            ['answer' => 'terceros', 'options' => ['terceros', 'funcionarios', 'acreedores']],
                            ['answer' => 'trascendente', 'options' => ['trascendente', 'evidente', 'formal']],
                            ['answer' => 'superior', 'options' => ['superior', 'igual', 'inferior']],
                            ['answer' => 'dos', 'options' => ['dos', 'cinco', 'un']],
                            ['answer' => 'firme', 'options' => ['firme', 'dictado', 'notificado']],
                            ['answer' => 'lesividad', 'options' => ['lesividad', 'amparo', 'casación']],
                        ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'crossword',
                    'prompt' => 'Ejercicio 4 · Crucigrama. Completa las diez palabras con ayuda de las pistas (sin tildes ni espacios). Cada palabra completa suma puntos. Ojo: la casilla 5 inicia dos palabras (una horizontal y una vertical).',
                    'payload' => [
                    'rows' => 13,
                    'cols' => 17,
                    'words' => [
                        ['id' => 'w1', 'number' => 1, 'dir' => 'down', 'row' => 0, 'col' => 8, 'answer' => 'LESIVIDAD', 'clue' => 'Proceso en el que la propia Administración demanda la nulidad de su acto cuando venció el plazo de oficio.'],
                        ['id' => 'w2', 'number' => 2, 'dir' => 'down', 'row' => 0, 'col' => 14, 'answer' => 'MOTIVACION', 'clue' => 'Falta de ___: causal de nulidad según la STC 05089-2011-PA/TC.'],
                        ['id' => 'w3', 'number' => 3, 'dir' => 'across', 'row' => 1, 'col' => 4, 'answer' => 'CONSERVACION', 'clue' => 'Principio rector: el acto con vicio no trascendente se mantiene y se enmienda (art. 14).'],
                        ['id' => 'w4', 'number' => 4, 'dir' => 'down', 'row' => 1, 'col' => 12, 'answer' => 'COMPETENCIA', 'clue' => 'Requisito de validez cuyo defecto (órgano incompetente) es causal clásica de nulidad.'],
                        ['id' => 'w5', 'number' => 5, 'dir' => 'across', 'row' => 3, 'col' => 0, 'answer' => 'RETROACTIVO', 'clue' => 'Efecto de la declaración de nulidad: se retrotrae a la fecha del acto (ex tunc).'],
                        ['id' => 'w6', 'number' => 5, 'dir' => 'down', 'row' => 3, 'col' => 0, 'answer' => 'REVOCACION', 'clue' => 'Dejar sin efecto un acto válido por razones de oportunidad o interés público, hacia el futuro.'],
                        ['id' => 'w7', 'number' => 6, 'dir' => 'across', 'row' => 6, 'col' => 2, 'answer' => 'ENMIENDA', 'clue' => 'Corrección que hace la propia autoridad de un vicio no trascendente, sin anular el acto.'],
                        ['id' => 'w8', 'number' => 7, 'dir' => 'across', 'row' => 8, 'col' => 2, 'answer' => 'NULIDAD', 'clue' => 'Invalidez del vicio grave y trascendente del acto; sus causales tasadas están en el art. 10.'],
                        ['id' => 'w9', 'number' => 8, 'dir' => 'across', 'row' => 11, 'col' => 0, 'answer' => 'OFICIO', 'clue' => 'Nulidad de ___ (art. 213): la declara el órgano superior, hasta dos años desde la firmeza.'],
                        ['id' => 'w10', 'number' => 9, 'dir' => 'across', 'row' => 11, 'col' => 8, 'answer' => 'APELACION', 'clue' => 'Recurso ante el superior jerárquico que agota la vía administrativa.'],
                    ],
                    ],
                    'points' => 4,
                ],
                [
                    'type' => 'multi',
                    'prompt' => 'Ejercicio 5 · Marcar. En cada pregunta marca TODAS las opciones que correspondan (pueden ser varias). Cada opción bien decidida suma puntos.',
                    'payload' => [
                        'questions' => [
                            [
                                'id' => 'm1',
                                'prompt' => '¿Cuáles son causales de nulidad de pleno derecho según el art. 10?',
                                'options' => [
                                    'Cualquier error de redacción',
                                    'La contravención a la Constitución, a las leyes o a las normas reglamentarias',
                                    'El defecto o la omisión de un requisito de validez, salvo conservación',
                                    'Los actos expresos o fictos contrarios al ordenamiento por los que se adquieren facultades o derechos sin los requisitos',
                                    'Los actos constitutivos de infracción penal o dictados como consecuencia de ella',
                                    'La mera inconveniencia del acto',
                                ],
                                'correct' => [1, 2, 3, 4],
                            ],
                            [
                                'id' => 'm2',
                                'prompt' => '¿Qué exige la nulidad de oficio (art. 213)?',
                                'options' => [
                                    'Una causal del art. 10',
                                    'Que la declare el mismo funcionario que dictó el acto',
                                    'Que el acto agravie el interés público o lesione derechos fundamentales',
                                    'Que se declare dentro de los dos años desde que se dictó el acto',
                                    'Que la declare el funcionario jerárquico superior al que expidió el acto',
                                    'Que se declare dentro de los dos años contados desde que el acto quedó firme',
                                ],
                                'correct' => [0, 2, 4, 5],
                            ],
                            [
                                'id' => 'm3',
                                'prompt' => '¿Cuáles son vicios conservables (art. 14) que se enmiendan sin anular el acto?',
                                'options' => [
                                    'El error material',
                                    'La incompetencia del órgano',
                                    'El error de cálculo',
                                    'La falta de motivación',
                                    'La infracción de formalidades no esenciales',
                                ],
                                'correct' => [0, 2, 4],
                            ],
                            [
                                'id' => 'm4',
                                'prompt' => '¿Qué es cierto sobre las vías para invalidar un acto?',
                                'options' => [
                                    'Los recursos administrativos se interponen en quince días hábiles (art. 218)',
                                    'El amparo es la vía ordinaria para controlar la legalidad de cualquier acto',
                                    'La reconsideración es optativa',
                                    'El proceso de lesividad lo activa el administrado',
                                    'La apelación se presenta ante el superior jerárquico y agota la vía administrativa',
                                    'El contencioso-administrativo es, por regla, la continuación natural tras agotar la vía administrativa',
                                ],
                                'correct' => [0, 2, 4, 5],
                            ],
                            [
                                'id' => 'm5',
                                'prompt' => '¿Cuáles son errores frecuentes en la práctica de la nulidad?',
                                'options' => [
                                    'Invocar nulidad por vicios menores conservables',
                                    'Pedir la suspensión de efectos del acto (art. 226)',
                                    'No controlar el plazo de dos años de la nulidad de oficio',
                                    'Calificar bien la gravedad del vicio antes de impugnar',
                                    'Confundir nulidad con revocación',
                                    'Olvidar pedir la suspensión de efectos mientras se resuelve',
                                ],
                                'correct' => [0, 2, 4, 5],
                            ],
                        ],
                    ],
                    'points' => 4,
                ],
            ],
        ];
    }
}
