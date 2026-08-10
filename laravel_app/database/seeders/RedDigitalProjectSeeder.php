<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Course;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        $course = Course::firstOrCreate(
            ['slug' => 'capacitacion-splaft-integral-red-digital'],
            [
                'category_id' => $category->id,
                'created_by' => $director?->id,
                'instructor_id' => $director?->id,
                'title' => 'Capacitación SPLAFT Integral — Red Digital',
                'description' => 'Programa de capacitación integral sobre el Sistema de Prevención de Lavado de Activos y Financiamiento del Terrorismo (SPLAFT), preparado para Red Digital del Perú S.A.C. Incluye marco normativo, operativa y documentación UIF, y el rol del Oficial de Cumplimiento.',
                'duration_minutes' => 180,
                'is_published' => false,
                'certificate_type' => 'gratuita',
            ]
        );

        $modules = [
            'Módulo 1 — Fundamentos normativos',
            'Módulo 2 — Operativa y documentación UIF',
            'Módulo 3 — El Oficial de Cumplimiento',
        ];

        foreach ($modules as $order => $title) {
            $course->modules()->firstOrCreate(['title' => $title], ['order' => $order + 1]);
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
