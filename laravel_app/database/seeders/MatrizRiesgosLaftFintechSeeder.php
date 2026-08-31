<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class MatrizRiesgosLaftFintechSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::where('email', 'denis@romanicompliance.com')->first();

        $category = Category::firstOrCreate(
            ['slug' => 'prevencion-laft'],
            ['name' => 'Prevención LA/FT', 'description' => 'Capacitaciones sobre el sistema de prevención de lavado de activos y financiamiento del terrorismo.']
        );

        $course = Course::updateOrCreate(
            ['slug' => 'matriz-gestion-riesgos-laft-fintech'],
            [
                'category_id' => $category->id,
                'created_by' => $instructor?->id,
                'instructor_id' => $instructor?->id,
                'instructor_name' => 'Denis Gabriel Romani Seminario',
                'title' => 'Matriz de Gestión de Riesgos LA/FT: Cómo Elaborarla y Calcularla',
                'description' => 'Curso práctico e interactivo sobre cómo construir y calcular una Matriz de Gestión de Riesgos (MGR) de Lavado de Activos y Financiamiento del Terrorismo, usando como caso guía un modelo referencial de empresa fintech con producto de préstamos: metodología de cálculo (RI = P × I, RR = RI − EC), glosario interactivo, juego de memoria y una actividad de arrastrar y soltar para clasificar riesgos.',
                'cover_image' => 'courses/covers/matriz-gestion-riesgos-laft.svg',
                'duration_minutes' => 60,
                'is_published' => true,
                'certificate_type' => 'opcional',
                'certificate_price' => 50.00,
            ]
        );

        $course->modules->each(fn ($module) => $module->lessons()->delete());
        $course->modules()->delete();
        $course->exam()->delete();

        // ---------------------------------------------------------------
        // Módulo 1 — Fundamentos (diapositiva interactiva con revelado
        // palabra por palabra + citas y fuentes normativas)
        // ---------------------------------------------------------------
        $introSlide = [
            'intro' => 'Antes de calcular una sola cifra, hay que entender qué es realmente la MGR y por qué la ley la exige. Avanza diapositiva por diapositiva.',
            'slides' => [
                [
                    'heading' => 'El documento técnico',
                    'text' => 'La Matriz de Gestión de Riesgos (MGR) es el instrumento mediante el cual un sujeto obligado identifica, valora y controla su exposición al Lavado de Activos y Financiamiento del Terrorismo.',
                    'highlight' => ['Matriz', 'Gestión', 'Riesgos', 'identifica', 'valora', 'controla'],
                ],
                [
                    'heading' => 'No es un formato, es evidencia',
                    'text' => 'Bajo el Enfoque Basado en Riesgos que exige la SBS y la UIF-Perú, la matriz debe reflejar el funcionamiento real del negocio: llenar una plantilla sin sustento documentado no cumple el estándar exigido.',
                    'highlight' => ['Enfoque', 'Basado', 'Riesgos', 'evidencia'],
                    'citation' => ['label' => 'Res. SBS N.º 02648-2024', 'note' => 'Fija las directrices del SPLAFT para Proveedores de Servicios de Activos Virtuales (PSAV) y exige evaluar Clientes, Productos, Canales y Geografía.'],
                ],
                [
                    'heading' => 'El caso guía de este curso',
                    'text' => 'Trabajaremos sobre un modelo referencial de una empresa fintech que combina el canje de activos virtuales con el otorgamiento de préstamos, un caso donde el riesgo crediticio se suma al riesgo cripto ya existente.',
                    'highlight' => ['fintech', 'préstamos', 'riesgo', 'crediticio'],
                ],
                [
                    'heading' => 'Tres pilares de control',
                    'text' => 'Toda matriz seria se apoya en tres pilares complementarios: KYC, el conocimiento del cliente; KYT, el conocimiento de las transacciones y del personal; y KYB, el conocimiento de proveedores y contrapartes.',
                    'highlight' => ['KYC', 'KYT', 'KYB'],
                ],
            ],
            'sources' => [
                ['label' => 'Ley N.º 27693', 'desc' => 'Crea y regula la Unidad de Inteligencia Financiera del Perú (UIF-Perú).'],
                ['label' => 'Res. SBS N.º 02648-2024', 'desc' => 'Directrices del SPLAFT para Proveedores de Servicios de Activos Virtuales (PSAV).'],
            ],
        ];

        $legalSlide = [
            'intro' => 'La evaluación de riesgos LA/FT responde a un marco normativo concurrente. Cada norma delimita una parte del alcance que la matriz debe poder sustentar.',
            'slides' => [
                [
                    'heading' => 'Ley N.º 27693',
                    'text' => 'Crea y regula la Unidad de Inteligencia Financiera del Perú, la autoridad central que recibe los Reportes de Operaciones Sospechosas de todos los sujetos obligados del país.',
                    'highlight' => ['Unidad', 'Inteligencia', 'Financiera'],
                    'citation' => ['label' => 'Ley N.º 27693', 'note' => 'Norma de creación de la UIF-Perú.'],
                ],
                [
                    'heading' => 'D.L. N.º 1106',
                    'text' => 'Decreto Legislativo de lucha eficaz contra el lavado de activos y otros delitos relacionados a la minería ilegal y crimen organizado.',
                    'highlight' => ['lavado', 'activos'],
                    'citation' => ['label' => 'D.L. N.º 1106', 'note' => 'Lucha eficaz contra el lavado de activos y otros delitos relacionados.'],
                ],
                [
                    'heading' => 'Res. SBS N.º 02648-2024',
                    'text' => 'Establece las directrices del SPLAFT específicas para Proveedores de Servicios de Activos Virtuales, exigiendo evaluar de forma diferenciada a los Clientes, los Productos, los Canales y la Geografía.',
                    'highlight' => ['PSAV', 'Clientes', 'Productos', 'Canales', 'Geografía'],
                    'citation' => ['label' => 'Res. SBS N.º 02648-2024', 'note' => 'Directrices del SPLAFT para Proveedores de Servicios de Activos Virtuales (PSAV).'],
                ],
                [
                    'heading' => 'Res. SBS N.º 4463-2016',
                    'text' => 'Regula la gestión de riesgos y prevención del LA/FT para los sujetos obligados dedicados al otorgamiento de préstamos y al empeño, el producto crediticio del caso guía de este curso.',
                    'highlight' => ['préstamos', 'empeño'],
                    'citation' => ['label' => 'Res. SBS N.º 4463-2016', 'note' => 'Gestión de riesgos y prevención del LA/FT para sujetos obligados dedicados al otorgamiento de préstamos y empeño.'],
                ],
                [
                    'heading' => 'Res. SBS N.º 789-2018',
                    'text' => 'Norma de prevención del LA/FT aplicable, en general, a los sujetos obligados que se encuentran bajo la supervisión directa de la UIF-Perú.',
                    'highlight' => ['UIF-Perú', 'supervisión'],
                    'citation' => ['label' => 'Res. SBS N.º 789-2018', 'note' => 'Prevención del LA/FT aplicable a los sujetos obligados bajo supervisión de la UIF-Perú.'],
                ],
                [
                    'heading' => 'Regla clave: un solo SPLAFT',
                    'text' => 'Si una empresa realiza más de una actividad de las comprendidas en el artículo 3 de la Ley N.º 29038, no implementa varios sistemas paralelos: implementa un único SPLAFT que cumpla, a la vez, las exigencias de cada actividad.',
                    'highlight' => ['único', 'SPLAFT'],
                    'citation' => ['label' => 'Ley N.º 29038, artículo 3', 'note' => 'Lista las actividades sujetas a reportar operaciones a la UIF-Perú, incluyendo el canje de activos virtuales y el otorgamiento de préstamos.'],
                ],
            ],
            'sources' => [
                ['label' => 'Ley N.º 27693', 'desc' => 'Crea y regula la Unidad de Inteligencia Financiera del Perú (UIF-Perú).'],
                ['label' => 'D.L. N.º 1106', 'desc' => 'Lucha eficaz contra el lavado de activos y otros delitos relacionados.'],
                ['label' => 'Res. SBS N.º 02648-2024', 'desc' => 'Directrices del SPLAFT para Proveedores de Servicios de Activos Virtuales (PSAV).'],
                ['label' => 'Res. SBS N.º 4463-2016', 'desc' => 'Gestión de riesgos y prevención del LA/FT para sujetos obligados dedicados al otorgamiento de préstamos y empeño.'],
                ['label' => 'Res. SBS N.º 789-2018', 'desc' => 'Prevención del LA/FT aplicable a los sujetos obligados bajo supervisión de la UIF-Perú.'],
                ['label' => 'Ley N.º 29038, artículo 3', 'desc' => 'Actividades sujetas a reporte ante la UIF-Perú; base de la regla de un único SPLAFT.'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 2 — Metodología
        // ---------------------------------------------------------------
        $formulas = [
            'intro' => 'Toda la Matriz de Gestión de Riesgos se resuelve con dos operaciones simples. Domínalas y podrás calcular cualquier fila de cualquier matriz de riesgos LA/FT.',
            'formulas' => [
                ['label' => 'Paso 1 — Riesgo Inherente', 'eq' => 'RI = P × I', 'note' => 'Exposición en estado puro, sin controles. El RI máximo posible es 9 (3 × 3).'],
                ['label' => 'Paso 2 — Riesgo Residual', 'eq' => 'RR = RI − EC', 'note' => 'Riesgo remanente tras aplicar los controles. Si el resultado es negativo, se consigna 0.'],
            ],
            'escala' => [
                ['nivel' => 'Bajo', 'punt' => '1', 'p' => 'Improbable (>5 años)', 'i' => 'Daño menor (solo operativo)', 'ec' => '0 (inexistente) / 2 (baja)'],
                ['nivel' => 'Medio', 'punt' => '2', 'p' => 'Posible (ocurrencia anual)', 'i' => 'Daño significativo (legal/financiero)', 'ec' => '4 (efectiva, semiautomatizada)'],
                ['nivel' => 'Alto', 'punt' => '3', 'p' => 'Muy probable (frecuente)', 'i' => 'Daño grave (multa, cierre)', 'ec' => '6 (óptima, automática)'],
            ],
            'rangos' => [
                ['rango' => '1 a 3', 'nivel' => 'BAJO', 'plan' => 'Aceptable. Monitoreo estándar.'],
                ['rango' => '4 a 6', 'nivel' => 'MEDIO', 'plan' => 'Requiere plan de mejora de controles y monitoreo reforzado.'],
                ['rango' => '7 a 9', 'nivel' => 'ALTO', 'plan' => 'Crítico. Suspensión inmediata de la actividad y reporte a Gerencia.'],
            ],
            'ejemplo' => [
                'titulo' => 'Ejemplo de cálculo — riesgo PR-01',
                'pasos' => [
                    ['txt' => 'Riesgo: uso del préstamo para integrar fondos ilícitos (repago con fondos de origen dudoso)', 'val' => 'P = 3, I = 3'],
                    ['txt' => 'Riesgo Inherente: RI = P × I = 3 × 3', 'val' => 'RI = 9'],
                    ['txt' => 'Control aplicado: evaluación de origen de fondos + límites de monto + evaluación de propósito', 'val' => 'EC = 4'],
                    ['txt' => 'Riesgo Residual: RR = RI − EC = 9 − 4', 'val' => 'RR = 5'],
                    ['txt' => 'Clasificación final según tabla de rangos (4 a 6)', 'val' => 'Nivel: MEDIO'],
                ],
            ],
        ];

        $glossary = [
            'intro' => 'Haz clic en cada término para ver su definición completa y qué otro concepto no debes confundir con él.',
            'terms' => [
                ['term' => 'RI', 'icon' => '📈', 'short' => 'Riesgo Inherente', 'definition' => 'Nivel de riesgo antes de considerar controles. Se calcula como RI = P × I. Representa la exposición en estado puro.', 'confuse' => 'RR (Riesgo Residual): el RI es "antes" de los controles, el RR es "después".'],
                ['term' => 'RR', 'icon' => '📉', 'short' => 'Riesgo Residual', 'definition' => 'Riesgo que permanece tras aplicar los controles. Se calcula como RR = RI − EC. Es la clasificación final de cada fila de la matriz.', 'confuse' => 'RI (Riesgo Inherente): no confundir el resultado final (RR) con la exposición bruta (RI).'],
                ['term' => 'P', 'icon' => '🎲', 'short' => 'Probabilidad', 'definition' => 'Frecuencia o posibilidad de que el riesgo se materialice, en escala de 1 a 3.', 'confuse' => 'I (Impacto): la probabilidad mide "qué tan seguido", el impacto mide "qué tan grave".'],
                ['term' => 'I', 'icon' => '💥', 'short' => 'Impacto', 'definition' => 'Gravedad del daño si el riesgo se materializa, en escala de 1 a 3.', 'confuse' => 'P (Probabilidad): un riesgo puede tener impacto alto pero probabilidad baja, o viceversa.'],
                ['term' => 'EC', 'icon' => '🛡️', 'short' => 'Eficacia de Controles', 'definition' => 'Fortaleza y robustez de las medidas de mitigación, en escala de 0 a 6.', 'confuse' => 'RR: el EC es un insumo del cálculo, no el resultado. Se resta al RI para obtener el RR.'],
                ['term' => 'EBR', 'icon' => '🎯', 'short' => 'Enfoque Basado en Riesgos', 'definition' => 'Principio que obliga a destinar mayores recursos de prevención a las áreas de mayor riesgo.', 'confuse' => 'SPLAFT: el SPLAFT es el sistema completo; el EBR es el principio metodológico que lo guía.'],
                ['term' => 'PEP', 'icon' => '🏛️', 'short' => 'Persona Expuesta Políticamente', 'definition' => 'Individuo con riesgo inherente mayor por su función pública; requiere Debida Diligencia Reforzada.', 'confuse' => 'KYC: el KYC es el proceso general de conocer al cliente; el PEP es una categoría de cliente de mayor riesgo dentro de ese proceso.'],
                ['term' => 'DeFi', 'icon' => '🌐', 'short' => 'Finanzas Descentralizadas', 'definition' => 'Protocolos de activos virtuales sin punto de control centralizado. Se consideran de Riesgo ALTO en el modelo del curso.', 'confuse' => 'PSAV: un PSAV es la empresa que presta el servicio; DeFi es un tipo de protocolo con el que esa empresa puede (o no) operar.'],
                ['term' => 'KYC', 'icon' => '🪪', 'short' => 'Know Your Customer', 'definition' => 'Obtención y verificación de identidad y perfil del cliente antes de la relación comercial.', 'confuse' => 'KYT y KYB: KYC es sobre el cliente; KYT es sobre transacciones/personal; KYB es sobre proveedores y contrapartes.'],
                ['term' => 'KYT', 'icon' => '🔍', 'short' => 'Know Your Transaction', 'definition' => 'Verificación, capacitación y monitoreo del personal y de las transacciones.', 'confuse' => 'KYC: no confundir el monitoreo de operaciones y personal (KYT) con la identificación del cliente (KYC).'],
                ['term' => 'KYB', 'icon' => '🤝', 'short' => 'Know Your Business', 'definition' => 'Debida diligencia aplicada a proveedores críticos y contrapartes jurídicas.', 'confuse' => 'KYC: el KYB se aplica a empresas/contrapartes, el KYC se aplica a clientes.'],
                ['term' => 'LTV', 'icon' => '💰', 'short' => 'Loan-to-Value', 'definition' => 'Relación entre el monto del préstamo y el valor del colateral en activos virtuales.', 'confuse' => 'RR: el LTV es una medida financiera del crédito, no una clasificación de riesgo LA/FT.'],
                ['term' => 'Estructuración', 'icon' => '🧩', 'short' => 'Pitufeo', 'definition' => 'División de grandes sumas en múltiples operaciones pequeñas para eludir umbrales de detección.', 'confuse' => 'Fraccionamiento contable: la estructuración tiene fin ilícito de evasión de controles, no es una técnica contable legítima.'],
            ],
        ];

        $memory = [
            'instructions' => 'Encuentra las parejas: cada fórmula o rango con su resultado o nivel correspondiente.',
            'pairs' => [
                ['a' => 'RI', 'b' => 'P × I', 'icon' => '📈'],
                ['a' => 'RR', 'b' => 'RI − EC', 'icon' => '📉'],
                ['a' => 'BAJO', 'b' => '1 a 3', 'icon' => '🟢'],
                ['a' => 'MEDIO', 'b' => '4 a 6', 'icon' => '🟡'],
                ['a' => 'ALTO', 'b' => '7 a 9', 'icon' => '🔴'],
                ['a' => 'EBR', 'b' => 'Más recursos a mayor riesgo', 'icon' => '🎯'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 3 — Aplicación práctica
        // ---------------------------------------------------------------
        $matrixBuilder = [
            'intro' => 'Arrastra cada riesgo hacia la matriz a la que pertenece en el modelo del curso. Al soltarlo correctamente verás su P, I y RI.',
            'categories' => [
                ['id' => 'operacional', 'label' => 'Operacional — Canje de Activos Virtuales'],
                ['id' => 'prestamos', 'label' => 'Producto de Préstamos'],
                ['id' => 'canales', 'label' => 'Canales y Ciberseguridad'],
                ['id' => 'personal', 'label' => 'Personal (KYT)'],
            ],
            'items' => [
                ['id' => 'i1', 'label' => 'Suplantación de identidad', 'category' => 'operacional', 'hint' => 'P=3, I=3 → RI=9'],
                ['id' => 'i2', 'label' => 'Uso de mixers / anonimización', 'category' => 'operacional', 'hint' => 'P=2, I=3 → RI=6'],
                ['id' => 'i3', 'label' => 'Uso del préstamo para integrar fondos ilícitos', 'category' => 'prestamos', 'hint' => 'P=3, I=3 → RI=9'],
                ['id' => 'i4', 'label' => 'Colateral en activos no trazables', 'category' => 'prestamos', 'hint' => 'P=3, I=3 → RI=9'],
                ['id' => 'i5', 'label' => 'Ciberataque a la plataforma', 'category' => 'canales', 'hint' => 'P=3, I=3 → RI=9'],
                ['id' => 'i6', 'label' => 'Captación de clientes sin debida diligencia', 'category' => 'canales', 'hint' => 'P=3, I=3 → RI=9'],
                ['id' => 'i7', 'label' => 'Colusión del analista con el cliente', 'category' => 'personal', 'hint' => 'P=2, I=3 → RI=6'],
                ['id' => 'i8', 'label' => 'Deficiencia de capacitación PLAFT', 'category' => 'personal', 'hint' => 'P=3, I=3 → RI=9'],
            ],
        ];

        $balance = [
            'intro' => 'El cálculo final del Riesgo Residual (RR) sobre los 37 riesgos evaluados en el modelo arroja este balance:',
            'bars' => [
                ['label' => 'ALTO', 'count' => 1, 'total' => 37, 'color' => 'red'],
                ['label' => 'MEDIO', 'count' => 14, 'total' => 37, 'color' => 'amber'],
                ['label' => 'BAJO', 'count' => 22, 'total' => 37, 'color' => 'green'],
            ],
            'note' => 'La amplia mayoría de riesgos se gestiona en nivel BAJO, con una proporción razonable en MEDIO y un único riesgo ALTO (C-05, protocolos no trazables/DeFi) sujeto a suspensión anticipada. Esto confirma la correcta aplicación del Enfoque Basado en Riesgos.',
        ];

        $modulesData = [
            [
                'title' => 'Módulo 1: Fundamentos de la Matriz de Gestión de Riesgos',
                'lessons' => [
                    ['title' => '¿Qué es la MGR y por qué es obligatoria?', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'slide'] + $introSlide)],
                    ['title' => 'Marco legal aplicable', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'slide'] + $legalSlide)],
                    ['title' => 'Descarga: Modelo editable de Matriz de Gestión de Riesgos LA/FT (Word)', 'type' => 'file', 'duration_minutes' => 5, 'file_path' => 'lessons/files/modelo-matriz-gestion-riesgos-laft-fintech-prestamos.docx'],
                ],
            ],
            [
                'title' => 'Módulo 2: Metodología de cálculo',
                'lessons' => [
                    ['title' => 'Fórmulas, escalas y ejemplo de cálculo', 'type' => 'interactive', 'duration_minutes' => 15, 'content' => json_encode(['kind' => 'formulas'] + $formulas)],
                    ['title' => 'Glosario interactivo de conceptos clave', 'type' => 'glossary', 'duration_minutes' => 10, 'content' => json_encode($glossary)],
                    ['title' => 'Juego: Empareja fórmulas y niveles de riesgo', 'type' => 'memory', 'duration_minutes' => 8, 'content' => json_encode($memory)],
                ],
            ],
            [
                'title' => 'Módulo 3: Aplicación práctica',
                'lessons' => [
                    ['title' => 'Arrastra y clasifica: ¿en qué matriz va cada riesgo?', 'type' => 'interactive', 'duration_minutes' => 12, 'content' => json_encode(['kind' => 'matrix_builder'] + $matrixBuilder)],
                    ['title' => 'Balance técnico final', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'balance'] + $balance)],
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
            'title' => 'Autoevaluación: Matriz de Gestión de Riesgos LA/FT',
            'passing_score' => 70,
            'max_attempts' => 3,
            'time_limit_minutes' => 20,
        ]);

        $questions = [
            [
                'q' => '¿Cuál es la fórmula del Riesgo Inherente (RI)?',
                'options' => ['RI = P + I', 'RI = P × I', 'RI = P − I', 'RI = EC × I'],
                'correct' => 1,
            ],
            [
                'q' => '¿Cuál es la fórmula del Riesgo Residual (RR)?',
                'options' => ['RR = P × I', 'RR = RI + EC', 'RR = RI − EC', 'RR = EC − RI'],
                'correct' => 2,
            ],
            [
                'q' => 'Si P = 3, I = 3 y el control aplicado tiene una Eficacia de Controles (EC) = 4, ¿cuál es el Riesgo Residual (RR)?',
                'options' => ['RR = 9', 'RR = 5', 'RR = 13', 'RR = 4'],
                'correct' => 1,
            ],
            [
                'q' => 'Según la tabla de rangos de aceptabilidad, ¿a qué nivel corresponde un RR de 5?',
                'options' => ['BAJO', 'MEDIO', 'ALTO', 'No aplica'],
                'correct' => 1,
            ],
            [
                'q' => '¿Cuál es el rango de RR que corresponde al nivel BAJO?',
                'options' => ['1 a 3', '4 a 6', '7 a 9', '0 a 9'],
                'correct' => 0,
            ],
            [
                'q' => 'Si el cálculo de RR resulta en un valor negativo, ¿qué valor se consigna en la matriz?',
                'options' => ['Se deja en blanco', 'Se consigna 0', 'Se consigna el valor negativo', 'Se consigna 1'],
                'correct' => 1,
            ],
            [
                'q' => '¿Qué significa el Enfoque Basado en Riesgos (EBR)?',
                'options' => [
                    'Destinar los mismos recursos de prevención a todas las áreas por igual',
                    'Destinar mayores recursos de prevención a las áreas de mayor riesgo',
                    'Evaluar el riesgo solo una vez al año',
                    'Delegar la gestión de riesgos únicamente a la SBS',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'En el modelo del curso, ¿qué riesgo del producto de préstamos exige verificar el origen de los fondos usados para el repago del crédito?',
                'options' => [
                    'PR-01 — Uso del préstamo para integrar fondos ilícitos',
                    'KYT-04 — Deficiencia de capacitación',
                    'D-01 — Ciberataque a la plataforma',
                    'INS-01 — Fallas de gobernanza',
                ],
                'correct' => 0,
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

        $this->command?->info('Curso "Matriz de Gestión de Riesgos LA/FT" creado con '.count($modulesData).' módulos y '.count($questions).' preguntas.');
    }
}
