<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Course;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class RedDigitalProjectSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::firstOrCreate(
            ['slug' => 'red-digital-del-peru'],
            [
                'name' => 'Red Digital del Perú S.A.C.',
                'ruc' => null,
                'notes' => 'Primer cliente empresarial del módulo de Proyectos.',
            ]
        );

        $category = Category::firstOrCreate(
            ['slug' => 'capacitaciones-empresariales'],
            ['name' => 'Capacitaciones empresariales', 'description' => 'Programas de capacitación a medida para empresas clientes.']
        );

        $director = User::where('email', 'denis@romanicompliance.com')->first();

        // El nombre del curso es genérico a propósito: es contenido reutilizable
        // del catálogo, no debe llevar el nombre de ningún cliente particular.
        $course = Course::firstOrCreate(
            ['slug' => 'splaft-integral'],
            [
                'category_id' => $category->id,
                'created_by' => $director?->id,
                'instructor_id' => $director?->id,
                'title' => 'SPLAFT Integral: Prevención LA/FT para Empresas',
                'description' => 'Programa de capacitación integral sobre el Sistema de Prevención de Lavado de Activos y Financiamiento del Terrorismo (SPLAFT): marco normativo, operativa y documentación ante la UIF, y el rol del Oficial de Cumplimiento.',
                'duration_minutes' => 180,
                'is_published' => false,
                'certificate_type' => 'gratuita',
            ]
        );

        $structure = [
            'Módulo 1 — Fundamentos normativos' => [
                'Ley N.° 27693 y su reglamento',
                'D.L. 1106 y D.L. 1249: régimen penal de lavado de activos',
                'Resoluciones SBS aplicables al sistema de prevención',
                'Obligaciones del sujeto obligado',
                'Tipologías de LA/FT y señales de alerta',
                'Análisis de casos prácticos',
            ],
            'Módulo 2 — Operativa y documentación UIF' => [
                'Documentación exigida por la UIF',
                'Debida diligencia del cliente (DDC/KYC)',
                'Registro de operaciones y Reporte de Operaciones Sospechosas (ROS)',
            ],
            'Módulo 3 — El Oficial de Cumplimiento' => [
                'Designación y funciones del Oficial de Cumplimiento',
                'Manual de Prevención del Sistema SPLAFT',
                'Código de Conducta',
                'Matriz de Riesgos',
                'Capacitación interna y cultura de cumplimiento',
            ],
        ];

        foreach (array_values(array_keys($structure)) as $moduleOrder => $moduleTitle) {
            $module = $course->modules()->firstOrCreate(['title' => $moduleTitle], ['order' => $moduleOrder + 1]);

            foreach (array_values($structure[$moduleTitle]) as $lessonOrder => $lessonTitle) {
                $module->lessons()->firstOrCreate(
                    ['title' => $lessonTitle],
                    [
                        'type' => 'text',
                        'content' => 'Contenido en preparación. Se reemplazará por el material definitivo (video, PDF o diapositiva) desde el panel de administración.',
                        'order' => $lessonOrder + 1,
                    ]
                );
            }
        }

        Project::firstOrCreate(
            ['slug' => 'red-digital-splaft-integral'],
            [
                'company_id' => $company->id,
                'course_id' => $course->id,
                'created_by' => $director?->id,
                'name' => 'Capacitación SPLAFT Integral — Red Digital',
                'description' => 'Capacitación empresarial en prevención de lavado de activos y financiamiento del terrorismo (SPLAFT), diseñada a medida para Red Digital del Perú S.A.C.',
                'service' => 'Capacitación SPLAFT Integral',
                'modality' => 'Presencial',
                'duration_hours' => 3,
                'status' => 'active',
                'commercial_info' => "US$ 250 + IGV.\nIncluye material de trabajo editable, certificado gratuito y verificable mediante QR, y acompañamiento posterior de 10 días.",
            ]
        );

        $this->command?->info('Proyecto Red Digital sembrado correctamente.');
    }
}
