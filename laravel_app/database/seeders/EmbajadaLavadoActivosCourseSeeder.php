<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmbajadaLavadoActivosCourseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $instructor = User::where('email', 'denis@romanicompliance.com')->first();
        $category = Category::firstOrCreate(['slug' => 'prevencion-laft'], [
            'name' => 'Prevención LA/FT',
            'description' => 'Capacitaciones sobre prevención de lavado de activos.',
        ]);
        $course = Course::updateOrCreate(['slug' => 'cuestiones-problematicas-lavado-activos'], [
            'category_id' => $category->id,
            'created_by' => $admin?->id,
            'title' => 'Cuestiones Problemáticas del Delito de Lavado de Activos',
            'description' => 'Curso práctico en dos actividades: análisis de la Casación N.° 1726-2019/Ayacucho y análisis de riesgo de una billetera con criptoactivos.',
            'cover_image' => 'courses/covers/lavado-activos-embajada.svg',
            'instructor_name' => 'Denis Gabriel Romani Seminario',
            'instructor_id' => $instructor?->id,
            'duration_minutes' => 95,
            'is_published' => true,
            'certificate_type' => 'gratuita',
        ]);

        $course->modules->each(fn ($module) => $module->lessons()->delete());
        $course->modules()->delete();
        $course->exam()->delete();

        $modules = [
            ['title' => 'Actividad 1: Ficha Casación N.° 1726-2019/Ayacucho', 'lessons' => [
                ['title' => 'Ficha de análisis jurisprudencial', 'type' => 'text', 'duration_minutes' => 15, 'content' => "Caso Quispe Marmolejo y Velarde Laura. La Corte Suprema precisó que la prueba por indicios es una pauta jurídica de valoración, no un medio de prueba autónomo. El razonamiento se construye con: (1) hecho base o indicio; (2) máxima de experiencia o criterio lógico; y (3) hecho presunto. Los indicios deben valorarse en conjunto e interrelación, y debe examinarse la contraprueba idónea.\n\nLa Corte declaró fundado el motivo referido a la garantía de motivación porque las instancias de mérito analizaron los indicios de manera aislada y descartaron las pericias contables sin un examen crítico suficiente. Casó la sentencia de vista, anuló la de primera instancia y ordenó un nuevo juicio oral ante otros jueces."],
                ['title' => 'Casación N.° 1726-2019/Ayacucho (PDF)', 'type' => 'pdf', 'duration_minutes' => 25, 'file_path' => 'lessons/files/casacion-1726-2019-ayacucho.pdf'],
            ]],
            ['title' => 'Actividad 2: Análisis de riesgo de una billetera con criptoactivos', 'lessons' => [
                ['title' => 'Caso ficticio «Red Huánuco»', 'type' => 'text', 'duration_minutes' => 45, 'content' => "Entre enero y junio de 2026, comerciantes de un mercado de Huánuco denunciaron cobros periódicos bajo amenaza, con pagos en USDT y BTC. Los fondos se concentraron en la billetera W-001 (0xF1C7…9A2E).\n\nW-001 registró entradas por USD 655,000 y salidas por USD 585,000, con 318 transacciones y 47 contrapartes. La exposición incluyó: exchange regulado (34 %), mixer (17 %), apuestas (12 %), P2P/OTC sin KYC (10 %), fondos vinculados a extorsión (8 %), puente entre cadenas (6 %) y contrapartes sancionadas (3 %). La mediana entre entrada y salida fue de seis horas; hubo 42 depósitos entre USD 900 y USD 990.\n\nResuelvan: clasificar cada exposición como baja, media, alta o severa; proponer un puntaje de 0 a 100; distinguir hechos acreditados de inferencias; formular dos silogismos indiciarios; señalar qué información pedirían a los PSAV y qué medidas sobre los activos evaluarían. El puntaje mide exposición, no acredita por sí solo la responsabilidad del titular."],
                ['title' => 'Hoja de trabajo y clasificación de riesgos', 'type' => 'text', 'duration_minutes' => 15, 'content' => "Ordenen el análisis en esta secuencia: 1. verificar entradas, salidas y saldo; 2. identificar contrapartes y categorías; 3. separar exposición directa e indirecta; 4. valorar el patrón temporal; 5. comprobar atribución y contraprueba; 6. proponer la ruta de investigación y la cadena de custodia digital.\n\nVerdadero o falso: (a) que una billetera pase por un exchange regulado demuestra que sus fondos son lícitos; (b) una exposición a mixer y fondos vinculados a extorsión aumenta el riesgo; (c) “sin atribuir” equivale a fondos limpios; (d) un reporte de una herramienta blockchain sustituye la prueba pericial y el cauce legal. Justifiquen cada respuesta."],
            ]],
        ];
        foreach ($modules as $moduleOrder => $moduleData) {
            $module = $course->modules()->create(['title' => $moduleData['title'], 'order' => $moduleOrder + 1]);
            foreach ($moduleData['lessons'] as $lessonOrder => $lesson) {
                $module->lessons()->create($lesson + ['order' => $lessonOrder + 1]);
            }
        }

        $exam = $course->exam()->create([
            'title' => 'Evaluación final del curso',
            'passing_score' => 70,
            'max_attempts' => 2,
            'time_limit_minutes' => 20,
        ]);
        $questions = [
            ['q' => 'La prueba por indicios es:', 'o' => ['Una prueba directa', 'Una pauta jurídica de valoración', 'Una presunción legal'], 'c' => 1],
            ['q' => 'Los indicios deben valorarse:', 'o' => ['Aislados', 'Solo por su cantidad', 'En conjunto e interrelación'], 'c' => 2],
            ['q' => 'La decisión de la Casación fue:', 'o' => ['Ordenar nuevo juicio oral por falta de motivación suficiente', 'Condenar directamente', 'Confirmar sin cambios la absolución'], 'c' => 0],
            ['q' => 'Un mixer normalmente:', 'o' => ['Facilita el rastreo', 'Dificulta la trazabilidad', 'Identifica siempre al titular'], 'c' => 1],
            ['q' => '“Sin atribuir” significa:', 'o' => ['Fondos limpios', 'Fondos cuya identificación no fue determinada', 'Fondos sancionados'], 'c' => 1],
            ['q' => 'Un puntaje alto de riesgo:', 'o' => ['Acredita por sí solo el delito', 'Es un insumo que requiere corroboración', 'Sustituye la prueba legal'], 'c' => 1],
        ];
        foreach ($questions as $order => $questionData) {
            $question = $exam->questions()->create(['question_text' => $questionData['q'], 'order' => $order + 1, 'points' => 1]);
            foreach ($questionData['o'] as $optionOrder => $option) {
                $question->options()->create(['option_text' => $option, 'is_correct' => $optionOrder === $questionData['c'], 'order' => $optionOrder]);
            }
        }
        $this->command?->info('Curso simplificado a dos actividades y evaluación de 20 minutos.');
    }
}
