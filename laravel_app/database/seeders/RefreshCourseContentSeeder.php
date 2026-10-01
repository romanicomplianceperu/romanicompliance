<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class RefreshCourseContentSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::where('slug', 'cuestiones-problematicas-lavado-activos')->firstOrFail();
        $modules = $course->modules()->with('lessons')->orderBy('order')->get();
        $first = $modules[0]->lessons->sortBy('order')->values();
        $first[0]->update(['title' => 'Casación N.° 1726-2019/Ayacucho (PDF)', 'type' => 'pdf', 'file_path' => 'lessons/files/casacion-1726-2019-ayacucho.pdf', 'order' => 1]);
        $first[1]->update(['title' => 'Actividad interactiva: prueba por indicios', 'type' => 'text', 'order' => 2]);
        $second = $modules[1]->lessons->sortBy('order')->values();
        $second[0]->update(['title' => 'Cuaderno participante Red Huánuco (Word)', 'type' => 'file', 'file_path' => 'lessons/files/cuaderno-participante-red-huanuco.docx', 'order' => 1]);
        $second[1]->update(['title' => 'Actividad interactiva: análisis de riesgo', 'type' => 'text', 'order' => 2]);

        $exam = $course->exam;
        $exam->questions()->each(fn ($question) => $question->options()->delete());
        $exam->questions()->delete();
        $questions = [
            ['La prueba por indicios es:', ['Una prueba directa', 'Una pauta jurídica de valoración', 'Una presunción legal'], 1],
            ['El silogismo indiciario se integra por:', ['Hecho base, máxima de experiencia y hecho presunto', 'Denuncia, sentencia y sanción', 'Pericia, confesión y condena'], 0],
            ['Los indicios deben valorarse:', ['Aislados', 'Solo por su cantidad', 'En conjunto e interrelación'], 2],
            ['La Corte Suprema ordenó:', ['Condenar directamente', 'Un nuevo juicio oral ante otros jueces', 'Archivar definitivamente'], 1],
            ['El defecto principal fue:', ['Falta de competencia', 'Valoración aislada e irracional de los indicios', 'Ausencia de delito fuente'], 1],
            ['La vinculación familiar con investigados:', ['Basta por sí sola', 'Es irrelevante siempre', 'Debe valorarse junto con otros indicios'], 2],
            ['La contraprueba idónea:', ['Debe ser examinada', 'Nunca se considera', 'Sustituye la acusación'], 0],
            ['El delito de lavado de activos es:', ['Autónomo', 'Solo administrativo', 'Dependiente de una condena previa'], 0],
            ['El IIF de la UIF es:', ['Prueba plena autónoma', 'Insumo de inteligencia que requiere corroboración', 'Una sentencia'], 1],
            ['El ROS es:', ['Una comunicación reservada ante sospecha', 'Un contrato privado', 'Una denuncia de la víctima'], 0],
            ['La blockchain es:', ['Un registro distribuido e inmutable', 'Una cuenta bancaria', 'Un documento físico'], 0],
            ['Un mixer:', ['Facilita la identificación', 'Dificulta la trazabilidad', 'Elimina la transacción'], 1],
            ['“Sin atribuir” significa:', ['Fondos lícitos', 'Identidad no determinada', 'Fondos decomisados'], 1],
            ['La exposición a contrapartes sancionadas:', ['Reduce el riesgo', 'Incrementa el riesgo', 'No puede registrarse'], 1],
            ['La mediana de seis horas entre entrada y salida sugiere:', ['Movimiento rápido de fondos', 'Ahorro personal seguro', 'Ausencia de actividad'], 0],
            ['La atribución de una wallet debe:', ['Darse por segura', 'Corroborarse con información adicional', 'Omitirse siempre'], 1],
            ['La cadena de custodia digital sirve para:', ['Asegurar integridad y autenticidad del reporte', 'Ocultar transacciones', 'Reemplazar al juez'], 0],
            ['El puntaje de riesgo:', ['Acredita por sí solo responsabilidad penal', 'Orienta el análisis y requiere corroboración', 'Sustituye toda prueba'], 1],
            ['Un PSAV puede aportar:', ['Información de identificación y transacciones', 'Sentencias judiciales', 'Prueba automática de culpabilidad'], 0],
            ['La mejor conclusión sobre W-001 es:', ['Es culpable sin más datos', 'Presenta señales que justifican investigación y corroboración', 'Está limpia por usar un exchange'], 1],
        ];
        foreach ($questions as $order => [$text, $options, $correct]) {
            $question = $exam->questions()->create(['question_text' => $text, 'order' => $order + 1, 'points' => 1]);
            foreach ($options as $optionOrder => $option) {
                $question->options()->create(['option_text' => $option, 'is_correct' => $optionOrder === $correct, 'order' => $optionOrder]);
            }
        }
        $exam->update(['time_limit_minutes' => 20]);
    }
}
