<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use App\Models\AcademicActivityExercise;
use App\Models\AcademicActivityQuestion;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AcademicoSemana2Seeder extends Seeder
{
    public function run(): void
    {
        $unp = AcademicUniversity::where('slug', 'unp')->first();

        if (! $unp) {
            $this->command?->error('No se encontró la universidad UNP. Corre primero AcademicoSeeder.');

            return;
        }

        $mercantil = AcademicCourse::updateOrCreate(
            ['university_id' => $unp->id, 'slug' => 'derecho-mercantil-ii'],
            ['code_abbr' => 'MER']
        );

        $caseBody = <<<'TXT'
Distribuidora Norte S.A.C., dedicada a la venta de abarrotes, adeuda a un proveedor S/ 180 000 por mercadería entregada. Cuando el proveedor inicia el cobro, descubre que la S.A.C. ya no tiene bienes ni saldo en sus cuentas: pocos meses antes, sus dos únicos socios —los esposos M.— transfirieron la mercadería, los vehículos y la cartera de clientes a una nueva empresa, Comercial Norte E.I.R.L., cuya titular es la esposa. Ambas operan en el mismo local y con el mismo personal.

Los esposos M. sostienen que Distribuidora Norte S.A.C. es una persona jurídica distinta, con responsabilidad limitada, y que si no tiene bienes, «nada se puede hacer». El proveedor alega que la maniobra fue un vaciamiento fraudulento para no pagar.

El escenario reproduce el patrón de casos peruanos reales donde una E.I.R.L. se usó para burlar obligaciones, y la Cas. Lab. 3733-2009, que fijó criterios para reconocer un grupo de empresas (misma persona, vínculos familiares, mismo local).

BASE NORMATIVA DE REFERENCIA
Ley N.° 26887 (LGS), arts. 6 y 11 — personalidad jurídica y objeto social.
Código Civil, art. 78 — autonomía patrimonial de la persona jurídica.
Código Civil, art. II del Título Preliminar — abuso del derecho.
Exp. 7172-2006-BE(A) y Cas. Lab. 3733-2009-Lima — levantamiento del velo y grupo de empresas.

PRODUCTO A ENTREGAR
Un informe grupal breve (máximo una página) que: (i) explique la autonomía patrimonial y su límite; (ii) identifique el/los supuesto(s) de levantamiento del velo que concurren; y (iii) formule la pretensión que plantearían al juez. Exposición grupal de 3 a 4 minutos; tiempo estimado de trabajo en aula: 30 a 40 minutos.
TXT;

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $mercantil->id, 'slug' => 'caso-semana-2'],
            [
                'week_number' => 2,
                'type' => 'participacion',
                'title' => 'Caso Semana 2',
                'case_title' => '«La empresa que se vació»',
                'unit' => 'Unidad I — Introducción y Constitución de Sociedades',
                'modality' => 'Trabajo grupal (5 a 6 integrantes)',
                'group_size' => '5 a 6 estudiantes',
                'case_body' => $caseBody,
                'status' => 'disponible',
                'access_code' => 'mercantil0809',
                'due_at' => Carbon::parse('2026-09-08 23:59:00', 'America/Lima')->utc(),
            ]
        );

        $activity->questions()->delete();

        $questions = [
            'Explique por qué, en principio, el proveedor no podría cobrar del patrimonio personal de los esposos M. ¿Qué institución jurídica se los impide?',
            '¿Cuál o cuáles de los cuatro supuestos clásicos del levantamiento del velo concurren en el caso? Fundamenten con los hechos.',
            'Aplicando los criterios de la Cas. Lab. 3733-2009 (misma persona, vínculos familiares, mismo local), ¿puede sostenerse que ambas empresas son un «grupo» o pantalla? ¿Por qué?',
            'Si ustedes fueran los abogados del proveedor, ¿qué pedirían al juez y con qué fundamento? Y si defendieran a los esposos M., ¿qué argumentos usarían?',
        ];

        foreach ($questions as $order => $prompt) {
            AcademicActivityQuestion::create([
                'academic_activity_id' => $activity->id,
                'order' => $order + 1,
                'prompt' => $prompt,
            ]);
        }

        $activity->exercises()->delete();

        $exercises = [
            [
                'type' => 'vf',
                'prompt' => 'Lee la afirmación y marca si es verdadera o falsa.',
                'payload' => [
                    'statement' => 'Según la posición de los esposos M., Distribuidora Norte S.A.C. y Comercial Norte E.I.R.L. son la misma persona jurídica.',
                    'answer' => false,
                ],
                'points' => 1,
            ],
            [
                'type' => 'vf',
                'prompt' => 'Lee la afirmación y marca si es verdadera o falsa.',
                'payload' => [
                    'statement' => 'El artículo 78 del Código Civil reconoce la autonomía patrimonial de la persona jurídica frente a sus miembros.',
                    'answer' => true,
                ],
                'points' => 1,
            ],
            [
                'type' => 'vf',
                'prompt' => 'Lee la afirmación y marca si es verdadera o falsa.',
                'payload' => [
                    'statement' => 'En el caso, ambas empresas operan en locales distintos y con personal diferente.',
                    'answer' => false,
                ],
                'points' => 1,
            ],
            [
                'type' => 'vf',
                'prompt' => 'Lee la afirmación y marca si es verdadera o falsa.',
                'payload' => [
                    'statement' => 'La titular de Comercial Norte E.I.R.L. es la esposa de uno de los socios de la S.A.C.',
                    'answer' => true,
                ],
                'points' => 1,
            ],
            [
                'type' => 'mcq',
                'prompt' => '¿Qué norma reconoce expresamente la autonomía patrimonial de la persona jurídica?',
                'payload' => [
                    'options' => [
                        'Código Civil, art. 78',
                        'Ley N.° 26887 (LGS), art. 11',
                        'Cas. Lab. 3733-2009-Lima',
                        'Código Civil, art. II del Título Preliminar',
                    ],
                    'correct' => 0,
                ],
                'points' => 1,
            ],
            [
                'type' => 'mcq',
                'prompt' => '¿Cuál de las siguientes NO figura entre los criterios que la Cas. Lab. 3733-2009 usa para reconocer un grupo de empresas?',
                'payload' => [
                    'options' => [
                        'Misma persona controladora',
                        'Vínculos familiares entre los titulares',
                        'Mismo local y mismo personal',
                        'Mismo rubro de negocio en una ciudad distinta',
                    ],
                    'correct' => 3,
                ],
                'points' => 1,
            ],
            [
                'type' => 'mcq',
                'prompt' => 'Según la posición del proveedor, ¿qué buscaron los esposos M. al transferir mercadería, vehículos y cartera de clientes a la E.I.R.L.?',
                'payload' => [
                    'options' => [
                        'Diversificar el negocio familiar',
                        'Vaciar patrimonialmente a la S.A.C. para no pagarle',
                        'Cumplir con una orden judicial de reestructuración',
                        'Fusionar ambas empresas en una sola',
                    ],
                    'correct' => 1,
                ],
                'points' => 1,
            ],
            [
                'type' => 'matching',
                'prompt' => 'Empareja cada hecho del caso con el criterio de la Cas. Lab. 3733-2009 que sustenta.',
                'payload' => [
                    'left' => [
                        ['id' => 'h1', 'text' => 'Los esposos M. son los dos únicos socios de la S.A.C. y controlan también la E.I.R.L.'],
                        ['id' => 'h2', 'text' => 'La titular de la E.I.R.L. es la esposa de uno de los socios.'],
                        ['id' => 'h3', 'text' => 'Ambas empresas operan en el mismo local y con el mismo personal.'],
                    ],
                    'right' => [
                        ['id' => 'c1', 'text' => 'Misma persona controladora'],
                        ['id' => 'c2', 'text' => 'Vínculos familiares'],
                        ['id' => 'c3', 'text' => 'Mismo local / mismo personal'],
                    ],
                    'pairs' => ['h1' => 'c1', 'h2' => 'c2', 'h3' => 'c3'],
                ],
                'points' => 2,
            ],
            [
                'type' => 'matching',
                'prompt' => 'Empareja cada norma con lo que regula en este caso.',
                'payload' => [
                    'left' => [
                        ['id' => 'n1', 'text' => 'Ley N.° 26887 (LGS), arts. 6 y 11'],
                        ['id' => 'n2', 'text' => 'Código Civil, art. 78'],
                        ['id' => 'n3', 'text' => 'Código Civil, art. II del Título Preliminar'],
                        ['id' => 'n4', 'text' => 'Cas. Lab. 3733-2009-Lima'],
                    ],
                    'right' => [
                        ['id' => 'r1', 'text' => 'Personalidad jurídica y objeto social'],
                        ['id' => 'r2', 'text' => 'Autonomía patrimonial de la persona jurídica'],
                        ['id' => 'r3', 'text' => 'Abuso del derecho'],
                        ['id' => 'r4', 'text' => 'Levantamiento del velo y grupo de empresas'],
                    ],
                    'pairs' => ['n1' => 'r1', 'n2' => 'r2', 'n3' => 'r3', 'n4' => 'r4'],
                ],
                'points' => 2,
            ],
            [
                'type' => 'ordering',
                'prompt' => 'Ordena cronológicamente los hechos del caso, del primero al último.',
                'payload' => [
                    'items' => [
                        ['id' => 'a', 'text' => 'Distribuidora Norte S.A.C. contrae una deuda de S/ 180 000 con un proveedor.'],
                        ['id' => 'b', 'text' => 'Los esposos M. transfieren mercadería, vehículos y cartera de clientes a Comercial Norte E.I.R.L.'],
                        ['id' => 'c', 'text' => 'El proveedor inicia el cobro de la deuda.'],
                        ['id' => 'd', 'text' => 'El proveedor descubre que la S.A.C. ya no tiene bienes ni saldo en sus cuentas.'],
                    ],
                    'correctOrder' => ['a', 'b', 'c', 'd'],
                ],
                'points' => 2,
            ],
        ];

        foreach ($exercises as $order => $exercise) {
            AcademicActivityExercise::create([
                'academic_activity_id' => $activity->id,
                'order' => $order + 1,
                'type' => $exercise['type'],
                'prompt' => $exercise['prompt'],
                'payload' => $exercise['payload'],
                'points' => $exercise['points'],
            ]);
        }

        $this->command?->info('Académico: Caso Semana 2 (Mercantil II - UNP) sembrado con código de acceso, fecha límite y '.count($exercises).' ejercicios autocalificables.');
    }
}
