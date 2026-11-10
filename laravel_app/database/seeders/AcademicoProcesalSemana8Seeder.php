<?php

namespace Database\Seeders;

use App\Models\AcademicActivity;
use App\Models\AcademicActivityQuestion;
use App\Models\AcademicCourse;
use App\Models\AcademicUniversity;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Derecho Procesal Administrativo (UNP) — Semana 8: trabajo grupal de investigación.
 * Basado en la presentación «DPA_Semana8_Casos» (repertorio de resoluciones reales por
 * tipo de vicio). Cada grupo busca SUS propias resoluciones, pega el enlace de cada una,
 * explica de qué trata y por qué se declaró (o no) el vicio, y sube la presentación con la
 * que expondrá en clase. No hay ejercicios autocalificables: lo califica el docente.
 *
 * Se publica sola en la primera visita al sitio (App\Support\BundledSeeders). Fecha,
 * código y estado se cambian luego desde /soyflojo.
 */
class AcademicoProcesalSemana8Seeder extends Seeder
{
    public const SLUG = 'semana-8-resoluciones-reales-por-tipo-de-vicio';

    public function run(): void
    {
        $unp = AcademicUniversity::where('slug', 'unp')->first();
        if (! $unp) {
            return;
        }

        $course = AcademicCourse::firstOrCreate(
            ['university_id' => $unp->id, 'slug' => 'derecho-procesal-administrativo'],
            [
                'code_abbr' => 'PRO',
                'name' => 'Derecho Procesal Administrativo',
                'subtitle' => 'Función Administrativa y Debido Procedimiento',
                'faculty' => 'Facultad de Derecho y Ciencias Políticas',
                'period' => '2026-II',
                'total_weeks' => 16,
                'status' => 'active',
            ]
        );

        $activity = AcademicActivity::updateOrCreate(
            ['academic_course_id' => $course->id, 'slug' => self::SLUG],
            [
                'week_number' => 8,
                'type' => 'participacion',
                'title' => 'SEMANA 8 - TRABAJO GRUPAL',
                'case_title' => 'Nulidad, conservación y subsanación del acto: busquen sus propias resoluciones',
                'unit' => 'Unidad II — La invalidez del acto y sus vías de ataque',
                'modality' => 'Trabajo grupal',
                'group_size' => 'Exposición de 8 minutos',
                'case_body' => $this->caseBody(),
                'status' => 'disponible',
                'is_hidden' => false,
                'access_code' => 'procesal20262',
                // Viernes 20 de noviembre de 2026, 8:00 p. m. (Lima). Se cambia desde /soyflojo.
                'due_at' => Carbon::parse('2026-11-20 20:00:00', 'America/Lima')->utc(),
                'pass_percent' => 55,
                'upload_prompt' => $this->uploadPrompt(),
                'upload_required' => true,
                'upload_bonus_points' => null,
            ]
        );

        $questions = [
            'Tipo 1 · Prescindir del procedimiento legal — nulidad (art. 10.2 del TUO de la Ley 27444). Peguen el enlace de la resolución que encontraron e indiquen: entidad y número, hechos, vicio y causal, y por qué correspondía anular.',
            'Tipo 2 · No dar plazo para subsanar — nulidad por afectar el debido procedimiento. Peguen el enlace de la resolución que encontraron e indiquen: entidad y número, hechos, vicio y causal, y por qué correspondía anular.',
            'Tipo 3 · Causal del art. 10 o nulidad de oficio — nulidad (arts. 10 y 213). Peguen el enlace de la resolución que encontraron e indiquen: entidad y número, hechos, vicio y causal, quién declaró la nulidad y por qué. También vale un caso donde se explique por qué NO procedía la nulidad.',
            'Tipo 4 · Error material o aritmético — conservación (art. 212). Peguen el enlace de la resolución que encontraron e indiquen: entidad y número, hechos, qué error se rectificó y por qué el acto se conservó en lugar de anularse.',
            'Tipo 5 · Defecto de forma menor — conservación (art. 14). Peguen el enlace de una resolución REAL en la que la entidad enmendó o completó el acto en vez de anularlo, e indiquen: entidad y número, hechos, vicio y por qué se conservó.',
        ];
        foreach ($questions as $order => $prompt) {
            AcademicActivityQuestion::updateOrCreate(
                ['academic_activity_id' => $activity->id, 'order' => $order + 1],
                ['prompt' => $prompt]
            );
        }
        AcademicActivityQuestion::where('academic_activity_id', $activity->id)->where('order', '>', count($questions))->delete();

        $this->command?->info('Académico: Derecho Procesal Administrativo (UNP) — Semana 8 (trabajo grupal) publicada.');
    }

    private function caseBody(): string
    {
        return <<<'TXT'
Esta semana el trabajo es de investigación. En clase vieron resoluciones reales de entidades públicas (Tribunal Fiscal, SUNARP y Poder Judicial), agrupadas por tipo de vicio, con el enlace directo a cada una. Son el modelo: a partir de ellas, cada grupo buscará SUS propias resoluciones, de cualquier entidad del país, para cada tipo de vicio o error, y las expondrá en clase.

QUÉ DEBEN HACER
1) Tomen como modelo las resoluciones de abajo (una por tipo de vicio).
2) Busquen OTRAS resoluciones en cualquier entidad pública del país (SUNARP, SUNAT/Tribunal Fiscal, OSCE, INDECOPI, Servir, municipalidades, o el Poder Judicial/TC), una por cada tipo de vicio o error.
3) De cada una indiquen: entidad y número, hechos, vicio y causal, y si correspondía anular o conservar.
4) Peguen el enlace de acceso a cada resolución en los cuadros de texto de abajo y suban la presentación con la que expondrán en clase (8 minutos).

