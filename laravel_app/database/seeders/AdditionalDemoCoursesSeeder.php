<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AdditionalDemoCoursesSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $instructor = User::where('email', 'denis@romanicompliance.com')->first();

        $laft = Category::firstOrCreate(
            ['slug' => 'prevencion-laft'],
            ['name' => 'Prevención LA/FT', 'description' => 'Capacitaciones sobre el sistema de prevención de lavado de activos y financiamiento del terrorismo.']
        );

        $corporate = Category::firstOrCreate(
            ['slug' => 'compliance-corporativo'],
            ['name' => 'Compliance Corporativo', 'description' => 'Capacitaciones sobre responsabilidad penal de la persona jurídica y modelos de prevención.']
        );

        $this->buildCourse(
            slug: 'debida-diligencia-ddc-kyc',
            categoryId: $laft->id,
            adminId: $admin?->id,
            instructorId: $instructor?->id,
            title: 'Debida Diligencia del Cliente (DDC/KYC)',
            description: 'Curso práctico sobre el enfoque basado en riesgos para la debida diligencia en el conocimiento del cliente: identificación, verificación, monitoreo continuo y señales de alerta ante operaciones inusuales.',
            coverIcon: 'shield',
            coverLabel: ['DDC / KYC'],
            certificateType: 'gratuita',
            certificatePrice: null,
            duration: 95,
            modules: $this->ddcModules(),
            examTitle: 'Examen final: Debida Diligencia del Cliente (DDC/KYC)',
            questions: $this->ddcQuestions(),
        );

        $this->buildCourse(
            slug: 'compliance-corporativo-ley-30424',
            categoryId: $corporate->id,
            adminId: $admin?->id,
            instructorId: $instructor?->id,
            title: 'Compliance Corporativo y Responsabilidad Penal de la Persona Jurídica',
            description: 'Análisis de la Ley N.° 30424 y su reglamento: alcances de la responsabilidad administrativa de las personas jurídicas, delitos precedentes, elementos mínimos del Modelo de Prevención y su rol como eximente de responsabilidad.',
            coverIcon: 'scale',
            coverLabel: ['LEY N.° 30424'],
            certificateType: 'opcional',
            certificatePrice: 149.00,
            duration: 110,
            modules: $this->corporateModules(),
            examTitle: 'Examen final: Compliance Corporativo y Ley N.° 30424',
            questions: $this->corporateQuestions(),
        );

        $this->buildCourse(
            slug: 'auditoria-interna-splaft',
            categoryId: $laft->id,
            adminId: $admin?->id,
            instructorId: $instructor?->id,
            title: 'Auditoría Interna del Sistema de Prevención LA/FT',
            description: 'Metodología para planificar y ejecutar la auditoría interna del SPLAFT: revisión documental, testeo de controles de DDC/KYC, identificación de brechas y elaboración del informe de auditoría con seguimiento de observaciones.',
            coverIcon: 'chart',
            coverLabel: ['AUDITORÍA INTERNA'],
            certificateType: 'opcional',
            certificatePrice: 129.00,
            duration: 100,
            modules: $this->auditModules(),
            examTitle: 'Examen final: Auditoría Interna del Sistema de Prevención LA/FT',
            questions: $this->auditQuestions(),
        );

        $this->command?->info('3 cursos de prueba adicionales creados correctamente.');
    }

    private function buildCourse(
        string $slug,
        ?int $categoryId,
        ?int $adminId,
        ?int $instructorId,
        string $title,
        string $description,
        string $coverIcon,
        array $coverLabel,
        string $certificateType,
        ?float $certificatePrice,
        int $duration,
        array $modules,
        string $examTitle,
        array $questions,
    ): void {
        $coverPath = "courses/covers/{$slug}.svg";
        Storage::disk('public')->put($coverPath, $this->svgCover($coverIcon, $coverLabel[0]));

        $course = Course::updateOrCreate(
            ['slug' => $slug],
            [
                'category_id' => $categoryId,
                'created_by' => $adminId,
                'instructor_id' => $instructorId,
                'instructor_name' => 'Denis Gabriel Romani Seminario',
                'title' => $title,
                'description' => $description,
                'cover_image' => $coverPath,
                'duration_minutes' => $duration,
                'is_published' => true,
                'certificate_type' => $certificateType,
                'certificate_price' => $certificatePrice,
            ]
        );

        $course->modules->each(fn ($module) => $module->lessons()->delete());
        $course->modules()->delete();
        $course->exam()->delete();

        foreach ($modules as $order => $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
                'order' => $order + 1,
            ]);

            foreach ($moduleData['lessons'] as $lessonOrder => $lessonData) {
                $module->lessons()->create([
                    'title' => $lessonData['title'],
                    'type' => $lessonData['type'],
                    'content' => $lessonData['content'] ?? null,
                    'duration_minutes' => $lessonData['duration_minutes'] ?? null,
                    'order' => $lessonOrder + 1,
                ]);
            }
        }

        $exam = $course->exam()->create([
            'title' => $examTitle,
            'passing_score' => 70,
            'max_attempts' => 3,
            'time_limit_minutes' => 20,
        ]);

        foreach ($questions as $order => $q) {
            $question = $exam->questions()->create([
                'question_text' => $q['q'],
                'order' => $order + 1,
                'points' => 1,
            ]);

            foreach ($q['options'] as $i => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => $i === $q['correct'],
                    'order' => $i,
                ]);
            }
        }
    }

    private function ddcModules(): array
    {
        return [
            [
                'title' => 'Módulo 1: Fundamentos de la Debida Diligencia',
                'lessons' => [
                    [
                        'title' => '¿Qué es la Debida Diligencia del Cliente?',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "La Debida Diligencia del Cliente (DDC), también conocida por sus siglas en inglés KYC (\"Know Your Customer\"), es el conjunto de procedimientos que permiten a un sujeto obligado identificar y conocer adecuadamente a sus clientes, beneficiarios finales, proveedores y contrapartes, antes y durante toda la relación comercial.\n\nSu finalidad es doble: por un lado, evitar que la organización sea utilizada como vehículo para el lavado de activos o el financiamiento del terrorismo; por otro, permitir un conocimiento suficiente del cliente que facilite detectar operaciones inusuales o sospechosas a lo largo del tiempo.\n\nLa DDC no es un trámite que se agota en el momento de la vinculación: es un proceso continuo que acompaña toda la relación comercial y que debe actualizarse periódicamente, en función del nivel de riesgo asignado al cliente.",
                    ],
                    [
                        'title' => 'Enfoque basado en riesgo: DDC simplificada, estándar y reforzada',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "El enfoque basado en riesgo (EBR), promovido por el Grupo de Acción Financiera Internacional (GAFI), exige que los sujetos obligados apliquen un nivel de diligencia proporcional al riesgo de LA/FT identificado en cada cliente. Esto se traduce en tres niveles de DDC:\n\n• DDC simplificada: aplicable a clientes de bajo riesgo, donde la normativa permite reducir la intensidad de las medidas (por ejemplo, entidades públicas o clientes con productos de montos muy limitados).\n\n• DDC estándar: es el nivel general aplicable a la mayoría de clientes, e incluye la identificación del cliente y su beneficiario final, el propósito de la relación comercial y el origen de los fondos.\n\n• DDC reforzada: se aplica a clientes, productos, zonas geográficas o canales de mayor riesgo (por ejemplo, Personas Expuestas Políticamente, banca corresponsal, o clientes de jurisdicciones de alto riesgo), exigiendo medidas adicionales como la aprobación de la relación por un funcionario de mayor jerarquía y un monitoreo más frecuente.\n\nLa clasificación de riesgo del cliente debe basarse en una matriz de riesgos que considere, como mínimo, los factores de cliente, producto, canal y zona geográfica.",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 2: Identificación y verificación del cliente',
                'lessons' => [
                    [
                        'title' => 'Identificación del cliente y del beneficiario final',
                        'type' => 'text',
                        'duration_minutes' => 13,
                        'content' => "Identificar al cliente implica recabar sus datos generales (nombre o razón social, documento de identidad, domicilio, actividad económica) y verificarlos con documentación fehaciente. Cuando el cliente es una persona jurídica, la identificación debe extenderse a su beneficiario final: la persona natural que finalmente posee o controla dicho cliente, o en cuyo nombre se realiza una transacción.\n\nLa identificación del beneficiario final es una de las medidas más relevantes del estándar internacional, ya que impide que estructuras societarias complejas se utilicen para ocultar la identidad real de quien controla los fondos. Para ello, se debe revisar la cadena de propiedad y control hasta llegar a la o las personas naturales que ejercen dicho control, considerando umbrales de participación accionaria y otros mecanismos de control indirecto (como acuerdos de accionistas o poderes).",
                    ],
                    [
                        'title' => 'Personas Expuestas Políticamente (PEP) y listas restrictivas',
                        'type' => 'text',
                        'duration_minutes' => 13,
                        'content' => "Las Personas Expuestas Políticamente (PEP) son aquellas personas naturales, nacionales o extranjeras, que cumplen o han cumplido funciones públicas destacadas, así como sus familiares cercanos y personas estrechamente asociadas. Por el riesgo de que estas posiciones sean aprovechadas para actos de corrupción o lavado de activos, la normativa exige aplicarles DDC reforzada durante un periodo determinado, incluso después de haber dejado el cargo.\n\nAdicionalmente, todo sujeto obligado debe contrastar a sus clientes, beneficiarios finales y contrapartes contra las listas restrictivas nacionales e internacionales vigentes (como las listas del Consejo de Seguridad de la ONU y otras listas de sanciones), como parte del proceso de identificación y de forma periódica durante la relación comercial.",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 3: Monitoreo continuo',
                'lessons' => [
                    [
                        'title' => 'Monitoreo continuo de la relación comercial',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "El conocimiento del cliente no termina con la vinculación inicial. El SPLAFT exige un monitoreo continuo de las operaciones que realiza cada cliente, contrastándolas contra su perfil transaccional esperado (declarado al momento de la vinculación) y contra los patrones de comportamiento de clientes con características similares.\n\nEste monitoreo puede apoyarse en herramientas tecnológicas que generen alertas automáticas ante determinados umbrales o comportamientos atípicos, pero requiere siempre el análisis de un profesional capacitado, que determine si la alerta amerita profundizar la revisión, actualizar el perfil del cliente o, de corresponder, calificarla como una operación inusual.",
                    ],
                    [
                        'title' => 'Señales de alerta y operaciones inusuales',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "Una operación inusual es aquella cuya cuantía, características o periodicidad no guarda relación con la actividad económica del cliente, o que por su naturaleza no tiene un fundamento legal evidente. Algunas señales de alerta frecuentes incluyen:\n\n• Operaciones que no guardan relación con el perfil declarado por el cliente.\n• Fraccionamiento de operaciones para evitar los umbrales de reporte.\n• Uso de intermediarios sin justificación aparente.\n• Reticencia del cliente a proporcionar información sobre el origen de los fondos.\n• Cambios súbitos e injustificados en el volumen o tipo de operaciones.\n\nToda operación inusual detectada debe registrarse y evaluarse internamente; si tras el análisis se determina que existen elementos suficientes para considerarla sospechosa de estar vinculada al LA/FT, debe comunicarse a la UIF mediante el Reporte de Operaciones Sospechosas (ROS), dentro de los plazos que establece la normativa.",
                    ],
                ],
            ],
        ];
    }

    private function ddcQuestions(): array
    {
        return [
            [
                'q' => '¿Cuál es el objetivo principal de la Debida Diligencia del Cliente (DDC)?',
                'options' => [
                    'Vender más productos financieros al cliente',
                    'Identificar y conocer adecuadamente al cliente para prevenir el LA/FT',
                    'Reducir el tiempo de atención al cliente',
                    'Aumentar la cantidad de sucursales de la empresa',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'Según el enfoque basado en riesgo, ¿a qué clientes se les aplica la DDC reforzada?',
                'options' => [
                    'A todos los clientes por igual',
                    'Solo a clientes con productos de bajo monto',
                    'A clientes, productos o zonas geográficas de mayor riesgo, como las PEP',
                    'Únicamente a clientes extranjeros',
                ],
                'correct' => 2,
            ],
            [
                'q' => '¿Qué se entiende por "beneficiario final"?',
                'options' => [
                    'El gerente general de la empresa cliente',
                    'La persona natural que finalmente posee o controla al cliente',
                    'El primer trabajador contratado por la empresa',
                    'El proveedor principal del cliente',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'Una Persona Expuesta Políticamente (PEP) requiere:',
                'options' => [
                    'DDC simplificada, sin excepciones',
                    'Ningún tipo de diligencia especial',
                    'DDC reforzada, incluso después de dejar el cargo, durante el periodo que establece la norma',
                    'Solo verificación telefónica',
                ],
                'correct' => 2,
            ],
            [
                'q' => '¿Qué es una operación inusual?',
                'options' => [
                    'Cualquier operación mayor a S/ 1,000',
                    'Una operación cuya cuantía o características no guardan relación con el perfil del cliente',
                    'Una operación realizada fuera del horario de atención',
                    'Una operación realizada por un cliente nuevo',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'Si tras el análisis interno una operación inusual se considera sospechosa de LA/FT, ¿qué corresponde hacer?',
                'options' => [
                    'Ignorarla si el monto es bajo',
                    'Comunicarla a la UIF mediante un Reporte de Operaciones Sospechosas (ROS)',
                    'Informar directamente al cliente sobre la sospecha',
                    'Cerrar la empresa de forma preventiva',
                ],
                'correct' => 1,
            ],
        ];
    }

    private function corporateModules(): array
    {
        return [
            [
                'title' => 'Módulo 1: Marco legal de la responsabilidad de la persona jurídica',
                'lessons' => [
                    [
                        'title' => 'Alcances de la Ley N.° 30424 y su reglamento',
                        'type' => 'text',
                        'duration_minutes' => 15,
                        'content' => "La Ley N.° 30424 regula la responsabilidad administrativa de las personas jurídicas por determinados delitos, modificada posteriormente para ampliar su alcance y precisar sus criterios de imputación. Bajo este régimen, una persona jurídica puede ser sancionada de forma autónoma cuando alguno de los delitos comprendidos en la ley es cometido en su nombre, por cuenta de ella o en su beneficio, por sus socios, directores, administradores de hecho o de derecho, representantes legales, apoderados, o por personas que estén bajo su autoridad y control, siempre que exista un incumplimiento de los deberes de supervisión, vigilancia y control por parte de la organización.\n\nUn aspecto central de este régimen es que la responsabilidad de la persona jurídica es autónoma respecto de la responsabilidad penal de la persona natural: la organización puede ser sancionada aun cuando no se identifique o no se pueda procesar al autor individual del delito, en la medida en que se acredite el déficit de organización.",
                    ],
                    [
                        'title' => 'Delitos precedentes comprendidos en la norma',
                        'type' => 'text',
                        'duration_minutes' => 13,
                        'content' => "Entre los delitos que pueden generar responsabilidad administrativa de la persona jurídica se encuentran, principalmente: el cohecho activo genérico, transnacional y específico; el lavado de activos; el financiamiento del terrorismo; la colusión simple y agravada; el tráfico de influencias; y determinados delitos aduaneros y contra la administración pública, entre otros que la normativa ha ido incorporando.\n\nLa relevancia de este listado es que orienta directamente el alcance del Modelo de Prevención que la organización debe implementar: no basta con un programa genérico de cumplimiento, sino que debe estar diseñado considerando los riesgos específicos de comisión de estos delitos en el giro particular del negocio.",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 2: El Modelo de Prevención',
                'lessons' => [
                    [
                        'title' => 'Elementos mínimos del Modelo de Prevención',
                        'type' => 'text',
                        'duration_minutes' => 16,
                        'content' => "El Modelo de Prevención es el conjunto de medidas de organización, gestión y control que adopta la persona jurídica para prevenir la comisión de los delitos precedentes o para reducir significativamente el riesgo de su comisión. Sus elementos mínimos suelen comprender:\n\n• Un encargado de prevención, designado por el máximo órgano de administración, con autonomía suficiente.\n• Identificación, evaluación y mitigación de riesgos para prevenir la comisión de los delitos.\n• Implementación de procedimientos de denuncia y de un canal de reporte confidencial.\n• Difusión y capacitación periódica del modelo entre directores, funcionarios y trabajadores.\n• Evaluación y monitoreo continuo del modelo de prevención.\n\nEl diseño del modelo debe ser proporcional al tamaño, la naturaleza, la complejidad y el giro de actividades de la organización, evitando un enfoque de \"talla única\".",
                    ],
                    [
                        'title' => 'El rol del Encargado de Prevención',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "El Encargado de Prevención es la persona (o el órgano colegiado, según el tamaño de la organización) responsable de supervisar el adecuado funcionamiento y cumplimiento del Modelo de Prevención. Para cumplir su función de forma efectiva, debe contar con autonomía respecto de los órganos de línea, acceso directo al máximo órgano de administración, y recursos suficientes para desarrollar sus funciones.\n\nEntre sus principales responsabilidades se encuentran: reportar periódicamente al directorio o máximo órgano de gobierno sobre el funcionamiento del modelo, gestionar el canal de denuncias, coordinar las investigaciones internas que correspondan, y proponer las mejoras necesarias a partir de las evaluaciones periódicas del modelo.",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 3: Beneficios y exención de responsabilidad',
                'lessons' => [
                    [
                        'title' => 'Eximente de responsabilidad y atenuantes',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "Uno de los principales incentivos para implementar un Modelo de Prevención es que, si la persona jurídica cuenta con un modelo adecuado a su naturaleza, riesgos y necesidades, vigente al momento de la comisión del delito, puede quedar exenta de responsabilidad administrativa. Para ello, el modelo debe haber sido efectivamente implementado y no meramente formal (lo que en la práctica se conoce como \"papel mojado\").\n\nAdemás de la eximente total, la norma contempla la posibilidad de atenuar la responsabilidad y la sanción aplicable cuando, sin llegar a cumplirse todos los requisitos para la exención, la persona jurídica acredita avances relevantes en la implementación de su modelo, colabora activamente con la investigación, o repara el daño causado de forma voluntaria antes del inicio del juicio.",
                    ],
                    [
                        'title' => 'Certificación del Modelo de Prevención',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "La normativa contempla la posibilidad de que empresas registradas y autorizadas certifiquen la adopción y funcionamiento del Modelo de Prevención. Si bien dicha certificación no constituye por sí sola una prueba absoluta de la eximente de responsabilidad, es un elemento relevante que las autoridades pueden valorar al evaluar la idoneidad del modelo implementado.\n\nPor ello, muchas organizaciones optan por certificar su modelo como parte de una estrategia de gestión de riesgo reputacional y legal, complementando la certificación con auditorías periódicas y actualizaciones del modelo frente a cambios normativos o en el giro del negocio.",
                    ],
                ],
            ],
        ];
    }

    private function corporateQuestions(): array
    {
        return [
            [
                'q' => '¿Qué tipo de responsabilidad regula la Ley N.° 30424?',
                'options' => [
                    'La responsabilidad civil de los proveedores',
                    'La responsabilidad administrativa de las personas jurídicas por determinados delitos',
                    'La responsabilidad tributaria de las personas naturales',
                    'La responsabilidad laboral del empleador',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿La responsabilidad de la persona jurídica bajo esta ley depende de identificar a la persona natural responsable?',
                'options' => [
                    'Sí, siempre es necesario identificar y sancionar primero a la persona natural',
                    'No, es una responsabilidad autónoma que puede configurarse aun sin identificar al autor individual',
                    'Solo si la persona natural es directivo de la empresa',
                    'Solo en caso de delitos tributarios',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Cuál de los siguientes es un elemento mínimo del Modelo de Prevención?',
                'options' => [
                    'Un plan de marketing anual',
                    'Un encargado de prevención con autonomía suficiente',
                    'Un seguro patrimonial obligatorio',
                    'Un manual de atención al cliente',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Qué efecto puede tener un Modelo de Prevención adecuado, vigente al momento del delito?',
                'options' => [
                    'Ninguno, la empresa siempre es sancionada',
                    'Puede eximir de responsabilidad administrativa a la persona jurídica',
                    'Solo reduce el monto de las multas tributarias',
                    'Elimina la obligación de pagar impuestos',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Qué se necesita para que el Modelo de Prevención sirva como eximente de responsabilidad?',
                'options' => [
                    'Que exista solo en un documento, sin necesidad de implementarlo',
                    'Que esté efectivamente implementado y no sea meramente formal',
                    'Que lo apruebe únicamente el gerente de ventas',
                    'Que se actualice una sola vez, al momento de constituir la empresa',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'La certificación del Modelo de Prevención por una empresa autorizada:',
                'options' => [
                    'Es irrelevante para cualquier efecto legal',
                    'Es un elemento que las autoridades pueden valorar al evaluar la idoneidad del modelo',
                    'Sustituye por completo la necesidad de auditorías internas',
                    'Solo aplica a empresas del sector financiero',
                ],
                'correct' => 1,
            ],
        ];
    }

    private function auditModules(): array
    {
        return [
            [
                'title' => 'Módulo 1: Planificación de la auditoría',
                'lessons' => [
                    [
                        'title' => 'Objetivos y alcance de la auditoría del SPLAFT',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "La auditoría interna del Sistema de Prevención del Lavado de Activos y Financiamiento del Terrorismo (SPLAFT) tiene como objetivo evaluar de manera independiente y objetiva si las políticas, procedimientos y controles implementados por la organización son adecuados, se cumplen efectivamente y resultan suficientes frente a los riesgos de LA/FT identificados.\n\nEl alcance de la auditoría debe definirse considerando el perfil de riesgo de la organización, los hallazgos de auditorías anteriores, los cambios normativos recientes, y los resultados del monitoreo continuo del propio sistema. Una auditoría bien planificada no se limita a verificar la existencia formal de documentos, sino que evalúa si el sistema funciona en la práctica.",
                    ],
                    [
                        'title' => 'Elaboración del plan de auditoría basado en riesgos',
                        'type' => 'text',
                        'duration_minutes' => 13,
                        'content' => "El plan de auditoría debe elaborarse bajo un enfoque basado en riesgos, priorizando la revisión de aquellos procesos, productos, canales o unidades de negocio con mayor exposición al riesgo de LA/FT. El plan debe incluir, como mínimo: los objetivos específicos de la auditoría, el alcance y periodo a revisar, la metodología y las técnicas de auditoría a emplear (revisión documental, entrevistas, pruebas de cumplimiento y pruebas sustantivas), el cronograma de ejecución, y los recursos asignados.\n\nEs recomendable que el plan sea aprobado por el órgano de gobierno correspondiente (por ejemplo, el comité de auditoría o el directorio) antes de su ejecución, garantizando así la independencia y respaldo institucional de la función de auditoría.",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 2: Ejecución: revisión documental y testeo de controles',
                'lessons' => [
                    [
                        'title' => 'Revisión documental del Manual y Código de Conducta',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "La primera etapa de la ejecución consiste en revisar la documentación normativa interna del SPLAFT: el Manual de Prevención, el Código de Conducta, la Matriz de Riesgos, y las políticas y procedimientos vigentes. El auditor debe verificar que estos documentos estén actualizados, aprobados por los órganos competentes, y que efectivamente reflejen los procesos que la organización ejecuta en la práctica.\n\nUn hallazgo frecuente en las auditorías es la existencia de \"documentos de escritorio\": manuales completos y bien redactados, pero que no se condicen con los procedimientos reales que siguen las áreas operativas, lo cual constituye una debilidad relevante del sistema.",
                    ],
                    [
                        'title' => 'Testeo de controles DDC/KYC y del registro de operaciones',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "El testeo de controles implica seleccionar una muestra representativa de expedientes de clientes y de operaciones registradas, para verificar el cumplimiento efectivo de los procedimientos de DDC/KYC: identificación del cliente y del beneficiario final, clasificación de riesgo, contraste contra listas restrictivas, y actualización periódica de la información.\n\nAsimismo, se debe revisar el registro de operaciones (incluyendo, cuando corresponda, el registro de operaciones inusuales) y contrastarlo contra la evidencia documental disponible, verificando que las alertas generadas por los sistemas de monitoreo hayan sido oportunamente analizadas y, de corresponder, escaladas para su calificación como operación sospechosa.",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 3: Informe y seguimiento',
                'lessons' => [
                    [
                        'title' => 'Elaboración del informe de auditoría',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "El informe de auditoría debe presentar de forma clara y objetiva los hallazgos identificados, clasificándolos según su nivel de riesgo o criticidad (por ejemplo, observaciones críticas, altas, medias y bajas). Cada hallazgo debe describir la situación encontrada, la norma o procedimiento interno incumplido, y su posible impacto en la efectividad del SPLAFT.\n\nEl informe debe incluir también las recomendaciones específicas para subsanar cada hallazgo, así como los plazos sugeridos para su implementación, y debe ser presentado al máximo órgano de administración o al comité correspondiente para su conocimiento y aprobación del plan de acción.",
                    ],
                    [
                        'title' => 'Seguimiento de observaciones y plan de acción',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "La auditoría no concluye con la entrega del informe. Es necesario establecer un mecanismo de seguimiento que permita verificar, en fechas posteriores, si las observaciones fueron efectivamente subsanadas dentro de los plazos comprometidos por las áreas responsables.\n\nEste seguimiento debe documentarse y reportarse periódicamente, de modo que el Oficial de Cumplimiento y el órgano de gobierno cuenten con información actualizada sobre el estado de implementación del plan de acción, y puedan escalar oportunamente aquellas observaciones que no se resuelvan dentro de los plazos previstos.",
                    ],
                ],
            ],
        ];
    }

    private function auditQuestions(): array
    {
        return [
            [
                'q' => '¿Cuál es el objetivo principal de la auditoría interna del SPLAFT?',
                'options' => [
                    'Aumentar las ventas de la organización',
                    'Evaluar de forma independiente si el sistema es adecuado y funciona efectivamente',
                    'Reemplazar la función del Oficial de Cumplimiento',
                    'Elaborar el presupuesto anual de la empresa',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Bajo qué enfoque debe elaborarse el plan de auditoría?',
                'options' => [
                    'Un enfoque basado en riesgos, priorizando las áreas de mayor exposición',
                    'Revisando todas las áreas por igual, sin priorización',
                    'Solo revisando las quejas de los clientes',
                    'Un enfoque aleatorio sin metodología definida',
                ],
                'correct' => 0,
            ],
            [
                'q' => '¿Qué problema describe el término "documentos de escritorio" en una auditoría del SPLAFT?',
                'options' => [
                    'Documentos impresos en papel reciclado',
                    'Manuales bien redactados que no reflejan los procesos reales que se ejecutan',
                    'Documentos firmados digitalmente',
                    'Documentos que están en un idioma distinto al español',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Qué implica el testeo de controles DDC/KYC?',
                'options' => [
                    'Revisar una muestra de expedientes de clientes y operaciones para verificar el cumplimiento efectivo de la DDC',
                    'Entrevistar únicamente al gerente general',
                    'Verificar solo la limpieza de las oficinas',
                    'Revisar exclusivamente los contratos laborales',
                ],
                'correct' => 0,
            ],
            [
                'q' => '¿Qué debe incluir el informe de auditoría además de los hallazgos?',
                'options' => [
                    'Solo un listado de trabajadores',
                    'Recomendaciones específicas y plazos sugeridos para subsanar cada hallazgo',
                    'El organigrama completo de la empresa',
                    'Los estados financieros del último año',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Por qué es necesario el seguimiento posterior al informe de auditoría?',
                'options' => [
                    'No es necesario, el proceso termina con el informe',
                    'Para verificar que las observaciones fueron subsanadas dentro de los plazos comprometidos',
                    'Solo para fines estadísticos sin ninguna acción posterior',
                    'Para calcular las comisiones del equipo de ventas',
                ],
                'correct' => 1,
            ],
        ];
    }

    private function svgCover(string $icon, string $label): string
    {
        $iconMarkup = match ($icon) {
            'shield' => '<path d="M400 108 L448 128 L448 168 C448 200 426 226 400 236 C374 226 352 200 352 168 L352 128 Z" fill="none" stroke="#FAFAF6" stroke-width="2.5"/><path d="M400 128 L424 139 L424 165 C424 182 413 196 400 202 C387 196 376 182 376 165 L376 139 Z" fill="#8B7340"/>',
            'scale' => '<line x1="400" y1="112" x2="400" y2="196" stroke="#FAFAF6" stroke-width="2.5"/><line x1="356" y1="130" x2="444" y2="130" stroke="#FAFAF6" stroke-width="2.5"/><circle cx="356" cy="130" r="4" fill="#FAFAF6"/><circle cx="444" cy="130" r="4" fill="#FAFAF6"/><path d="M340 130 L356 168 L372 130 Z" fill="none" stroke="#B89A56" stroke-width="2"/><path d="M428 130 L444 168 L460 130 Z" fill="none" stroke="#B89A56" stroke-width="2"/><rect x="388" y="196" width="24" height="8" rx="2" fill="#8B7340"/>',
            default => '<rect x="360" y="180" width="14" height="40" fill="#8B7340"/><rect x="384" y="155" width="14" height="65" fill="#B89A56"/><rect x="408" y="130" width="14" height="90" fill="#8B7340"/><rect x="432" y="165" width="14" height="55" fill="#B89A56"/><line x1="352" y1="228" x2="452" y2="228" stroke="#FAFAF6" stroke-width="1.5"/>',
        };

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 450" width="800" height="450">
  <defs>
    <radialGradient id="glow" cx="80%" cy="10%" r="60%">
      <stop offset="0%" stop-color="#8B7340" stop-opacity="0.35"/>
      <stop offset="100%" stop-color="#8B7340" stop-opacity="0"/>
    </radialGradient>
    <linearGradient id="lineFade" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0%" stop-color="#8B7340" stop-opacity="0"/>
      <stop offset="50%" stop-color="#B89A56" stop-opacity="1"/>
      <stop offset="100%" stop-color="#8B7340" stop-opacity="0"/>
    </linearGradient>
  </defs>

  <rect width="800" height="450" fill="#0B1829"/>
  <rect width="800" height="450" fill="url(#glow)"/>

  <g stroke="#1C2E45" stroke-width="1.5" opacity="0.7">
    <line x1="0" y1="380" x2="420" y2="0"/>
    <line x1="60" y1="450" x2="500" y2="0"/>
    <line x1="160" y1="450" x2="600" y2="0"/>
    <line x1="280" y1="450" x2="720" y2="0"/>
  </g>

  {$iconMarkup}

  <line x1="260" y1="255" x2="540" y2="255" stroke="url(#lineFade)" stroke-width="1.5"/>

  <text x="400" y="325" font-family="Arial, sans-serif" font-size="15" fill="#B89A56" text-anchor="middle" letter-spacing="3">{$label}</text>

  <text x="400" y="410" font-family="Georgia, 'Times New Roman', serif" font-size="16" font-weight="700" fill="#FAFAF6" text-anchor="middle" letter-spacing="2" opacity="0.85">ROMANI COMPLIANCE</text>
</svg>
SVG;
    }
}
