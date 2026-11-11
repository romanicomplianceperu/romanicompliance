<?php

namespace App\Support;

/**
 * Capacitaciones de la web pública (formato nuevo). Todo el contenido vive aquí para
 * poder editarlo sin tocar la vista: video, fechas, precio, módulos, beneficios y preguntas.
 *
 * Los campos en null se muestran como «Por confirmar».
 */
class TrainingCatalog
{
    public const LEAD_PREFIX = 'capacitacion-';

    public static function all(): array
    {
        return [
            'informe-anual-oficial-cumplimiento' => [
                'name' => 'Informe Anual del Oficial de Cumplimiento (IAOC)',
                'short' => 'Informe Anual del OC',
                'kicker' => 'Capacitación para Oficiales de Cumplimiento',
                'badge' => 'Nuevo programa',
                'noindex' => true,   // versión de prueba: no se indexa hasta publicarla
                'title' => 'Del dato al informe aprobado.',
                'title_em' => 'Elabore su IAOC',
                'headline' => 'Elabore el Informe Anual del Oficial de Cumplimiento sin sorpresas',
                'lead' => 'Un taller práctico para reunir las cifras, ordenar las evidencias, redactar cada sección y presentar el IAOC a su directorio y a la UIF-Perú dentro del plazo.',
                'description' => 'Capacitación práctica para oficiales de cumplimiento: cómo elaborar, aprobar y enviar el Informe Anual del Oficial de Cumplimiento (IAOC) ante la UIF-Perú. Plantillas editables, casos y certificado.',

                // Video de presentación. Para activarlo basta con completar uno de los dos campos:
                //   'url'     → enlace de YouTube (watch, youtu.be o embed) o de Vimeo, o un .mp4 propio.
                //   'poster'  → (opcional) imagen de portada, por ejemplo '/images/capacitaciones/iaoc-portada.jpg'.
                'video' => ['url' => null, 'poster' => null, 'title' => 'Presentación del curso'],

                'facts' => [
                    ['icon' => 'clock', 'k' => 'Duración', 'v' => '8 horas lectivas'],
                    ['icon' => 'chat', 'k' => 'Modalidad', 'v' => 'En vivo online · 4 sesiones'],
                    ['icon' => 'cap', 'k' => 'Certificado', 'v' => 'De participación, verificable'],
                    ['icon' => 'doc', 'k' => 'Material', 'v' => 'Plantillas editables incluidas'],
                ],
                'next_date' => null,          // p. ej. '12 de enero de 2027'
                'price' => null,              // p. ej. 'S/ 390'
                'price_note' => 'Descuentos para equipos y capacitación in-company.',
                'seats' => 'Cupos limitados por edición, para poder revisar casos.',

                'stats' => [
                    ['n' => '8', 'l' => 'horas lectivas'],
                    ['n' => '4', 'l' => 'sesiones en vivo'],
                    ['n' => '6', 'l' => 'plantillas y checklists'],
                    ['n' => '14', 'l' => 'puntos del contenido mínimo'],
                ],

                'audience' => [
                    ['icon' => 'shield', 't' => 'Oficiales de cumplimiento', 'p' => 'Titulares y suplentes que elaboran el IAOC cada año y quieren hacerlo con método, no a último minuto.'],
                    ['icon' => 'coin', 't' => 'Equipos de PSAV y fintech', 'p' => 'Exchanges, billeteras y mesas OTC que reportan a la UIF-Perú y necesitan un informe consistente con su modelo de riesgo.'],
                    ['icon' => 'scale', 't' => 'Directorio y alta gerencia', 'p' => 'Quienes aprueban el informe y deben entender qué firman, qué se les pregunta y qué evidencias lo sustentan.'],
                ],

                'pains' => [
                    'Las cifras están dispersas en hojas de cálculo y cada área las entrega distinto.',
                    'No queda claro qué evidencia respalda cada afirmación del informe.',
                    'El informe se redacta en enero, con prisa, y se aprueba sin revisión real.',
                    'La UIF observa inconsistencias entre el IAOC, el manual y la matriz de riesgos.',
                ],

                'learn' => [
                    'Qué exige la norma para el contenido mínimo del IAOC y quién lo aprueba.',
                    'Armar el cronograma anual del oficial de cumplimiento para llegar a febrero sin urgencias.',
                    'Consolidar las estadísticas mensuales de RO, operaciones inusuales y ROS con una sola fuente de verdad.',
                    'Describir señales de alerta y tipologías nuevas con un lenguaje claro y verificable.',
                    'Documentar el programa de capacitación, el cumplimiento del manual y las medidas correctivas.',
                    'Dar seguimiento a las observaciones de la auditoría y del supervisor, y reportarlas bien.',
                    'Presentar el informe al directorio: resumen ejecutivo, hallazgos y plan de acción.',
                    'Enviar el IAOC por el Portal PLAFT y conservar la evidencia del envío.',
                ],

                // Plazos según el texto original publicado en El Peruano (verificado el 11-nov-2026).
                'norm' => [
                    'title' => 'Lo que dice la norma',
                    'lead' => 'El IAOC no es un trámite libre: la SBS fija su contenido mínimo, su aprobación y su envío.',
                    'cards' => [
                        ['k' => 'Qué es', 'v' => 'Informe anual', 'p' => 'Informe sobre el cumplimiento de las políticas y procedimientos del sistema de prevención LA/FT del año calendario anterior.'],
                        ['k' => 'Aprobación', 'v' => '30 días', 'p' => 'Lo aprueba el directorio u órgano equivalente, dentro de los 30 días siguientes al cierre del año.'],
                        ['k' => 'Envío', 'v' => '15 de febrero', 'p' => 'A más tardar el 15 de febrero del año siguiente, por el Portal PLAFT de la SBS, a través del oficial de cumplimiento.'],
                        ['k' => 'Grupo económico', 'v' => 'Uno por sujeto', 'p' => 'Si el oficial es corporativo, presenta un IAOC por cada sujeto obligado del grupo.'],
                    ],
                    'sources' => [
                        ['label' => 'Res. SBS 789-2018, art. 26 (sujetos obligados supervisados por la UIF-Perú)', 'url' => 'https://busquedas.elperuano.pe/dispositivo/SE/1622145-1'],
                        ['label' => 'Res. SBS 02648-2024, art. 30 (PSAV)', 'url' => 'https://busquedas.elperuano.pe/dispositivo/SE/2311275-1'],
                    ],
                    'note' => 'Resumen del texto original publicado; la norma ha tenido modificatorias. En el curso trabajamos siempre con la versión vigente y la que corresponda a su sector.',
                ],

                'timeline' => [
                    ['d' => '31 dic', 't' => 'Cierra el año calendario', 'p' => 'Se congelan las cifras: RO, operaciones inusuales y ROS del año.'],
                    ['d' => 'Enero', 't' => 'Se redacta y se revisa', 'p' => 'El oficial consolida estadísticas, evidencias y acciones correctivas.'],
                    ['d' => '30 ene', 't' => 'Aprueba el directorio', 'p' => 'Plazo máximo de aprobación: 30 días desde el cierre del periodo.'],
                    ['d' => '15 feb', 't' => 'Se envía por el Portal PLAFT', 'p' => 'Último día para que el IAOC llegue a la SBS.'],
                ],

                'modules' => [
                    ['t' => 'El IAOC en el sistema de prevención', 'min' => 60, 'p' => 'Para qué sirve, quién lo exige y cómo se conecta con el manual, el código de conducta y la matriz de riesgos.', 'act' => 'Mapa de coherencia entre sus documentos del SPLAFT.'],
                    ['t' => 'Contenido mínimo, sección por sección', 'min' => 90, 'p' => 'Los datos generales, las estadísticas, las tipologías, la capacitación, el cumplimiento del manual y las acciones correctivas.', 'act' => 'Checklist de contenido mínimo aplicado a su caso.'],
                    ['t' => 'Datos y evidencias', 'min' => 60, 'p' => 'Qué fuentes usar, cómo consolidarlas cada mes y cómo dejar evidencia que resista una supervisión.', 'act' => 'Matriz de evidencias por sección del informe.'],
                    ['t' => 'Estadísticas: RO, operaciones inusuales y ROS', 'min' => 60, 'p' => 'Cómo presentar las cifras mensuales, qué análisis agregar y cómo explicar variaciones.', 'act' => 'Tablero mensual y análisis de variaciones.'],
                    ['t' => 'Taller de redacción', 'min' => 90, 'p' => 'Redactar con claridad: señales de alerta, tipologías, hallazgos y medidas correctivas. Ejemplos buenos y malos.', 'act' => 'Reescritura guiada de secciones reales (anonimizadas).'],
                    ['t' => 'Aprobación y presentación al directorio', 'min' => 45, 'p' => 'Resumen ejecutivo, acta de aprobación y las preguntas que suele hacer un directorio.', 'act' => 'Modelo de presentación y acta de aprobación.'],
                    ['t' => 'Envío por el Portal PLAFT y cierre', 'min' => 30, 'p' => 'Estructura de envío, constancia, archivo y errores frecuentes.', 'act' => 'Lista de verificación previa al envío.'],
                    ['t' => 'Cronograma anual y mejora continua', 'min' => 45, 'p' => 'Convertir el IAOC en un calendario de trabajo que empieza en enero y no en diciembre.', 'act' => 'Su cronograma anual de cumplimiento, listo para usar.'],
                ],

                'deliverables' => [
                    ['icon' => 'doc', 't' => 'Plantilla editable del IAOC', 'p' => 'Con las secciones del contenido mínimo y guías de redacción.'],
                    ['icon' => 'check', 't' => 'Checklist de contenido mínimo', 'p' => 'Para verificar que no falte nada antes de enviar.'],
                    ['icon' => 'search', 't' => 'Matriz de evidencias', 'p' => 'Qué documento respalda cada afirmación del informe.'],
                    ['icon' => 'scale', 't' => 'Modelo de acta y presentación', 'p' => 'Para el directorio: resumen ejecutivo y acta de aprobación.'],
                    ['icon' => 'clock', 't' => 'Cronograma anual del OC', 'p' => 'De enero a febrero, con responsables y fechas.'],
                    ['icon' => 'book', 't' => 'Banco de ejemplos de redacción', 'p' => 'Frases y estructuras para señales de alerta y tipologías.'],
                ],

                'benefits' => [
                    ['t' => 'Llegue a febrero con el informe listo', 'p' => 'Un método de trabajo que reparte el esfuerzo durante el año.'],
                    ['t' => 'Informes consistentes y defendibles', 'p' => 'Cada dato con su fuente y cada afirmación con su evidencia.'],
                    ['t' => 'Directorio informado', 'p' => 'Aprueba con criterio, no por trámite.'],
                    ['t' => 'Menos riesgo de observaciones', 'p' => 'Revise su informe con la mirada de quien supervisa.'],
                    ['t' => 'Ahorro de tiempo', 'p' => 'Plantillas y listas listas para adaptar a su empresa.'],
                    ['t' => 'Acompañamiento posterior', 'p' => 'Resuelva dudas de su primer IAOC con el equipo de Romani Compliance.'],
                ],

                'method' => [
                    ['t' => 'Sesiones en vivo', 'p' => 'Cuatro sesiones online con casos y preguntas en tiempo real.'],
                    ['t' => 'Casos reales anonimizados', 'p' => 'Informes y observaciones tipo, para practicar sobre material verdadero.'],
                    ['t' => 'Taller de redacción', 'p' => 'Se escribe durante la clase; no solo se escucha.'],
                    ['t' => 'Evaluación y certificado', 'p' => 'Cuestionario final y certificado verificable de Romani Compliance.'],
                ],

                'instructor' => [
                    'name' => 'Dr. Denis Romani',
                    'role' => 'Director de Romani Compliance',
                    'bio' => 'Abogado especialista en compliance corporativo y prevención LA/FT. Máster en Derecho Penal (PUCP) y Máster en Cumplimiento Normativo Penal (UCLM, España), con más de 15 años de experiencia en investigación financiera y prevención de lavado de activos.',
                    'photo' => 'images/denis-romani-avatar.webp',
                    'chips' => ['Compliance corporativo', 'Prevención LA/FT', 'Máster PUCP', 'Máster UCLM'],
                ],

                'faq' => [
                    ['q' => '¿Es válido para acreditar capacitación ante la UIF o la SBS?', 'a' => 'El certificado deja constancia de su participación, el temario y las horas lectivas. Su empresa decide cómo incorporarlo en su programa de capacitación del oficial de cumplimiento.'],
                    ['q' => '¿Aplica a mi sector?', 'a' => 'El contenido mínimo del IAOC es similar para los sujetos obligados bajo supervisión de la UIF-Perú y para los PSAV. En el taller adaptamos el ejemplo a su rubro; si su empresa responde a otra norma sectorial, lo vemos antes de inscribirlo.'],
                    ['q' => '¿Qué pasa si no puedo asistir a una sesión?', 'a' => 'Recibirá el material y la grabación de la sesión para que no pierda el hilo del taller.'],
                    ['q' => '¿Puedo llevar a mi equipo o al directorio?', 'a' => 'Sí. Hay precios por equipo y una versión in-company, adaptada a su empresa y a su propio informe.'],
                    ['q' => '¿Reciben mi borrador de IAOC para revisarlo?', 'a' => 'En la versión in-company sí: revisamos su borrador. En la versión abierta trabajamos con casos anonimizados para proteger la confidencialidad de su empresa.'],
                    ['q' => '¿Cómo me inscribo?', 'a' => 'Complete el formulario de esta página. Le escribimos con fechas, costo y datos de pago, y reservamos su cupo.'],
                ],

                'whatsapp' => 'Hola, deseo información sobre la capacitación del Informe Anual del Oficial de Cumplimiento (IAOC).',
            ],
        ];
    }