LOS CINCO TIPOS DE VICIO A CUBRIR
Prescindir del procedimiento: nulidad (art. 10.2).
No dar plazo para subsanar: nulidad (debido procedimiento).
Causal del art. 10 o nulidad de oficio: nulidad (arts. 10 y 213).
Error material o aritmético: conservación (art. 212).
Defecto de forma menor: conservación (art. 14).

MODELO 1: NULIDAD POR VICIO DEL PROCEDIMIENTO
RTF 10072-10-2017 (Tribunal Fiscal): SUNAT emitió resoluciones de determinación y multa en una fiscalización cuyos resultados remitían a un documento interno no notificado al contribuyente; con criterio de observancia obligatoria, el Tribunal declaró NULOS esos actos por prescindir del procedimiento legal. https://www.mef.gob.pe/contenidos/tribu_fisc/jurisprude/acuer_sala/2017/resolucion/2017_10_10072.pdf
RTF 00358-1-2023 (Tribunal Fiscal): al resolver la reclamación, la Intendencia agregó un fundamento nuevo a un reparo, excediendo el art. 127 del Código Tributario; el Tribunal declaró la nulidad parcial por prescindencia del procedimiento (art. 109.2 CT). https://www.mef.gob.pe/contenidos/tribu_fisc/jurisprude/acuer_sala/2022/resolucion/2023_1_00358.pdf
Res. 3513-2023-SUNARP-TR (Tribunal Registral): el administrado pidió informe oral y no fue citado antes de resolver; el propio Tribunal declaró de OFICIO la nulidad de su resolución anterior por vicio del procedimiento y ordenó fijar nueva fecha. https://img.lpderecho.pe/wp-content/uploads/2023/08/Resolucion-3513-2023-Sunarp-TR-LPDerecho.pdf

MODELO 2: DEBIDO PROCEDIMIENTO Y NULIDAD BAJO EL ART. 10
Casación 546-2022 Lima (Corte Suprema, precedente vinculante): la administración no otorgó plazo para subsanar una carta fianza ni evaluó pruebas presentadas; la Corte concluyó que la resolución adolece de nulidad y fijó precedentes sobre la subsanación de requisitos. https://img.lpderecho.pe/wp-content/uploads/2023/09/Resolucion-205-2023-Sunarp-PT-LPDerecho.pdf
Res. 2887-2022-SUNARP-TR (Tribunal Registral): se pidió la nulidad de una resolución del Tribunal invocando el art. 10; el Tribunal precisó que no cabe pedirla a pedido de parte contra sus propias resoluciones y que no había vicios del art. 10. Enseña el reverso: qué NO es causal de nulidad y quién puede declararla. https://cdn.www.gob.pe/uploads/document/file/3686042/Resoluci%C3%B3n%20N%C2%B0%202887-2022-SUNARP-TR.pdf

MODELO 3: CONSERVACIÓN Y SUBSANACIÓN DEL ACTO
Res. 039-2021-SUNARP/ZRN°VIII: una resolución jefatural consignó mal su propio número; la Zona Registral rectificó de oficio ese error material invocando el art. 212.1 del TUO, sin alterar el contenido del acto. El error se corrige, el acto se mantiene. https://cdn.www.gob.pe/uploads/document/file/1708823/RESOLUCI%C3%93N%20N%C2%B0%20039%20-2021%20RECTIFICACI%C3%93N%20DE%20ERROR%20MATERIAL.pdf
Ejemplo hipotético (municipalidad): una sanción motivada de forma breve pero identificable se completa en reconsideración; el vicio era de grado, no de ausencia, y el acto se conserva (arts. 14 y 15). Para este supuesto, cada grupo debe hallar una resolución REAL donde la entidad enmiende en vez de anular.

DÓNDE BUSCAR
Portales de jurisprudencia de SUNARP y del Tribunal Fiscal (mef.gob.pe), el buscador de normas legales de gob.pe, y los repositorios de resoluciones del Poder Judicial y del Tribunal Constitucional.

ENTREGA Y PLAZO
Un integrante registra al grupo, completa los cinco cuadros (con el enlace de cada resolución) y sube la presentación (PowerPoint o PDF). Plazo: viernes 20 de noviembre, 8:00 p. m. Exposición en clase: 8 minutos por grupo.
TXT;
    }

    private function uploadPrompt(): string
    {
        return <<<'TXT'
Suban la presentación con la que expondrán en clase (PowerPoint o PDF, 8 minutos). Una lámina por resolución, con: entidad y número, hechos, vicio y causal, si correspondía anular o conservar, y el enlace de acceso.
Indiquen en la primera lámina los nombres de los integrantes del grupo.
TXT;
    }
}
