<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SplaftDemoCourseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $instructor = User::where('email', 'denis@romanicompliance.com')->first();

        $category = Category::firstOrCreate(
            ['slug' => 'prevencion-laft'],
            ['name' => 'Prevención LA/FT', 'description' => 'Capacitaciones sobre el sistema de prevención de lavado de activos y financiamiento del terrorismo.']
        );

        $course = Course::updateOrCreate(
            ['slug' => 'nociones-basicas-splaft'],
            [
                'category_id' => $category->id,
                'created_by' => $admin?->id,
                'title' => 'Nociones Básicas del SPLAFT',
                'description' => 'Curso introductorio sobre el Sistema de Prevención del Lavado de Activos y Financiamiento del Terrorismo (SPLAFT): qué es, qué obligaciones comprende, cómo aplicar la debida diligencia en el conocimiento del cliente y el contexto regulatorio vigente en el Perú. Contenido elaborado con base en el Boletín Informativo N° 99 de la Superintendencia Adjunta de la Unidad de Inteligencia Financiera del Perú (SBS/UIF).',
                'cover_image' => 'courses/covers/splaft-basico.svg',
                'instructor_name' => 'Denis Gabriel Romani Seminario',
                'instructor_id' => $instructor?->id,
                'duration_minutes' => 120,
                'is_published' => true,
            ]
        );

        $course->modules->each(fn ($module) => $module->lessons()->delete());
        $course->modules()->delete();
        $course->exam()->delete();

        $modulesData = [
            [
                'title' => 'Módulo 1: Introducción al SPLAFT',
                'lessons' => [
                    [
                        'title' => '¿Qué es el SPLAFT? (video UIF - GIZ)',
                        'type' => 'video',
                        'video_url' => 'https://www.youtube.com/watch?v=9x9f0rVp-8E',
                        'duration_minutes' => 15,
                    ],
                    [
                        'title' => 'Concepto y marco normativo',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "El Sistema de Prevención del Lavado de Activos y Financiamiento del Terrorismo (SPLAFT) está conformado por las políticas y los procedimientos establecidos por el sujeto obligado a informar, de acuerdo con la Ley N.° 27693, su Reglamento y demás disposiciones sobre la materia, en consideración a los factores de riesgo del LA/FT.\n\nEl sistema comprende también los procedimientos y controles vinculados a la detección oportuna y reporte de operaciones sospechosas, con la finalidad de evitar que los productos o servicios que la organización presta a sus clientes o usuarios sean utilizados con fines vinculados a los delitos de LA/FT, garantizando en todo momento el deber de reserva indeterminado de la información relacionada con dicho sistema.\n\nSi el sujeto obligado desarrolla más de una de las actividades comprendidas en el artículo 3 de la Ley N.° 29038, debe implementar un solo SPLAFT, sin perjuicio de cumplir con las exigencias específicas que correspondan a cada actividad.\n\nFuente: Superintendencia Adjunta de Unidad de Inteligencia Financiera del Perú (SBS/UIF), Boletín Informativo N.° 99, 2021.",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 2: Componentes y obligaciones del SPLAFT',
                'lessons' => [
                    [
                        'title' => '¿Qué comprende el SPLAFT?',
                        'type' => 'text',
                        'duration_minutes' => 15,
                        'content' => "El SPLAFT comprende, entre otros, los siguientes aspectos:\n\n• Aprobar las políticas y procedimientos para la gestión de los riesgos de LA/FT.\n• Designar un oficial de cumplimiento, de acuerdo con las características, responsabilidades y atribuciones que establece la normativa vigente, y comunicarlo a la UIF.\n• Aprobar las políticas de debida diligencia en el conocimiento de los clientes, beneficiario final, proveedores y contrapartes, directores y trabajadores.\n• Capacitarse periódicamente en materia de prevención de LA/FT.\n• Aprobar, implementar, aplicar, actualizar y conservar el Manual de prevención y gestión de los riesgos de LA/FT y el Código de conducta.\n• Realizar auditoría interna y externa del SPLAFT, según corresponda.\n• Mantener actualizado, conservar y remitir el registro de operaciones.\n• Aprobar procedimientos para prevenir y detectar operaciones inusuales, manteniendo un registro de dichas operaciones.\n• Aprobar procedimientos para prevenir, detectar y comunicar a la UIF, en el plazo establecido, las operaciones sospechosas presuntamente vinculadas al LA/FT, a través de un Reporte de Operaciones Sospechosas (ROS).\n• Emitir el informe anual o semestral sobre la situación del SPLAFT y su cumplimiento.\n• Implementar mecanismos de atención de los requerimientos de información de la UIF y las autoridades competentes.\n\nFuente: Boletín Informativo SBS/UIF N.° 99, 2021.",
                    ],
                    [
                        'title' => 'Boletín informativo SBS/UIF N.° 99 — Lectura complementaria',
                        'type' => 'pdf',
                        'duration_minutes' => 20,
                        'file_path' => 'lessons/files/boletin-sbs-uif-n99-splaft.pdf',
                    ],
                ],
            ],
            [
                'title' => 'Módulo 3: Debida diligencia en el conocimiento del cliente',
                'lessons' => [
                    [
                        'title' => 'Debida diligencia basada en riesgos',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "La debida diligencia en el conocimiento del cliente (DDC) es un componente esencial de todo SPLAFT. Su objetivo es identificar y verificar adecuadamente a los clientes, beneficiarios finales, proveedores y contrapartes, aplicando un enfoque basado en riesgos: a mayor riesgo de LA/FT identificado, mayor nivel de diligencia exigido.\n\nSegún este enfoque, la DDC puede clasificarse en simplificada, estándar o reforzada, dependiendo del perfil de riesgo del cliente y de la operación. Este esquema está desarrollado, entre otras normas, en la Resolución SBS N.° 789-2018 y en las guías sectoriales que la UIF publica para distintas actividades económicas.\n\nUna adecuada DDC permite, además, identificar oportunamente a las Personas Expuestas Políticamente (PEP) y contrastar la información del cliente contra las listas restrictivas nacionales e internacionales vigentes.",
                    ],
                    [
                        'title' => 'Sistemas de identificación digital para la DDC',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "La aceleración de los canales digitales de atención —especialmente desde el inicio de la pandemia por COVID-19— incrementó el riesgo de LA/FT en operaciones no presenciales, dado el mayor grado de incertidumbre sobre la identidad real del cliente.\n\nEn este contexto, el Grupo de Acción Financiera Internacional (GAFI), en su Recomendación N.° 10, publicó una guía sobre identificación digital que describe cinco componentes básicos que debería tener todo sistema de identificación digital aplicado a la DDC:\n\n1. Recolección: presentación y recolección de datos y evidencia de identificación (formularios electrónicos, fotos de documentos de identidad).\n2. Validación: confirmar que el documento sea auténtico y que sus datos sean precisos, revisando características de seguridad, fechas de emisión/vencimiento y fuentes oficiales.\n3. Filtro de duplicados: verificar que la información presentada corresponda a una única persona, mediante búsquedas automatizadas o reconocimiento facial.\n4. Verificación: corroborar la correspondencia entre el cliente y la evidencia presentada, por ejemplo mediante biometría y detección de vida.\n5. Registro y vinculación: una vez completados los pasos anteriores, registrar al cliente generando un usuario y clave para su autenticación, que puede reforzarse con preguntas de seguridad, reconocimiento facial o huella digital.\n\nFuente: Boletín Informativo SBS/UIF N.° 99, 2021, con base en la guía del GAFI sobre identificación digital (marzo 2020).",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 4: Contexto regulatorio y actualidad',
                'lessons' => [
                    [
                        'title' => 'El sistema antilavado como facilitador de la actividad económica',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "Proteger a los sectores económicos de la penetración de dinero de origen ilícito es uno de los primeros objetivos de los sistemas antilavado de activos y contra la financiación del terrorismo (ALA/CFT). La lucha contra el lavado de activos atiende dos frentes complementarios: por un lado, evita que dinero de origen ilícito penetre en la economía legal; por otro, ayuda a crear condiciones para un entorno económico seguro que favorezca la inversión, el crecimiento y la generación de empleo.\n\nLa bancarización y la inclusión financiera de todos los sectores económicos lícitos son claves para la reactivación: en la medida en que más actividades cuenten con el respaldo de instituciones financieras supervisadas, será más difícil que sean utilizadas para ocultar el origen ilícito de recursos, y más fácil identificar operaciones inusuales o sospechosas.\n\nPor ello, la implementación de sistemas de administración de riesgos de LA/FT robustos y efectivos no debe entenderse únicamente como una carga regulatoria, sino como un facilitador de la actividad económica formal.",
                    ],
                    [
                        'title' => 'Sanciones internacionales y avisos importantes',
                        'type' => 'text',
                        'duration_minutes' => 10,
                        'content' => "Además del marco normativo nacional, los sujetos obligados deben estar atentos a los comunicados de organismos internacionales relacionados con el financiamiento del terrorismo. Por ejemplo, el Comité del Consejo de Seguridad de las Naciones Unidas, de conformidad con las Resoluciones 1267 (1999), 1989 (2011) y 2253 (2015), publica y actualiza periódicamente su Lista de sanciones contra el EIIL (Daesh) y Al-Qaida, incorporando personas y entidades sujetas a:\n\n• Congelación de activos.\n• Prohibición de viajar.\n• Embargo de armas.\n\nEstas medidas se adoptan en virtud del Capítulo VII de la Carta de las Naciones Unidas. Contrastar oportunamente a clientes, beneficiarios finales y contrapartes contra estas listas restrictivas es una obligación permanente dentro de cualquier SPLAFT, y debe formar parte de los procedimientos de debida diligencia y monitoreo continuo.",
                    ],
                ],
            ],
        ];

        foreach ($modulesData as $order => $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
                'order' => $order + 1,
            ]);

            foreach ($moduleData['lessons'] as $lessonOrder => $lessonData) {
                $module->lessons()->create([
                    'title' => $lessonData['title'],
                    'type' => $lessonData['type'],
                    'video_url' => $lessonData['video_url'] ?? null,
                    'file_path' => $lessonData['file_path'] ?? null,
                    'content' => $lessonData['content'] ?? null,
                    'duration_minutes' => $lessonData['duration_minutes'] ?? null,
                    'order' => $lessonOrder + 1,
                ]);
            }
        }

        $exam = $course->exam()->create([
            'title' => 'Examen final: Nociones básicas del SPLAFT',
            'passing_score' => 70,
            'max_attempts' => 3,
            'time_limit_minutes' => 20,
        ]);

        $questions = [
            [
                'q' => '¿Qué es el SPLAFT?',
                'options' => [
                    'Un impuesto especial que pagan las entidades financieras a la SBS',
                    'El conjunto de políticas y procedimientos del sujeto obligado para prevenir el LA/FT, conforme a la Ley N.° 27693 y su Reglamento',
                    'Un software contable de uso obligatorio para bancos',
                    'Un tipo de licencia comercial otorgada por la UIF',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Ante quién debe comunicarse la designación del Oficial de Cumplimiento?',
                'options' => ['Ante la SUNAT', 'Ante el Ministerio Público', 'Ante la UIF', 'Ante el cliente'],
                'correct' => 2,
            ],
            [
                'q' => 'Si un sujeto obligado realiza más de una actividad comprendida en el artículo 3 de la Ley N.° 29038, ¿cuántos SPLAFT debe implementar?',
                'options' => [
                    'Uno por cada actividad que realice',
                    'Uno solo, cumpliendo las exigencias específicas de cada actividad',
                    'Ninguno, basta con el manual de la matriz',
                    'Depende del número de trabajadores',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿A través de qué mecanismo se comunican a la UIF las operaciones sospechosas?',
                'options' => ['Un correo electrónico informal', 'Un Reporte de Operaciones Sospechosas (ROS)', 'Una llamada telefónica', 'Un comunicado de prensa'],
                'correct' => 1,
            ],
            [
                'q' => 'Según la guía del GAFI, ¿cuál es el primer componente de un sistema de identificación digital para la DDC?',
                'options' => ['Verificación', 'Registro y vinculación', 'Recolección', 'Filtro de duplicados'],
                'correct' => 2,
            ],
            [
                'q' => '¿Qué recomendación del GAFI está directamente relacionada con la debida diligencia del cliente?',
                'options' => ['Recomendación N.° 1', 'Recomendación N.° 10', 'Recomendación N.° 40', 'Recomendación N.° 25'],
                'correct' => 1,
            ],
            [
                'q' => 'El Comité del Consejo de Seguridad de la ONU, respecto a personas y entidades sancionadas, aplica principalmente:',
                'options' => [
                    'Multas económicas directas al sujeto obligado',
                    'Congelación de activos, prohibición de viajar y embargo de armas',
                    'Suspensión temporal de su documento de identidad',
                    'Cierre inmediato de cualquier cuenta bancaria en el mundo',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'Según el boletín, ¿por qué la bancarización y la inclusión financiera ayudan al sistema antilavado?',
                'options' => [
                    'Porque eliminan por completo el riesgo de LA/FT',
                    'Porque facilitan identificar posibles operaciones de lavado de activos y dinamizan la economía formal',
                    'Porque reducen la cantidad de sujetos obligados',
                    'Porque no tienen relación con la prevención de LA/FT',
                ],
                'correct' => 1,
            ],
        ];

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

        $this->command?->info('Curso demo "Nociones Básicas del SPLAFT" creado con '.count($modulesData).' módulos y '.count($questions).' preguntas.');
    }
}
