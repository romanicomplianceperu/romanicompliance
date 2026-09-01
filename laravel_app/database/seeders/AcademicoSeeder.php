<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use App\Models\AcademicActivityQuestion;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AcademicoSeeder extends Seeder
{
    public function run(): void
    {
        $unpLogo = $this->storeAsset('unp-logo.png.b64', 'universities/unp.png');
        $utpLogo = $this->storeAsset('utp-logo.jpg.b64', 'universities/utp.jpg');
        $upritLogo = $this->storeAsset('uprit-logo.png.b64', 'universities/uprit.png');
        $casePdf = $this->storeAsset('caso-semana-1.pdf.b64', 'academico/caso-semana-1-derecho-mercantil-ii.pdf');

        $unp = AcademicUniversity::updateOrCreate(
            ['slug' => 'unp'],
            [
                'name' => 'Universidad Nacional de Piura',
                'short_name' => 'UNP',
                'logo_url' => $unpLogo ?? 'https://upload.wikimedia.org/wikipedia/commons/2/25/Escudo_Universidad_Nacional_de_Piura.png',
                'status' => 'active',
                'order' => 1,
            ]
        );

        $utp = AcademicUniversity::updateOrCreate(
            ['slug' => 'utp'],
            [
                'name' => 'Universidad Tecnológica del Perú',
                'short_name' => 'UTP',
                'logo_url' => $utpLogo ?? 'https://upload.wikimedia.org/wikipedia/commons/5/50/Utplogonuevo.svg',
                'status' => 'active',
                'order' => 2,
            ]
        );

        $uprit = AcademicUniversity::updateOrCreate(
            ['slug' => 'uprit'],
            [
                'name' => 'Universidad Privada de Trujillo',
                'short_name' => 'UPRIT',
                'logo_url' => $upritLogo ?? 'https://uprit.edu.pe/logo_uprit_light.svg',
                'status' => 'active',
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

        $caseBody = <<<'TXT'
Rosa y Miguel Saavedra administran, desde hace cuatro años, una panadería en Piura que funciona informalmente a nombre de Rosa como persona natural con negocio. El local ha crecido: contrataron tres trabajadores, compran insumos al crédito y un supermercado local les ha propuesto ser su proveedor fijo, pero les exige factura y respaldo formal. Además, quieren solicitar un préstamo para adquirir un horno industrial.

Miguel teme que, si el negocio contrae deudas y fracasa, respondan con su casa y sus bienes personales. Rosa ha escuchado hablar de la «E.I.R.L.», de la «S.A.C.» y de una nueva forma llamada «S.A.C.S.», pero no saben cuál les conviene ni qué implica cada una.

Los hermanos acuden a un estudio jurídico —el aula— en busca de orientación sobre si conviene formalizar el negocio como sociedad y bajo qué forma hacerlo.

BASE NORMATIVA DE REFERENCIA:

• Constitución Política del Perú, arts. 58, 59 y 60 — economía social de mercado, libertad de empresa y pluralismo económico.
• Ley N.° 26887, Ley General de Sociedades — formas societarias y personalidad jurídica.
• Régimen de la Empresa Individual de Responsabilidad Limitada (E.I.R.L.).
TXT;

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $mercantil->id, 'slug' => 'caso-semana-1'],
            [
                'week_number' => 1,
                'type' => 'participacion',
                'title' => 'Caso Semana 1',
                'case_title' => 'La panadería de los hermanos Saavedra',
                'unit' => 'Unidad I — Introducción y Constitución de Sociedades',
                'modality' => 'Trabajo grupal (5 a 6 integrantes)',
                'group_size' => '5 a 6 estudiantes',
                'case_body' => $caseBody,
                'case_document_path' => $casePdf,
                'status' => 'disponible',
            ]
        );

        $activity->questions()->delete();

        $questions = [
            '¿Qué gana jurídicamente el negocio al adquirir personalidad jurídica propia frente a seguir operando como persona natural con negocio?',
            'El temor de Miguel apunta a la responsabilidad. ¿Qué formas societarias o empresariales limitan la responsabilidad del socio a lo aportado y cuáles no? Expliquen la diferencia.',
            '¿Qué principios constitucionales del régimen económico respaldan la libertad de los hermanos para elegir la forma jurídica de su empresa?',
            'Considerando que son dos personas y buscan simplicidad y responsabilidad limitada, ¿qué forma recomendarían y por qué? ¿Cambiaría su respuesta si el negocio fuera de una sola persona?',
        ];

        foreach ($questions as $order => $prompt) {
            AcademicActivityQuestion::create([
                'academic_activity_id' => $activity->id,
                'order' => $order + 1,
                'prompt' => $prompt,
            ]);
        }

        $this->command?->info('Académico: universidades (con logos), curso y Caso Semana 1 (con documento real y '.count($questions).' preguntas) sembrados.');
    }

    private function storeAsset(string $b64Filename, string $storagePath): ?string
    {
        $file = __DIR__.'/data/'.$b64Filename;
        if (! file_exists($file)) {
            return null;
        }

        Storage::disk('public')->put($storagePath, base64_decode(file_get_contents($file)));

        return asset('storage/'.$storagePath);
    }
}
