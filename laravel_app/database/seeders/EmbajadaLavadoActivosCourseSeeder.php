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

        $category = Category::firstOrCreate(
            ['slug' => 'prevencion-laft'],
            ['name' => 'Prevención LA/FT', 'description' => 'Capacitaciones sobre el sistema de prevención de lavado de activos y financiamiento del terrorismo.']
        );

        $course = Course::updateOrCreate(
            ['slug' => 'cuestiones-problematicas-lavado-activos'],
            [
                'category_id' => $category->id,
                'created_by' => $admin?->id,
                'title' => 'Cuestiones Problemáticas del Delito de Lavado de Activos',
                'description' => 'Taller dirigido a jueces, fiscales y operadores de justicia sobre los problemas sustantivos y probatorios del delito de lavado de activos, con la Casación N.° 1726-2019/Ayacucho (caso Quispe Marmolejo y Velarde Laura) como eje metodológico. Programa INL - Embajada de los Estados Unidos en el Perú · Centro de Estudios en Justicia y Derechos Humanos (MINJUSDH) · NCSC Perú.',
                'cover_image' => 'courses/covers/lavado-activos-embajada.svg',
                'instructor_name' => 'Denis Gabriel Romani Seminario',
                'instructor_id' => $instructor?->id,
                'duration_minutes' => 180,
                'is_published' => true,
                'certificate_type' => 'gratuita',
            ]
        );

        $course->modules->each(fn ($module) => $module->lessons()->delete());
        $course->modules()->delete();
        $course->exam()->delete();

        $modulesData = [
            [
                'title' => 'Módulo 1: El caso Quispe Marmolejo y Velarde Laura',
                'lessons' => [
                    [
                        'title' => 'Antecedentes fácticos y calificación típica',
                        'type' => 'text',
                        'duration_minutes' => 15,
                        'content' => "Entre 2008 y 2012, Carmen Rosa Quispe Marmolejo y su conviviente Claus Rober Velarde Laura adquirieron en Ayacucho dos inmuebles y varios vehículos, y transfirieron otros, por sumas que van de S/ 3,500 a US$ 15,000 por operación, sin acreditar el origen lícito del dinero.\n\nQuispe Marmolejo recibió además, entre abril de 2002 y octubre de 2012, S/ 10,819.65 enviados desde Bolivia por Albino Choque Vallejos, interceptado allí con 15,096 kg de cocaína. Sus propios hermanos habían sido procesados por tráfico ilícito de drogas, y el Ministerio Público la señaló como parte del llamado \"clan familiar Quispe Marmolejo\".\n\nLa acusación distinguió tres modalidades típicas, exactamente las que describe el D. Leg. N.° 1106:\n\n• Actos de conversión: compra de camionetas, un vehículo menor y dos inmuebles en Ayacucho, pagados en dólares y soles, sin sustento de ingresos lícitos.\n• Actos de transferencia: reventa de dos de esos vehículos a terceros, meses o años después de adquiridos.\n• Actos de tenencia: recepción y conservación del dinero remitido desde Bolivia por la persona vinculada al tráfico de drogas.\n\nNinguno de los dos procesados logró acreditar ante el fiscal el origen lícito del dinero con el que compró esos bienes.\n\nFuente: Casación N.° 1726-2019/Ayacucho, Fundamentos de Hecho, Primero.",
                    ],
                    [
                        'title' => 'El recorrido judicial: de la absolución a la casación',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "El 31 de enero de 2019, el juzgado de primera instancia absolvió a ambos procesados: consideró que un desbalance patrimonial, por sí solo, no bastaba para condenar por lavado de activos, y que las actividades de los acusados se encontraban sustentadas con constancias de trabajo, documentos de préstamo y reportes de pagos de entidades financieras.\n\nEl 16 de julio de 2019, la Sala Superior de Ayacucho confirmó la absolución, con el mismo argumento central: la vinculación familiar con el narcotráfico no demuestra, por sí sola, el origen ilícito del dinero. El Tribunal Superior identificó siete indicios, pero los analizó uno por uno para descartarlos individualmente.\n\nLa Fiscalía y la Procuraduría Especializada en Lavado de Activos llevaron el caso en casación ante la Corte Suprema, alegando infracción de precepto material, violación de la garantía de motivación y apartamiento de doctrina jurisprudencial.\n\nGuardemos la pregunta de qué resolvió finalmente la Corte Suprema: la retomaremos al cerrar el Módulo 3, cuando veamos cómo debe valorarse la prueba indiciaria.",
                    ],
                    [
                        'title' => 'Casación N.° 1726-2019/Ayacucho (documento completo)',
                        'type' => 'pdf',
                        'duration_minutes' => 25,
                        'file_path' => 'lessons/files/casacion-1726-2019-ayacucho.pdf',
                    ],
                    [
                        'title' => 'Ficha de análisis jurisprudencial (Word)',
                        'type' => 'file',
                        'duration_minutes' => 10,
                        'file_path' => 'lessons/files/ficha-casacion-1726-2019-ayacucho.docx',
                    ],
                    [
                        'title' => 'Diapositivas del taller (PowerPoint)',
                        'type' => 'file',
                        'duration_minutes' => 5,
                        'file_path' => 'lessons/files/diapositivas-lavado-activos-embajada.pptx',
                    ],
                ],
            ],
            [
                'title' => 'Módulo 2: Marco sustantivo y sistema de prevención antilavado',
                'lessons' => [
                    [
                        'title' => 'Marco normativo y tipo penal (D. Leg. N.° 1106)',
                        'type' => 'text',
                        'duration_minutes' => 15,
                        'content' => "El marco normativo antilavado peruano se construye sobre el D. Leg. N.° 1106, modificado por el D. Leg. N.° 1249, que es la norma penal vigente sobre lavado de activos. Se complementa con la Ley N.° 30077 (Ley contra el Crimen Organizado) —el vínculo del lavado con la criminalidad organizada presente en el \"clan familiar\" del caso que venimos siguiendo—, la Ley N.° 30424 (responsabilidad administrativa de las personas jurídicas) y la Ley N.° 27693 y modificatorias (creación y funciones de la UIF-Perú).\n\nEl artículo 1 del D. Leg. N.° 1106 tipifica los actos de conversión y transferencia: \"El que convierte o transfiere dinero, bienes, efectos o ganancias cuyo origen ilícito conoce o debía presumir, con la finalidad de evitar la identificación de su origen, su incautación o decomiso, será reprimido con pena privativa de la libertad no menor de ocho ni mayor de quince años...\".\n\nLas modalidades típicas se distribuyen así:\n\n• Art. 1 — Conversión y transferencia: convertir o transferir dinero, bienes, efectos o ganancias. En el caso Quispe Marmolejo: la compra de vehículos e inmuebles en Ayacucho.\n• Art. 2 — Ocultamiento y tenencia: adquirir, poseer, guardar o mantener en su poder bienes de origen ilícito. En el caso: el dinero recibido y conservado desde Bolivia.\n• Art. 3 — Transporte, traslado, ingreso o salida del país de dinero en efectivo o instrumentos financieros al portador (no fue objeto de esta acusación).\n• Art. 10 — Autonomía y prueba indiciaria: la actividad previa no necesita estar investigada, procesada ni condenada; comprende el autolavado. El tráfico de drogas del clan familiar no requería condena previa.",
                    ],
                    [
                        'title' => 'Doctrina vinculante: autonomía, consumación y sujetos problemáticos',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "La Sentencia Plenaria N.° 1-2017/CIJ-433 (FJ. 8) establece que el lavado de activos es un delito autónomo: \"...no siendo necesario que se sustancie un proceso penal respecto a una posible actividad delictiva grave\". La propia Corte Suprema cita este fundamento en la Casación N.° 1726-2019/Ayacucho para descartar que el tráfico de drogas del clan familiar debiera estar sentenciado.\n\nSobre la consumación, el Acuerdo Plenario N.° 3-2010/CJ-116 (FJ. 16) precisa que los actos de ocultamiento y tenencia (art. 2) tienen la estructura de los delitos permanentes: \"la permanencia del estado antijurídico durará lo que el agente decida o lo que este logre mantener sin que las agencias de control descubran...\". En cambio, el Acuerdo Plenario N.° 7-2011/CJ-116 (FJ. 8) califica los actos de conversión y transferencia como conductas iniciales de consumación instantánea.\n\nTres sujetos plantean problemas particulares:\n\n• Autolavado: las teorías del agotamiento del delito y del autoencubrimiento han sido superadas; su posibilidad jurídica está confirmada y sancionada expresamente en el art. 10 del D. Leg. N.° 1106.\n• Persona jurídica: responsabilidad autónoma determinada en sede penal (Ley N.° 30424), con sanciones de multa, clausura y disolución; el modelo de prevención opera como eximente.\n• El abogado defensor: la recepción de honorarios de origen sospechoso y el deber de confidencialidad plantean una tensión entre la defensa técnica y los deberes de prevención.",
                    ],
                    [
                        'title' => 'El sistema de prevención: del sujeto obligado a la UIF-Perú',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "El sistema de prevención antilavado opera como un flujo de tres pasos:\n\n1. Sujeto obligado: detecta una operación inusual o sospechosa en el ejercicio de su actividad (art. 3, Ley N.° 27693 y modificatorias).\n2. Reporte de Operaciones Sospechosas (ROS): comunicación reservada a la UIF-Perú; se sanciona la mera desobediencia administrativa ante el incumplimiento del deber de reporte (art. 5).\n3. UIF-Perú y Ministerio Público: la UIF-Perú analiza la información de inteligencia financiera y, de corresponder, la traslada al Ministerio Público para la investigación penal.\n\nSobre la Ley N.° 30424 (responsabilidad de la persona jurídica): la responsabilidad se determina en sede penal, con independencia de la responsabilidad de la persona natural; las sanciones incluyen multa, inhabilitación, clausura de locales y disolución; se valora conforme a matrices de riesgo propias del rubro y tamaño de la empresa.\n\nEl modelo de prevención eximente exige: identificación y mitigación de riesgos propios de la actividad, un encargado de prevención con autonomía funcional, canales de denuncia protegidos frente a represalias; su idoneidad es un elemento central de valoración para el operador de justicia.\n\nFuente: Ley N.° 27693 y Ley N.° 30424; Sílabo del taller, Centro de Estudios en Justicia y Derechos Humanos, MINJUSDH.",
                    ],
                    [
                        'title' => 'Glosario visual del taller',
                        'type' => 'glossary',
                        'duration_minutes' => 10,
                        'content' => null, // filled below as JSON
                    ],
                ],
            ],
            [
                'title' => 'Módulo 3: Prueba indiciaria e inteligencia financiera',
                'lessons' => [
                    [
                        'title' => 'El estándar probatorio y la prueba por indicios',
                        'type' => 'text',
                        'duration_minutes' => 13,
                        'content' => "En el caso Quispe Marmolejo no hubo confesión, testigos presenciales ni flagrancia: la Corte Suprema constató que no existía prueba directa del lavado de activos. Por eso correspondía aplicar la prueba por indicios, en los términos del artículo 158, numeral 3, del Código Procesal Penal.\n\nLa Casación N.° 1726-2019/Ayacucho (Fundamento Quinto, literal A) precisa: \"La prueba por indicios no es un medio de prueba sino una pauta jurídica de valoración [...] que se expresa a través del siguiente silogismo: hecho base o indicio, premisa menor; máxima de experiencia o criterio lógico, premisa mayor; hecho presunto, conclusión\".\n\nEl proceso penal por lavado de activos exige distinguir entre los grados de sospecha que habilitan cada acto de investigación y el estándar de prueba exigido para la condena. No es lo mismo el umbral para ordenar un allanamiento que el estándar para una sentencia condenatoria.",
                    ],
                    [
                        'title' => 'El vicio que corrigió la Corte Suprema: valoración conjunta de los indicios',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "Según la Casación N.° 1726-2019/Ayacucho (Fundamento Quinto, literal B, y Fundamento Sexto): \"Los indicios o afirmaciones base no solo han de ser periféricos al hecho principal, sino que además se aprecian en conjunto, no aisladamente: los hechos constitutivos del delito deben deducirse de estos indicios completamente probados [...] han de estar no solo relacionados con el hecho nuclear, sino además interrelacionados entre sí, como notas de un mismo sistema, de modo que la fuerza de convicción de esta prueba dimana no solo de la adición o suma, sino también de esta imbricación\".\n\nEl Tribunal Superior de Ayacucho había identificado siete indicios, pero los analizó uno por uno para descartarlos, en lugar de valorarlos como un sistema. Ese fue, precisamente, el defecto que la Corte Suprema corrigió: la motivación del fallo de vista resultó insuficiente por no dar cuenta cabal de los elementos de prueba, e irracional por introducir pautas de apreciación incompatibles con la lógica (ampararse en una \"máxima de experiencia\" sobre informalidad comercial no consolidada, para descartar sin análisis crítico las pericias contables 076 y 077).\n\nEl control de racionalidad de la prueba indiciaria se ejerce desde dos cánones: (i) el de su lógica o cohesión —será irrazonable si los indicios acreditados descartan el hecho que se hace desprender de ellos—, y (ii) el de su suficiencia o calidad concluyente —no es razonable la inferencia cuando sea excesivamente abierta, débil o imprecisa—.",
                    ],
                    [
                        'title' => 'El valor del IIF y del ROS en la investigación penal',
                        'type' => 'text',
                        'duration_minutes' => 12,
                        'content' => "Una pregunta frecuente entre operadores de justicia es si el Informe de Inteligencia Financiera (IIF) de la UIF-Perú \"prueba\" por sí solo el lavado de activos. La respuesta, conforme a la doctrina y a la lógica de la prueba indiciaria desarrollada en la Casación N.° 1726-2019/Ayacucho, es que no: el IIF es un insumo de inteligencia, no un medio de prueba autónomo.\n\n• Informes de la UIF-Perú (IIF): producto del análisis de inteligencia financiera sobre operaciones reportadas; constituyen un insumo relevante para orientar la investigación fiscal, pero deben articularse con otros medios de prueba e indicios para sustentar la imputación. Su valor se determina conforme a las reglas generales de la prueba indiciaria: ni es prueba plena, ni carece de todo valor.\n\n• Reportes de Operaciones Sospechosas (ROS): comunicaciones reservadas de los sujetos obligados que dan inicio al análisis de la UIF-Perú. A diferencia de un Reporte de Operaciones (RO) —que es un reporte objetivo y periódico de operaciones que superan un umbral determinado, sin que medie sospecha—, el ROS se activa únicamente ante una operación inusual o sospechosa detectada por el sujeto obligado.\n\nEn la práctica, el fiscal que construye su teoría del caso sobre un IIF o un ROS sin articularlos con pericias contables, prueba documental y demás indicios interrelacionados, corre el mismo riesgo que llevó a la casación del fallo en el caso Quispe Marmolejo: una motivación insuficiente.\n\nFuente: Ley N.° 27693, informes e inteligencia financiera de la UIF-Perú; Casación N.° 1726-2019/Ayacucho, Fundamento Quinto.",
                    ],
                    [
                        'title' => 'Imputación subjetiva, medidas cautelares y la decisión final del caso',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "Conforme al artículo 10 del D. Leg. N.° 1106, el tipo subjetivo exige que el agente conozca o debiera presumir el origen ilícito del activo; admite dolo directo y dolo eventual. El dolo abarca la inferencia razonada del origen criminal: no se exige el conocimiento exacto del delito previo ni su calificación jurídica precisa, sino la probabilidad delictiva del origen de los activos (R.N. N.° 1055-2018, sobre ignorancia deliberada).\n\nMientras el proceso avanza, el grado de sospecha alcanzado en la investigación determina la procedencia y proporcionalidad de cada medida cautelar sobre la persona o sobre los activos (Casación N.° 197-2024-Nacional, sobre prisión preventiva en lavado de activos). El control de estas medidas corresponde al juez de investigación preparatoria, ponderando el peligro procesal frente a la intensidad de la restricción de derechos.\n\nDecisión final del caso Quispe Marmolejo y Velarde Laura: el 23 de noviembre de 2021, la Sala Penal Permanente declaró infundados los recursos por infracción de precepto material y apartamiento de doctrina jurisprudencial, pero fundados por violación de la garantía de motivación. La Corte no dijo que los procesados fueran culpables: dijo que las dos instancias anteriores habían descartado los indicios de forma irracional, sin valorarlos en conjunto ni sustentar por qué las pericias contables no merecían crédito. En consecuencia, casaron la sentencia de vista, anularon la de primera instancia y ordenaron un nuevo juicio oral, ante otros jueces.\n\nLa lección para el operador de justicia no es el resultado, sino el método: una absolución, igual que una condena, necesita motivar cómo se valoraron los indicios en conjunto.",
                    ],
                ],
            ],
            [
                'title' => 'Módulo 4: Activos virtuales, PSAV y recuperación de activos',
                'lessons' => [
                    [
                        'title' => 'PSAV, blockchain y trazabilidad en cadena',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "Los Proveedores de Servicios de Activos Virtuales (PSAV) quedaron incorporados como nuevos sujetos obligados al sistema de prevención antilavado, conforme al D.S. N.° 006-2023-JUS y la Res. SBS N.° 02648-2024. Comprenden:\n\n• Exchanges: plataformas que permiten el intercambio de activos virtuales entre sí o por moneda fiat, centralizadas o descentralizadas.\n• Billeteras (wallets): custodias, cuando el proveedor controla las claves privadas del usuario, o no custodias, cuando el usuario las controla directamente —lo que dificulta la identificación por el PSAV—.\n\nLa blockchain es un libro contable distribuido, público e inmutable: toda transacción entre direcciones (wallet addresses) queda registrada de forma permanente, lo que permite reconstruir la ruta de los fondos. A esto se le llama trazabilidad en cadena (chain analysis): la técnica de analizar esas transacciones para reconstruir el flujo entre direcciones y sustentar una inferencia indiciaria sobre el origen ilícito.\n\nEl equivalente digital del caso Quispe Marmolejo: así como la reventa de un vehículo reveló un patrón de transferencia, el rastro entre direcciones puede evidenciar fraccionamientos hacia cuentas controladas por el mismo usuario antes de una reconversión a moneda fiat. La lógica de la prueba indiciaria es la misma; lo que cambia es la naturaleza técnica de la evidencia.",
                    ],
                    [
                        'title' => 'La dinámica criminal con criptoactivos y la Regla de Viaje',
                        'type' => 'text',
                        'duration_minutes' => 14,
                        'content' => "El blanqueo con activos virtuales replica las tres fases clásicas del lavado de activos, con una capa tecnológica adicional:\n\n1. Colocación (on-ramp): conversión de efectivo de origen ilícito en criptoactivos a través de un exchange con débil debida diligencia.\n2. Estratificación: fraccionamiento entre múltiples wallets, uso de mezcladores (mixers) o intercambios entre distintas cadenas (cross-chain swaps), para dificultar la trazabilidad.\n3. Integración (off-ramp): reconversión a moneda fiat o adquisición de bienes, con apariencia de origen lícito.\n\nPara la investigación, el PSAV es fuente de información y de prueba: conserva y reporta información de sus usuarios conforme a sus obligaciones de prevención, y presenta sus propios Reportes de Operaciones Sospechosas (ROS) ante operaciones inusuales con activos virtuales.\n\nLa Regla de Viaje del GAFI (Travel Rule), incorporada al Cap. VIII de la Res. SBS N.° 02648-2024 y vigente desde el 01.08.2026, obliga a los PSAV a transmitirse entre sí los datos del ordenante y del beneficiario de cada operación. Junto con el análisis de cadena (chain analysis), esta regla sustenta la inferencia indiciaria del origen ilícito en operaciones con criptoactivos.\n\nEl rol de cada operador frente al PSAV: el fiscal formula requerimientos de información y construye la inferencia indiciaria a partir de la trazabilidad en cadena; el juez valora el mérito probatorio de esa evidencia y controla la proporcionalidad de las medidas de aseguramiento; la defensa técnica examina críticamente la trazabilidad presentada y la licitud de los actos de investigación.",
                    ],
                    [
                        'title' => 'Herramientas de recuperación de activos',
                        'type' => 'text',
                        'duration_minutes' => 13,
                        'content' => "El ordenamiento peruano cuenta con varias herramientas para recuperar activos de origen ilícito, incluidos los activos virtuales:\n\n• Incautación: medida de aseguramiento provisional sobre bienes o activos vinculados al delito, adoptada en el curso de la investigación. Tratándose de activos virtuales, exige procedimientos técnicos específicos para el aseguramiento de las claves privadas y la custodia de las wallets identificadas; el requerimiento de congelamiento puede dirigirse directamente al PSAV que mantiene el control custodio.\n\n• Decomiso: consecuencia accesoria que priva definitivamente al agente de los efectos y ganancias del delito.\n\n• Congelamiento Administrativo de Fondos (CAF): medida administrativa prevista en la Ley N.° 27693 y modificatorias, de aplicación inmediata ante operaciones vinculadas al lavado de activos o al financiamiento del terrorismo.\n\n• Extinción de dominio (D. Leg. N.° 1373): proceso autónomo, jurisdiccional y patrimonial, independiente de la responsabilidad penal, dirigido a declarar la pérdida del derecho de propiedad sobre bienes de origen o destino ilícito. Complementa a la incautación y al decomiso penal cuando estos no resultan procedentes o suficientes; su tramitación corresponde a fiscalías y juzgados especializados en extinción de dominio.\n\nLa Casación N.° 775-2021-Puno es el referente jurisprudencial sobre los presupuestos y límites de la incautación en el delito de lavado de activos, y debe leerse en conjunto con la Casación N.° 197-2024-Nacional para el análisis integral de las medidas de aseguramiento. En todos los casos, la defensa técnica debe examinar la licitud de los actos de aseguramiento y la cadena de custodia aplicada.",
                    ],
                ],
            ],
        ];

        // Glosario visual: 25 términos del taller (legal + activos virtuales), sin iconos-emoji.
        $glossaryTerms = [
            ['term' => 'IIF (Informe de Inteligencia Financiera)', 'short' => 'Insumo de la UIF, no prueba autónoma', 'definition' => 'Documento elaborado por la UIF-Perú a partir del análisis de ROS y otra información financiera. Es un insumo de inteligencia que debe articularse con otros medios de prueba e indicios para sustentar la imputación.'],
            ['term' => 'ROS (Reporte de Operación Sospechosa)', 'short' => 'Comunicación reservada ante sospecha', 'definition' => 'Comunicación reservada que el sujeto obligado remite a la UIF-Perú cuando detecta una operación inusual vinculada a LA/FT. Su incumplimiento se sanciona como desobediencia administrativa (art. 5, Ley N.° 27693).', 'confuse' => 'El RO (Reporte de Operaciones), que es periódico y objetivo, sin que medie sospecha.'],
            ['term' => 'RO (Reporte de Operaciones)', 'short' => 'Reporte periódico, sin sospecha', 'definition' => 'Reporte objetivo y periódico de operaciones que superan un umbral determinado (por ejemplo, en efectivo). Es cumplimiento regular, distinto del ROS, que se activa solo ante sospecha.'],
            ['term' => 'UIF-Perú', 'short' => 'Unidad de Inteligencia Financiera', 'definition' => 'Unidad de Inteligencia Financiera del Perú, adscrita a la SBS (Ley N.° 29038), encargada de recibir, analizar y trasladar al Ministerio Público la información de inteligencia financiera.'],
            ['term' => 'Sujeto obligado', 'short' => 'Debe reportar a la UIF', 'definition' => 'Persona natural o jurídica obligada por la Ley N.° 27693 y modificatorias a implementar un sistema de prevención y reportar operaciones sospechosas a la UIF-Perú.'],
            ['term' => 'Lavado de activos (D. Leg. N.° 1106)', 'short' => 'Delito autónomo de conversión/tenencia', 'definition' => 'Delito autónomo que criminaliza dar apariencia de licitud a dinero, bienes, efectos o ganancias de origen delictivo, mediante actos de conversión, transferencia, ocultamiento y tenencia.'],
            ['term' => 'Delito fuente', 'short' => 'Actividad criminal precedente', 'definition' => 'Actividad ilícita generadora de las ganancias que luego se pretenden lavar. No requiere sentencia condenatoria previa ni proceso en trámite. En el caso Quispe Marmolejo, el tráfico ilícito de drogas.'],
            ['term' => 'Autolavado', 'short' => 'El autor del delito fuente lava sus propias ganancias', 'definition' => 'Realización de actos de lavado de activos por el propio autor del delito fuente. Está expresamente confirmado y sancionado en el artículo 10 del D. Leg. N.° 1106.'],
            ['term' => 'Prueba por indicios', 'short' => 'Pauta de valoración, no medio de prueba', 'definition' => 'Pauta jurídica de valoración que permite inferir un hecho no probado directamente a partir de hechos base acreditados y una máxima de experiencia: hecho base, máxima de experiencia y hecho presunto.'],
            ['term' => 'Máxima de experiencia', 'short' => 'Regla general consolidada', 'definition' => 'Regla general derivada de la observación de lo que ordinariamente ocurre, usada como premisa mayor en el razonamiento indiciario. Debe estar consolidada, no ser una suposición arbitraria.'],
            ['term' => 'Desbalance patrimonial', 'short' => 'Indicio, no prueba autónoma', 'definition' => 'Diferencia entre los ingresos acreditados de una persona y su gasto o inversión real. Es un indicio relevante, pero no constituye por sí solo prueba suficiente del origen ilícito.'],
            ['term' => 'Ley N.° 30424', 'short' => 'Responsabilidad de la persona jurídica', 'definition' => 'Establece la responsabilidad administrativa autónoma de las personas jurídicas por delitos como el lavado de activos, con multa, inhabilitación, clausura y disolución. El modelo de prevención opera como eximente.'],
            ['term' => 'PSAV (Proveedor de Servicios de Activos Virtuales)', 'short' => 'Exchanges y wallets, sujetos obligados', 'definition' => 'Exchanges y billeteras (custodias o no custodias) incorporados como nuevos sujetos obligados al sistema de prevención antilavado, conforme al D.S. N.° 006-2023-JUS y la Res. SBS N.° 02648-2024.'],
            ['term' => 'Exchange', 'short' => 'Plataforma de intercambio de criptoactivos', 'definition' => 'Plataforma que permite intercambiar activos virtuales entre sí o por moneda fiat, de forma centralizada o descentralizada.'],
            ['term' => 'Wallet custodia / no custodia', 'short' => 'Quién controla las claves privadas', 'definition' => 'En la billetera custodia, el proveedor controla las claves privadas del usuario. En la no custodia, el usuario las controla directamente, lo que dificulta la identificación por el PSAV.'],
            ['term' => 'Blockchain', 'short' => 'Libro contable público e inmutable', 'definition' => 'Libro contable distribuido, público e inmutable, en el que queda registrada toda transacción entre direcciones, lo que permite reconstruir la ruta de los fondos.'],
            ['term' => 'Trazabilidad en cadena (chain analysis)', 'short' => 'Reconstruir la ruta de los fondos', 'definition' => 'Técnica de análisis de las transacciones registradas en la blockchain para reconstruir el flujo de fondos entre direcciones y sustentar la inferencia indiciaria del origen ilícito.'],
            ['term' => 'Colocación, estratificación e integración', 'short' => 'Las tres fases del lavado con criptoactivos', 'definition' => 'Colocación: ingreso de efectivo ilícito vía un exchange (on-ramp). Estratificación: fraccionamiento entre wallets o mixers. Integración: reconversión a moneda fiat o bienes (off-ramp).'],
            ['term' => 'Mixer (mezclador)', 'short' => 'Dificulta el rastreo del origen', 'definition' => 'Servicio que combina fondos de múltiples usuarios en una sola bolsa para dificultar el rastreo del origen de las criptomonedas antes de devolverlas fraccionadas.'],
            ['term' => 'Travel Rule (Regla de Viaje del GAFI)', 'short' => 'PSAV deben compartir datos entre sí', 'definition' => 'Obligación de los PSAV de transmitirse entre sí los datos del ordenante y del beneficiario de una transacción con activos virtuales, conforme al Cap. VIII de la Res. SBS N.° 02648-2024.'],
            ['term' => 'Incautación', 'short' => 'Aseguramiento provisional', 'definition' => 'Medida de aseguramiento provisional sobre bienes o activos vinculados al delito, adoptada en el curso de la investigación.'],
            ['term' => 'Decomiso', 'short' => 'Privación definitiva de las ganancias', 'definition' => 'Consecuencia accesoria que priva definitivamente al agente de los efectos y ganancias del delito.'],
            ['term' => 'Congelamiento Administrativo de Fondos (CAF)', 'short' => 'Medida administrativa inmediata', 'definition' => 'Medida administrativa de aplicación inmediata, prevista en la Ley N.° 27693 y modificatorias, ante operaciones vinculadas al lavado de activos o al financiamiento del terrorismo.'],
            ['term' => 'Extinción de dominio (D. Leg. N.° 1373)', 'short' => 'Proceso patrimonial autónomo', 'definition' => 'Proceso autónomo, jurisdiccional y patrimonial, independiente de la responsabilidad penal, dirigido a declarar la pérdida del derecho de propiedad sobre bienes de origen o destino ilícito.'],
            ['term' => 'Dolo eventual / ignorancia deliberada', 'short' => 'Basta presumir el origen ilícito', 'definition' => 'Formas de imputación subjetiva admitidas en el lavado de activos: basta que el agente conozca o deba presumir el origen ilícito del activo, sin exigirse conocimiento exacto del delito fuente.'],
        ];
        // Suppress the template's default magnifier emoji icon by forcing an empty string.
        $glossaryTerms = array_map(fn ($t) => $t + ['icon' => ''], $glossaryTerms);

        foreach ($modulesData as $order => $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
                'order' => $order + 1,
            ]);

            foreach ($moduleData['lessons'] as $lessonOrder => $lessonData) {
                $content = $lessonData['content'] ?? null;
                if ($lessonData['type'] === 'glossary') {
                    $content = json_encode([
                        'intro' => 'Términos clave del taller: inteligencia financiera, prueba indiciaria y activos virtuales. Use el buscador o haga clic en cualquier tarjeta para ver la definición completa.',
                        'terms' => $glossaryTerms,
                    ]);
                }

                $module->lessons()->create([
                    'title' => $lessonData['title'],
                    'type' => $lessonData['type'],
                    'video_url' => $lessonData['video_url'] ?? null,
                    'file_path' => $lessonData['file_path'] ?? null,
                    'content' => $content,
                    'duration_minutes' => $lessonData['duration_minutes'] ?? null,
                    'order' => $lessonOrder + 1,
                ]);
            }
        }

        $exam = $course->exam()->create([
            'title' => 'Evaluación final: Cuestiones Problemáticas del Delito de Lavado de Activos',
            'passing_score' => 70,
            'max_attempts' => 2,
            'time_limit_minutes' => 20,
        ]);

        $questions = [
            ['q' => 'Según el Fundamento Quinto de la Casación N.° 1726-2019/Ayacucho, la prueba por indicios es:', 'options' => ['Un medio de prueba autónomo equivalente a la prueba directa', 'Una pauta jurídica de valoración, no un medio de prueba', 'Un mecanismo exclusivo de la investigación fiscal, inaplicable en juicio', 'Una presunción legal que invierte la carga de la prueba'], 'correct' => 1],
            ['q' => '¿Cuál fue el defecto concreto que la Corte Suprema identificó en las dos instancias de mérito del caso Quispe Marmolejo y Velarde Laura?', 'options' => ['No se identificó ningún indicio relevante', 'Se valoraron los indicios en conjunto sin analizarlos individualmente', 'Se analizaron los siete indicios uno por uno, descartándolos aisladamente, en lugar de valorarlos como un sistema interrelacionado', 'Se excluyó la prueba pericial por motivos de forma'], 'correct' => 2],
            ['q' => 'Respecto del Informe de Inteligencia Financiera (IIF) elaborado por la UIF-Perú, ¿cuál es su valor probatorio correcto en el proceso penal?', 'options' => ['Constituye prueba plena y suficiente por sí sola para sustentar una condena', 'Es un insumo de inteligencia que debe articularse con otros medios de prueba e indicios para sustentar la imputación', 'No tiene ningún valor y no puede ser incorporado al proceso', 'Solo puede ser valorado por el juez, nunca por el fiscal'], 'correct' => 1],
            ['q' => 'El Reporte de Operación Sospechosa (ROS) y el Reporte de Operaciones (RO) se diferencian principalmente en que:', 'options' => ['Son el mismo documento con distinto nombre según la entidad que lo emite', 'El ROS es una comunicación reservada ante una operación inusual o sospechosa, mientras que el RO es un reporte objetivo y periódico de operaciones que superan un umbral determinado, sin que medie sospecha', 'El RO solo lo presentan las entidades bancarias y el ROS solo las notarías', 'El ROS lo presenta el investigado y el RO lo presenta la víctima'], 'correct' => 1],
            ['q' => 'En el caso Quispe Marmolejo, el dinero recibido desde Bolivia por un sujeto posteriormente intervenido con 15,096 kg de cocaína constituye, frente al delito de lavado de activos imputado, un acto de:', 'options' => ['Transporte', 'Conversión', 'Tenencia', 'Transferencia'], 'correct' => 2],
            ['q' => 'Conforme al artículo 10 del D. Leg. N.° 1106, respecto de la actividad criminal precedente (delito fuente) del lavado de activos:', 'options' => ['Se exige sentencia condenatoria firme previa sobre el delito fuente', 'Se exige que el delito fuente esté siendo investigado simultáneamente', 'No es necesario que el delito fuente esté investigado, procesado ni condenado', 'El delito fuente debe haberse cometido en el mismo distrito judicial'], 'correct' => 2],
            ['q' => 'La sola vinculación familiar o patrimonial de un procesado con personas condenadas o investigadas por tráfico ilícito de drogas:', 'options' => ['Acredita por sí sola el origen ilícito de los bienes adquiridos por el procesado', 'Es irrelevante y no puede considerarse como indicio', 'Constituye un indicio que debe valorarse en conjunto con los demás, pero no basta por sí sola para acreditar el origen ilícito', 'Convierte automáticamente al procesado en autor del delito fuente'], 'correct' => 2],
            ['q' => 'Según la Casación N.° 1726-2019/Ayacucho, para que la prueba indiciaria sea válida, los indicios deben:', 'options' => ['Analizarse de forma aislada y descartarse individualmente si no son concluyentes por sí solos', 'Ser plurales, estar relacionados entre sí y valorarse en conjunto, no de forma aislada o fraccionada', 'Reducirse a uno solo, el más sólido, descartando los demás', 'Ser presentados únicamente por la parte acusadora'], 'correct' => 1],
            ['q' => 'En el esquema de blanqueo con criptoactivos, la fase de "estratificación" consiste en:', 'options' => ['El ingreso inicial de efectivo de origen ilícito a un exchange', 'El fraccionamiento de los fondos entre múltiples wallets, el uso de mezcladores (mixers) o intercambios entre distintas cadenas, para dificultar la trazabilidad', 'La reconversión final de los criptoactivos a moneda fiat', 'El reporte de la operación sospechosa por el exchange a la UIF'], 'correct' => 1],
            ['q' => '¿Qué permite, técnicamente, la "trazabilidad en cadena" (chain analysis) en una investigación por lavado de activos con criptoactivos?', 'options' => ['Identificar automáticamente la identidad civil del titular de cualquier wallet, sin requerimiento al PSAV', 'Reconstruir la ruta de los fondos entre direcciones a partir del registro público e inmutable de la blockchain, como insumo para sustentar una inferencia indiciaria', 'Revertir o anular las transacciones fraudulentas ya confirmadas', 'Sustituir por completo a la prueba pericial contable'], 'correct' => 1],
            ['q' => 'Un wallet "custodio" (custodial) se diferencia de uno "no custodio" en que:', 'options' => ['El wallet custodio no requiere ningún registro ante el PSAV', 'En el wallet custodio, el proveedor controla las claves privadas del usuario; en el no custodio, el usuario las controla directamente', 'El wallet no custodio siempre pertenece a una entidad bancaria regulada', 'No existe diferencia relevante para efectos de prevención de LA/FT'], 'correct' => 1],
            ['q' => 'La "Regla de Viaje" (Travel Rule) del GAFI, incorporada en la Res. SBS N.° 02648-2024, obliga a:', 'options' => ['Los PSAV a registrar la ubicación GPS de cada operación', 'Los PSAV a transmitirse entre sí los datos del ordenante y del beneficiario de una transacción con activos virtuales', 'Los usuarios a viajar físicamente a declarar sus criptoactivos ante la UIF', 'Los bancos a reportar únicamente operaciones superiores a USD 10,000'], 'correct' => 1],
            ['q' => 'Respecto de las pericias contables 076 y 077 practicadas en el caso Quispe Marmolejo, la Corte Suprema consideró que su exclusión por las instancias de mérito fue irrazonable principalmente porque:', 'options' => ['Las pericias habían sido declaradas nulas por defectos de forma', 'Se descartaron sin un análisis crítico sólido de sus fundamentos, amparándose en una máxima de experiencia no consolidada sobre informalidad comercial en la región', 'El perito no compareció a la audiencia', 'Las pericias fueron presentadas fuera del plazo legal'], 'correct' => 1],
            ['q' => 'En cuanto a la imputación subjetiva en el lavado de activos (art. 10, D. Leg. N.° 1106), el tipo penal:', 'options' => ['Exige exclusivamente dolo directo, excluyendo el dolo eventual', 'Exige que el agente conozca con precisión el delito fuente y a todos sus intervinientes', 'Admite dolo directo y dolo eventual, bastando que el agente conozca o deba presumir el origen ilícito del activo, sin exigir conocimiento exacto del delito previo', 'Es un delito culposo que no requiere dolo'], 'correct' => 2],
            ['q' => 'Finalmente, en la Casación N.° 1726-2019/Ayacucho la Corte Suprema:', 'options' => ['Declaró fundados los recursos por infracción de precepto material y absolvió definitivamente a los procesados', 'Declaró infundados los recursos por infracción de precepto material y apartamiento de doctrina, pero fundados por violación de la garantía de motivación; casó la sentencia de vista, anuló la de primera instancia y ordenó nuevo juicio oral ante otros jueces', 'Confirmó íntegramente la absolución de ambas instancias sin modificación alguna', 'Condenó directamente a los procesados en sede de casación'], 'correct' => 1],
        ];

        foreach ($questions as $order => $q) {
            $question = $exam->questions()->create([
                'question_text' => $q['q'],
                'order' => $order + 1,
                'points' => 1,
            ]);

            foreach ($q['options'] as $i => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => $i === $q['correct'],
                    'order' => $i,
                ]);
            }
        }

        $this->command?->info('Curso "Cuestiones Problemáticas del Delito de Lavado de Activos" creado con '.count($modulesData).' módulos y '.count($questions).' preguntas.');
    }
}