    public static function find(string $slug): ?array
    {
        return static::all()[$slug] ?? null;
    }

    /** Slug con el que se guarda la solicitud de inscripción (ServiceLead). */
    public static function leadSlug(string $slug): string
    {
        return self::LEAD_PREFIX.$slug;
    }

    /** Devuelve la capacitación asociada a un slug de solicitud, si lo es. */
    public static function findByLeadSlug(string $leadSlug): ?array
    {
        if (! str_starts_with($leadSlug, self::LEAD_PREFIX)) {
            return null;
        }

        return static::find(substr($leadSlug, strlen(self::LEAD_PREFIX)));
    }

    /** Datos para incrustar el video: iframe de YouTube/Vimeo, archivo de video, o null si aún no hay. */
    public static function embed(?array $video): ?array
    {
        $url = trim((string) ($video['url'] ?? ''));
        if ($url === '') {
            return null;
        }
        if (preg_match('~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([\w-]{11})~', $url, $m)) {
            return ['type' => 'iframe', 'src' => 'https://www.youtube-nocookie.com/embed/'.$m[1].'?rel=0&modestbranding=1&autoplay=1'];
        }
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
            return ['type' => 'iframe', 'src' => 'https://player.vimeo.com/video/'.$m[1].'?autoplay=1'];
        }
        if (preg_match('~\.(mp4|webm|mov)(\?.*)?$~i', $url)) {
            return ['type' => 'file', 'src' => $url];
        }

        return null;
    }
}
