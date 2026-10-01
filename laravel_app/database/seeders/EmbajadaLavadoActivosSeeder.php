<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Seeder;

class EmbajadaLavadoActivosSeeder extends Seeder
{
    public function run(): void
    {
        $training = Training::updateOrCreate(
            ['slug' => 'cuestiones-problematicas-lavado-activos'],
            [
                'title' => 'Cuestiones Problemáticas del Delito de Lavado de Activos',
                'subtitle' => 'Caso de estudio: Casación N.° 1726-2019/Ayacucho',
                'organizer' => 'Programa INL - Embajada de los Estados Unidos en el Perú · Centro de Estudios en Justicia y Derechos Humanos (MINJUSDH) · NCSC Perú',
                'speaker_name' => 'Denis Gabriel Romani Seminario',
                'speaker_title' => 'Abogado especialista en Compliance corporativo y ALA/CFT',
                'intro' => 'Taller dirigido a jueces, fiscales y operadores de justicia sobre los problemas sustantivos y probatorios del delito de lavado de activos, tomando como eje metodológico transversal la Casación N.° 1726-2019/Ayacucho (caso Quispe Marmolejo y Velarde Laura). Se abordará el valor probatorio del Informe de Inteligencia Financiera (IIF) y de los Reportes de Operaciones Sospechosas (ROS), la prueba por indicios, y su aplicación a los Proveedores de Servicios de Activos Virtuales (PSAV) y la trazabilidad en blockchain.',
                'time_limit_minutes' => 20,
                'is_active' => true,
            ]
        );

        $training->materials()->delete();
        $materials = [
            ['label' => 'Ficha de análisis jurisprudencial (Word)', 'file_path' => 'trainings/embajada/Ficha_Casacion_1726-2019-Ayacucho.docx', 'file_type' => 'docx', 'order' => 1],
            ['label' => 'Diapositivas del taller (PowerPoint)', 'file_path' => 'trainings/embajada/DIAPOS.pptx', 'file_type' => 'pptx', 'order' => 2],
            ['label' => 'Casación N.° 1726-2019/Ayacucho (PDF)', 'file_path' => 'trainings/embajada/CAS-1726-2019-Ayacucho.pdf', 'file_type' => 'pdf', 'order' => 3],
        ];
        foreach ($materials as $m) {
            $training->materials()->create($m);
        }

        $training->glossaryTerms()->delete();
        $glossary = [
            ['term' => 'IIF (Informe de Inteligencia Financiera)', 'definition' => 'Documento elaborado por la UIF-Perú a partir del análisis de ROS y otra información financiera. Es un insumo de inteligencia, no un medio de prueba autónomo: debe articularse con otros elementos para sustentar la imputación.', 'example' => 'No sustituye a la pericia contable ni a la prueba documental; se valora junto con los demás indicios.'],
            ['term' => 'ROS (Reporte de Operación Sospechosa)', 'definition' => 'Comunicación reservada que el sujeto obligado remite a la UIF-Perú cuando detecta una operación inusual vinculada a LA/FT. Su incumplimiento se sanciona como desobediencia administrativa (art. 5, Ley N.° 27693).', 'example' => null],
            ['term' => 'RO (Reporte de Operaciones)', 'definition' => 'A diferencia del ROS, es un reporte objetivo y periódico de operaciones que superan un umbral determinado (por ejemplo, en efectivo), sin que medie sospecha: es cumplimiento regular, no una alerta.', 'example' => null],
            ['term' => 'UIF-Perú', 'definition' => 'Unidad de Inteligencia Financiera del Perú, adscrita a la SBS (Ley N.° 29038), encargada de recibir, analizar y trasladar al Ministerio Público la información de inteligencia financiera.', 'example' => null],
            ['term' => 'Sujeto obligado', 'definition' => 'Persona natural o jurídica obligada por la Ley N.° 27693 y modificatorias a implementar un sistema de prevención y reportar operaciones sospechosas a la UIF-Perú.', 'example' => 'Notarías, bancos, casinos y, desde 2023-2024, los PSAV.'],
            ['term' => 'Lavado de activos (D. Leg. N.° 1106)', 'definition' => 'Delito autónomo que criminaliza dar apariencia de licitud a dinero, bienes, efectos o ganancias de origen delictivo, mediante actos de conversión, transferencia, ocultamiento y tenencia.', 'example' => null],
            ['term' => 'Delito fuente / actividad criminal precedente', 'definition' => 'Actividad ilícita generadora de las ganancias que luego se pretenden lavar. No requiere sentencia condenatoria previa ni proceso en trámite.', 'example' => 'En el caso Quispe Marmolejo, el tráfico ilícito de drogas.'],
            ['term' => 'Autolavado', 'definition' => 'Realización de actos de lavado de activos por el propio autor del delito fuente. Está expresamente confirmado y sancionado en el artículo 10 del D. Leg. N.° 1106.', 'example' => null],
            ['term' => 'Prueba por indicios', 'definition' => 'Pauta jurídica de valoración (no un medio de prueba) que permite inferir un hecho no probado directamente a partir de hechos base acreditados y una máxima de experiencia: silogismo de hecho base, máxima de experiencia y hecho presunto.', 'example' => null],
            ['term' => 'Máxima de experiencia', 'definition' => 'Regla general derivada de la observación de lo que ordinariamente ocurre, utilizada como premisa mayor en el razonamiento indiciario. Debe estar consolidada, no ser una suposición arbitraria.', 'example' => null],
            ['term' => 'Desbalance patrimonial', 'definition' => 'Diferencia entre los ingresos acreditados de una persona y su gasto o inversión real. Es un indicio relevante, pero no constituye por sí solo prueba suficiente del origen ilícito.', 'example' => null],
            ['term' => 'Ley N.° 30424', 'definition' => 'Establece la responsabilidad administrativa autónoma de las personas jurídicas por delitos como el lavado de activos, con sanciones de multa, inhabilitación, clausura y disolución. El modelo de prevención opera como eximente.', 'example' => null],
            ['term' => 'PSAV (Proveedor de Servicios de Activos Virtuales)', 'definition' => 'Exchanges y billeteras (custodias o no custodias) incorporados como nuevos sujetos obligados al sistema de prevención antilavado, conforme al D.S. N.° 006-2023-JUS y la Res. SBS N.° 02648-2024.', 'example' => null],
            ['term' => 'Exchange', 'definition' => 'Plataforma que permite intercambiar activos virtuales entre sí o por moneda fiat, de forma centralizada o descentralizada.', 'example' => null],
            ['term' => 'Wallet custodia / no custodia', 'definition' => 'En la billetera custodia, el proveedor controla las claves privadas del usuario. En la no custodia, el usuario las controla directamente, lo que dificulta la identificación por el PSAV.', 'example' => null],
            ['term' => 'Blockchain', 'definition' => 'Libro contable distribuido, público e inmutable, en el que queda registrada toda transacción entre direcciones, lo que permite reconstruir la ruta de los fondos.', 'example' => 'Cada movimiento entre dos wallets queda grabado permanentemente y puede consultarse por cualquiera, igual que un reporte de operaciones de un banco, pero sin intermediario central.'],
            ['term' => 'Trazabilidad en cadena (chain analysis)', 'definition' => 'Técnica de análisis de las transacciones registradas en la blockchain para reconstruir el flujo de fondos entre direcciones y sustentar la inferencia indiciaria del origen ilícito.', 'example' => 'Así como la reventa de un vehículo revela un patrón de transferencia en el caso Quispe Marmolejo, el rastro entre wallets puede evidenciar fraccionamientos hacia cuentas del mismo usuario antes de reconvertir a soles o dólares.'],
            ['term' => 'Colocación, estratificación e integración', 'definition' => 'Las tres fases del lavado aplicadas a criptoactivos: colocación (ingreso de efectivo ilícito vía un exchange, on-ramp), estratificación (fraccionamiento entre wallets o mixers) e integración (reconversión a moneda fiat o bienes, off-ramp).', 'example' => null],
            ['term' => 'Mixer (mezclador)', 'definition' => 'Servicio que combina fondos de múltiples usuarios en una sola bolsa para dificultar el rastreo del origen de las criptomonedas antes de devolverlas fraccionadas.', 'example' => null],
            ['term' => 'Travel Rule (Regla de Viaje del GAFI)', 'definition' => 'Obligación de los PSAV de transmitirse entre sí los datos del ordenante y del beneficiario de una transacción con activos virtuales, conforme al Cap. VIII de la Res. SBS N.° 02648-2024.', 'example' => null],
            ['term' => 'Incautación', 'definition' => 'Medida de aseguramiento provisional sobre bienes o activos vinculados al delito, adoptada en el curso de la investigación.', 'example' => null],
            ['term' => 'Decomiso', 'definition' => 'Consecuencia accesoria que priva definitivamente al agente de los efectos y ganancias del delito.', 'example' => null],
            ['term' => 'Congelamiento Administrativo de Fondos (CAF)', 'definition' => 'Medida administrativa de aplicación inmediata, prevista en la Ley N.° 27693 y modificatorias, ante operaciones vinculadas al lavado de activos o al financiamiento del terrorismo.', 'example' => null],
            ['term' => 'Extinción de dominio (D. Leg. N.° 1373)', 'definition' => 'Proceso autónomo, jurisdiccional y patrimonial, independiente de la responsabilidad penal, dirigido a declarar la pérdida del derecho de propiedad sobre bienes de origen o destino ilícito.', 'example' => null],
            ['term' => 'Dolo eventual / ignorancia deliberada', 'definition' => 'Formas de imputación subjetiva admitidas en el lavado de activos: basta que el agente conozca o deba presumir el origen ilícito del activo, sin exigirse conocimiento exacto del delito fuente ni de sus intervinientes.', 'example' => null],
        ];
        foreach ($glossary as $i => $g) {
            $training->glossaryTerms()->create($g + ['order' => $i + 1]);
        }

        $training->questions()->delete();
        $questions = [
            ['q' => 'Según el Fundamento Quinto de la Casación N.° 1726-2019/Ayacucho, la prueba por indicios es:', 'a' => 'Un medio de prueba autónomo equivalente a la prueba directa', 'b' => 'Una pauta jurídica de valoración, no un medio de prueba', 'c' => 'Un mecanismo exclusivo de la investigación fiscal, inaplicable en juicio', 'd' => 'Una presunción legal que invierte la carga de la prueba', 'correct' => 'B'],
            ['q' => '¿Cuál fue el defecto concreto que la Corte Suprema identificó en las dos instancias de mérito del caso Quispe Marmolejo y Velarde Laura?', 'a' => 'No se identificó ningún indicio relevante', 'b' => 'Se valoraron los indicios en conjunto sin analizarlos individualmente', 'c' => 'Se analizaron los siete indicios uno por uno, descartándolos aisladamente, en lugar de valorarlos como un sistema interrelacionado', 'd' => 'Se excluyó la prueba pericial por motivos de forma', 'correct' => 'C'],
            ['q' => 'Respecto del Informe de Inteligencia Financiera (IIF) elaborado por la UIF-Perú, ¿cuál es su valor probatorio correcto en el proceso penal?', 'a' => 'Constituye prueba plena y suficiente por sí sola para sustentar una condena', 'b' => 'Es un insumo de inteligencia que debe articularse con otros medios de prueba e indicios para sustentar la imputación', 'c' => 'No tiene ningún valor y no puede ser incorporado al proceso', 'd' => 'Solo puede ser valorado por el juez, nunca por el fiscal', 'correct' => 'B'],
            ['q' => 'El Reporte de Operación Sospechosa (ROS) y el Reporte de Operaciones (RO) se diferencian principalmente en que:', 'a' => 'Son el mismo documento con distinto nombre según la entidad que lo emite', 'b' => 'El ROS es una comunicación reservada ante una operación inusual o sospechosa, mientras que el RO es un reporte objetivo y periódico de operaciones que superan un umbral determinado, sin que medie sospecha', 'c' => 'El RO solo lo presentan las entidades bancarias y el ROS solo las notarías', 'd' => 'El ROS lo presenta el investigado y el RO lo presenta la víctima', 'correct' => 'B'],
            ['q' => 'En el caso Quispe Marmolejo, el dinero recibido desde Bolivia por un sujeto posteriormente intervenido con 15,096 kg de cocaína constituye, frente al delito de lavado de activos imputado, un acto de:', 'a' => 'Transporte', 'b' => 'Conversión', 'c' => 'Tenencia', 'd' => 'Transferencia', 'correct' => 'C'],
            ['q' => 'Conforme al artículo 10 del D. Leg. N.° 1106, respecto de la actividad criminal precedente (delito fuente) del lavado de activos:', 'a' => 'Se exige sentencia condenatoria firme previa sobre el delito fuente', 'b' => 'Se exige que el delito fuente esté siendo investigado simultáneamente', 'c' => 'No es necesario que el delito fuente esté investigado, procesado ni condenado', 'd' => 'El delito fuente debe haberse cometido en el mismo distrito judicial', 'correct' => 'C'],
            ['q' => 'La sola vinculación familiar o patrimonial de un procesado con personas condenadas o investigadas por tráfico ilícito de drogas:', 'a' => 'Acredita por sí sola el origen ilícito de los bienes adquiridos por el procesado', 'b' => 'Es irrelevante y no puede considerarse como indicio', 'c' => 'Constituye un indicio que debe valorarse en conjunto con los demás, pero no basta por sí sola para acreditar el origen ilícito', 'd' => 'Convierte automáticamente al procesado en autor del delito fuente', 'correct' => 'C'],
            ['q' => 'Según la Casación N.° 1726-2019/Ayacucho, para que la prueba indiciaria sea válida, los indicios deben:', 'a' => 'Analizarse de forma aislada y descartarse individualmente si no son concluyentes por sí solos', 'b' => 'Ser plurales, estar relacionados entre sí y valorarse en conjunto, no de forma aislada o fraccionada', 'c' => 'Reducirse a uno solo, el más sólido, descartando los demás', 'd' => 'Ser presentados únicamente por la parte acusadora', 'correct' => 'B'],
            ['q' => 'En el esquema de blanqueo con criptoactivos, la fase de "estratificación" consiste en:', 'a' => 'El ingreso inicial de efectivo de origen ilícito a un exchange', 'b' => 'El fraccionamiento de los fondos entre múltiples wallets, el uso de mezcladores (mixers) o intercambios entre distintas cadenas, para dificultar la trazabilidad', 'c' => 'La reconversión final de los criptoactivos a moneda fiat', 'd' => 'El reporte de la operación sospechosa por el exchange a la UIF', 'correct' => 'B'],
            ['q' => '¿Qué permite, técnicamente, la "trazabilidad en cadena" (chain analysis) en una investigación por lavado de activos con criptoactivos?', 'a' => 'Identificar automáticamente la identidad civil del titular de cualquier wallet, sin requerimiento al PSAV', 'b' => 'Reconstruir la ruta de los fondos entre direcciones a partir del registro público e inmutable de la blockchain, como insumo para sustentar una inferencia indiciaria', 'c' => 'Revertir o anular las transacciones fraudulentas ya confirmadas', 'd' => 'Sustituir por completo a la prueba pericial contable', 'correct' => 'B'],
            ['q' => 'Un wallet "custodio" (custodial) se diferencia de uno "no custodio" en que:', 'a' => 'El wallet custodio no requiere ningún registro ante el PSAV', 'b' => 'En el wallet custodio, el proveedor controla las claves privadas del usuario; en el no custodio, el usuario las controla directamente', 'c' => 'El wallet no custodio siempre pertenece a una entidad bancaria regulada', 'd' => 'No existe diferencia relevante para efectos de prevención de LA/FT', 'correct' => 'B'],
            ['q' => 'La "Regla de Viaje" (Travel Rule) del GAFI, incorporada en la Res. SBS N.° 02648-2024, obliga a:', 'a' => 'Los PSAV a registrar la ubicación GPS de cada operación', 'b' => 'Los PSAV a transmitirse entre sí los datos del ordenante y del beneficiario de una transacción con activos virtuales', 'c' => 'Los usuarios a viajar físicamente a declarar sus criptoactivos ante la UIF', 'd' => 'Los bancos a reportar únicamente operaciones superiores a USD 10,000', 'correct' => 'B'],
            ['q' => 'Respecto de las pericias contables 076 y 077 practicadas en el caso Quispe Marmolejo, la Corte Suprema consideró que su exclusión por las instancias de mérito fue irrazonable principalmente porque:', 'a' => 'Las pericias habían sido declaradas nulas por defectos de forma', 'b' => 'Se descartaron sin un análisis crítico sólido de sus fundamentos, amparándose en una máxima de experiencia no consolidada sobre informalidad comercial en la región', 'c' => 'El perito no compareció a la audiencia', 'd' => 'Las pericias fueron presentadas fuera del plazo legal', 'correct' => 'B'],
            ['q' => 'En cuanto a la imputación subjetiva en el lavado de activos (art. 10, D. Leg. N.° 1106), el tipo penal:', 'a' => 'Exige exclusivamente dolo directo, excluyendo el dolo eventual', 'b' => 'Exige que el agente conozca con precisión el delito fuente y a todos sus intervinientes', 'c' => 'Admite dolo directo y dolo eventual, bastando que el agente conozca o deba presumir el origen ilícito del activo, sin exigir conocimiento exacto del delito previo', 'd' => 'Es un delito culposo que no requiere dolo', 'correct' => 'C'],
            ['q' => 'Finalmente, en la Casación N.° 1726-2019/Ayacucho la Corte Suprema:', 'a' => 'Declaró fundados los recursos por infracción de precepto material y absolvió definitivamente a los procesados', 'b' => 'Declaró infundados los recursos por infracción de precepto material y apartamiento de doctrina, pero fundados por violación de la garantía de motivación; casó la sentencia de vista, anuló la de primera instancia y ordenó nuevo juicio oral ante otros jueces', 'c' => 'Confirmó íntegramente la absolución de ambas instancias sin modificación alguna', 'd' => 'Condenó directamente a los procesados en sede de casación', 'correct' => 'B'],
        ];
        foreach ($questions as $i => $q) {
            $training->questions()->create([
                'order' => $i + 1,
                'question' => $q['q'],
                'option_a' => $q['a'],
                'option_b' => $q['b'],
                'option_c' => $q['c'],
                'option_d' => $q['d'],
                'correct_option' => $q['correct'],
            ]);
        }

        $this->command?->info('Capacitación Embajada EE.UU. (Lavado de Activos): sembrada con '.count($glossary).' términos de glosario y '.count($questions).' preguntas.');
    }
}
