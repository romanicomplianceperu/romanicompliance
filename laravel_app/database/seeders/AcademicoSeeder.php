<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Illuminate\Database\Seeder;

class AcademicoSeeder extends Seeder
{
    public function run(): void
    {
        $unp = AcademicUniversity::updateOrCreate(
            ['slug' => 'unp'],
            [
                'name' => 'Universidad Nacional de Piura',
                'short_name' => 'UNP',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/25/Escudo_Universidad_Nacional_de_Piura.png',
                'status' => 'active',
                'order' => 1,
            ]
        );

        $utp = AcademicUniversity::updateOrCreate(
            ['slug' => 'utp'],
            [
                'name' => 'Universidad Tecnológica del Perú',
                'short_name' => 'UTP',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/5/50/Utplogonuevo.svg',
                'status' => 'soon',
                'order' => 2,
            ]
        );

        $uprit = AcademicUniversity::updateOrCreate(
            ['slug' => 'uprit'],
            [
                'name' => 'Universidad Privada de Trujillo',
                'short_name' => 'UPRIT',
                'logo_url' => 'https://uprit.edu.pe/logo_uprit_light.svg',
                'status' => 'soon',
                'order' => 3,
            ]
        );

        $mercantil = AcademicCourse::updateOrCreate(
            ['university_id' => $unp->id, 'slug' => 'derecho-mercantil-ii'],
            [
                'name' => 'Derecho Mercantil II',
                'subtitle' => 'Sociedades',
                'faculty' => 'Facultad de Derecho y Ciencias Políticas',
                'period' => '2026-II',
                'total_weeks' => 16,
                'status' => 'active',
            ]
        );

        AcademicActivity::updateOrCreate(
            ['academic_course_id' => $mercantil->id, 'slug' => 'caso-semana-1'],
            [
                'week_number' => 1,
                'type' => 'participacion',
                'title' => 'Caso Semana 1',
                'case_title' => 'La panadería de los hermanos Saavedra',
                'unit' => 'Unidad I — Introducción y Constitución de Sociedades',
                'modality' => 'Trabajo grupal',
                'group_size' => '5 a 6 estudiantes',
                'case_body' => null,
                'case_document_path' => null,
                'status' => 'proximamente',
            ]
        );

        $this->command?->info('Académico: universidades, curso y actividad Semana 1 sembrados (caso pendiente del PDF).');
    }
}
