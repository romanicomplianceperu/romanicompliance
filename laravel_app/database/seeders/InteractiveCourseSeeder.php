<?php

namespace Database\Seeders;

use App\Models\AcademicActivityExercise;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Illuminate\Database\Seeder;

class InteractiveCourseSeeder extends Seeder
{
    public function run(): void
    {
        $university = AcademicUniversity::firstOrFail();
        $course = AcademicCourse::updateOrCreate(['slug' => 'cuestiones-problematicas-lavado-activos'], [
            'university_id' => $university->id,
            'code_abbr' => 'LA',
            'name' => 'Cuestiones Problemáticas del Delito de Lavado de Activos',
            'subtitle' => 'Dos actividades prácticas interactivas',
            'faculty' => 'Derecho',
            'period' => '2026',
            'total_weeks' => 2,
            'status' => 'active',
        ]);
        $course->activities()->delete();
        $activities = [
            ['slug' => 'ficha-casacion-1726-2019', 'week_number' => 1, 'title' => 'Actividad 1 · Ficha Casación N.° 1726-2019/Ayacucho', 'case_title' => 'Prueba por indicios y garantía de motivación', 'unit' => 'Actividad práctica', 'modality' => 'Individual o grupal', 'group_size' => '2 a 6', 'case_body' => 'Lee la Casación N.° 1726-2019/Ayacucho en el PDF incrustado y resuelve los ejercicios. La prueba por indicios se valora mediante hecho base, máxima de experiencia y hecho presunto. Los indicios deben apreciarse en conjunto e interrelación.', 'case_document_path' => 'lessons/files/casacion-1726-2019-ayacucho.pdf', 'access_code' => null],
            ['slug' => 'analisis-riesgo-billetera-criptoactivos', 'week_number' => 2, 'title' => 'Actividad 2 · Análisis de riesgo de una billetera con criptoactivos', 'case_title' => 'Caso ficticio «Red Huánuco»', 'unit' => 'Actividad práctica', 'modality' => 'Individual o grupal', 'group_size' => '2 a 6', 'case_body' => 'W-001 recibió USD 655,000 y envió USD 585,000. Presenta exposición a mixer, apuestas, P2P sin KYC, fondos vinculados a extorsión, puente entre cadenas y contrapartes sancionadas. Clasifica el riesgo y formula una ruta de investigación.', 'case_document_path' => null, 'access_code' => null],
        ];
        foreach ($activities as $data) {
            $activity = $course->activities()->create($data + ['type' => 'participacion', 'status' => 'disponible', 'pass_percent' => 70]);
            $exercises = $activity->slug === 'ficha-casacion-1726-2019' ? [
                ['type' => 'vf', 'prompt' => 'La prueba por indicios es una pauta jurídica de valoración y no un medio de prueba autónomo.', 'payload' => ['statement' => 'La prueba por indicios es una pauta jurídica de valoración y no un medio de prueba autónomo.', 'answer' => true]],
                ['type' => 'vf', 'prompt' => 'Los indicios deben descartarse uno por uno sin relacionarlos entre sí.', 'payload' => ['statement' => 'Los indicios deben descartarse uno por uno sin relacionarlos entre sí.', 'answer' => false]],
                ['type' => 'ordering', 'prompt' => 'Ordena el silogismo indiciario.', 'payload' => ['items' => [['id' => 'a', 'text' => 'Hecho base o indicio'], ['id' => 'b', 'text' => 'Máxima de experiencia'], ['id' => 'c', 'text' => 'Hecho presunto']], 'correctOrder' => ['a', 'b', 'c']]],
            ] : [
                ['type' => 'vf', 'prompt' => 'La exposición a mixer y fondos vinculados a extorsión incrementa el riesgo de la billetera.', 'payload' => ['statement' => 'La exposición a mixer y fondos vinculados a extorsión incrementa el riesgo de la billetera.', 'answer' => true]],
                ['type' => 'vf', 'prompt' => 'La categoría “sin atribuir” debe considerarse automáticamente limpia.', 'payload' => ['statement' => 'La categoría “sin atribuir” debe considerarse automáticamente limpia.', 'answer' => false]],
                ['type' => 'ordering', 'prompt' => 'Ordena la ruta inicial de análisis.', 'payload' => ['items' => [['id' => 'a', 'text' => 'Verificar entradas y salidas'], ['id' => 'b', 'text' => 'Clasificar contrapartes'], ['id' => 'c', 'text' => 'Valorar el patrón temporal'], ['id' => 'd', 'text' => 'Proponer la ruta de investigación']], 'correctOrder' => ['a', 'b', 'c', 'd']]],
            ];
            foreach ($exercises as $order => $exercise) {
                AcademicActivityExercise::create($exercise + ['academic_activity_id' => $activity->id, 'order' => $order + 1, 'points' => 1]);
            }
        }
    }
}
