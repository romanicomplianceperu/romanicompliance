<?php

namespace App\Support;

/**
 * Fuente única de los servicios del sitio público: la usan la página de inicio (tarjetas y
 * selector «¿Qué necesita resolver?»), el menú y cada landing de /servicios/{slug}. Cambiar un
 * texto aquí lo cambia en todas partes.
 */
class ServiceCatalog
{
    public const WHATSAPP = '51969754983';

    public static function all(): array
    {
        return [
            'compliance-penal' => [
                'name' => 'Compliance Penal y LA/FT',
                'icon' => 'shield',
                'card' => 'Un sistema de prevención que funciona en la práctica, conforme a la Ley 30424 y a la normativa SBS/UIF.',
                'includes' => ['Manual SPLAFT y matriz de riesgos', 'Código de conducta y canal de denuncias', 'Oficial de cumplimiento y plan anual', 'Debida diligencia e investigación financiera'],
                'cta' => 'Diagnóstico de riesgo',
                'situation' => 'Necesito ordenar mi sistema de prevención',
                'hero_title' => 'Prevención que resiste una revisión.',
                'hero_sub' => 'Diseñamos e implementamos su modelo de prevención penal y su sistema SPLAFT con documentos que su equipo entiende y aplica, no carpetas que solo se archivan.',
                'tool_title' => 'Diagnóstico de riesgo',
                'tool_sub' => 'Nueve preguntas para medir qué tan preparado está su sistema de prevención. Toma dos minutos.',
                'steps' => [
                    ['Diagnóstico inicial', 'Revisamos su actividad, su exposición y lo que ya tiene implementado.'],
                    ['Matriz de riesgos', 'Identificamos y priorizamos los riesgos LA/FT y penales propios de su operación.'],
                    ['Documentos a medida', 'Manual SPLAFT, código de conducta, políticas de debida diligencia y canal de denuncias.'],
                    ['Implementación', 'Acompañamos la designación del oficial de cumplimiento, el plan anual y la capacitación del equipo.'],
                    ['Seguimiento', 'Revisiones periódicas para que el sistema siga vigente cuando cambian la norma o el negocio.'],
                ],
                'deliverables' => ['Manual SPLAFT', 'Matriz de riesgos', 'Código de conducta', 'Canal de denuncias', 'Plan anual del oficial', 'Informes de debida diligencia'],
                'faqs' => [
                    ['¿Mi empresa está obligada a tener un sistema de prevención?', 'Depende de su actividad. Los sujetos obligados a informar a la UIF-Perú deben contar con un sistema de prevención. Además, cualquier persona jurídica puede atenuar o eximir su responsabilidad bajo la Ley 30424 si tiene un modelo de prevención adecuado. En el diagnóstico lo determinamos para su caso.'],
                    ['¿Cuánto toma implementarlo?', 'Depende del tamaño de la organización y de su punto de partida. Después del diagnóstico entregamos un cronograma con fechas concretas.'],
                    ['¿Qué pasa con el oficial de cumplimiento?', 'Le asesoramos en su designación y en el plan anual de trabajo, y evaluamos la alternativa que mejor se ajusta a la normativa de su sector.'],
                ],
            ],
            'congelamiento-de-fondos' => [
                'name' => 'Congelamiento Administrativo de Fondos',
                'short' => 'Congelamiento de fondos (CAF)',
                'icon' => 'snow',
                'card' => 'Asesoría y defensa cuando la UIF dispone el congelamiento de fondos.',
                'includes' => ['Análisis de la medida y su base legal (Ley 27693)', 'Acreditación del origen y la licitud de los fondos', 'Atención de requerimientos y oficios de la UIF', 'Estrategia coordinada con la defensa penal'],
                'cta' => 'Evaluar mi caso',
                'situation' => 'Congelaron mis fondos o me notificó la UIF',
                'hero_title' => 'Sus fondos fueron congelados. Actuemos con orden.',
                'hero_sub' => 'Un congelamiento exige respuestas rápidas y bien documentadas. Revisamos la medida, reconstruimos el origen de los fondos y coordinamos cada paso con la estrategia penal.',
                'tool_title' => 'Evalúe su caso',
                'tool_sub' => 'Cuatro preguntas para ordenar la situación y saber qué hacer primero.',
                'steps' => [
                    ['Lectura de la medida', 'Analizamos la resolución, su base legal en la Ley 27693 y lo que exige de usted.'],
                    ['Primeras acciones', 'Le indicamos qué conservar, qué no declarar sin asesoría y qué documentos reunir.'],
                    ['Origen de los fondos', 'Reconstruimos y acreditamos la procedencia y la licitud de los fondos con soporte documental.'],
                    ['Requerimientos y oficios', 'Preparamos y presentamos las respuestas a la UIF y a las entidades involucradas.'],
                    ['Estrategia penal', 'Coordinamos la defensa ante una eventual investigación fiscal desde el primer día.'],
                ],
                'deliverables' => ['Informe sobre la medida', 'Expediente de origen de fondos', 'Respuestas a requerimientos', 'Plan de defensa coordinado'],
                'faqs' => [
                    ['¿Qué debo hacer primero?', 'Conserve toda notificación o comunicación del banco o de la UIF, evite dar explicaciones informales y contáctenos para revisar la medida con el documento a la vista.'],
                    ['¿Puedo seguir usando mis otras cuentas?', 'Depende del alcance de la medida. Lo revisamos con la resolución en la mano antes de que realice cualquier movimiento.'],
                    ['¿Necesito también un abogado penalista?', 'Con frecuencia el congelamiento se relaciona con una investigación penal. Por eso trabajamos ambas líneas de forma coordinada desde el inicio.'],
                ],
            ],
            'criptoactivos-psav' => [
                'name' => 'Criptoactivos y PSAV',
                'icon' => 'coin',
                'card' => 'Gestión de riesgos LA/FT para quienes operan con activos virtuales.',
                'includes' => ['Evaluación de riesgos y manual SPLAFT para PSAV', 'Registro y obligaciones ante la UIF', 'Debida diligencia y trazabilidad de operaciones', 'Opinión legal sobre estructuras y stablecoins'],
                'cta' => 'Solicitar propuesta',
                'situation' => 'Opero con criptoactivos o soy un PSAV',
                'hero_title' => 'Cumplimiento a la medida de un proveedor de activos virtuales.',
                'hero_sub' => 'Exchanges, billeteras, custodios, mesas OTC y plataformas P2P enfrentan exigencias propias. Construimos un programa que su operación puede sostener y que un supervisor puede verificar.',
                'tool_title' => 'Arme su propuesta',
                'tool_sub' => 'Indique qué hace su plataforma y le mostramos el programa que necesita, módulo por módulo.',
                'steps' => [
                    ['Mapa de la operación', 'Entendemos sus productos, flujos de fondos, clientes y países donde opera.'],
                    ['Evaluación de riesgos', 'Medimos los riesgos LA/FT de cada servicio, canal y tipo de cliente.'],
                    ['Manual y políticas', 'Manual SPLAFT para PSAV, políticas de conocimiento del cliente y de monitoreo.'],
                    ['Registro y obligaciones', 'Acompañamos la inscripción que corresponda y el cumplimiento de sus obligaciones ante la UIF.'],
                    ['Trazabilidad', 'Definimos el monitoreo de operaciones, el análisis on-chain y la aplicación de la regla de viaje.'],
                    ['Opinión legal', 'Revisamos estructuras, tokens y el uso de stablecoins antes de que salgan al mercado.'],
                ],
                'deliverables' => ['Evaluación de riesgos PSAV', 'Manual SPLAFT para PSAV', 'Política KYC y de monitoreo', 'Procedimiento de reporte', 'Opinión legal', 'Capacitación del equipo'],
                'faqs' => [
                    ['¿Qué es un PSAV?', 'Un proveedor de servicios de activos virtuales: quien, como negocio, intercambia activos virtuales por dinero u otros activos virtuales, los transfiere, los custodia o participa en su emisión, en línea con la definición del GAFI.'],
                    ['¿Conviene hacerlo antes de lanzar?', 'Sí. Diseñar los controles antes de operar evita rehacer procesos y facilita la relación con bancos, socios e inversionistas.'],
                    ['¿Trabajan con stablecoins?', 'Sí. Emitimos opinión legal sobre estructuras que usan stablecoins y sobre los controles que su uso exige.'],
                ],
            ],
            'asesoria-preventiva' => [
                'name' => 'Asesoría Preventiva',
                'icon' => 'doc',
                'card' => 'Opinión legal antes de decidir, no después del problema.',
                'includes' => ['Opinión previa sobre operaciones sensibles', 'Cláusulas anticorrupción y LA/FT en contratos', 'Mapa de contingencias penales y regulatorias', 'Respuesta a requerimientos de autoridades'],
                'cta' => 'Consultar',
                'situation' => 'Estoy por firmar o decidir algo sensible',
                'hero_title' => 'Antes de firmar, una segunda mirada.',
                'hero_sub' => 'Revisamos operaciones, contratos y requerimientos con criterio penal y regulatorio, para que la decisión se tome con la información completa.',
                'tool_title' => '¿Qué decisión tiene por delante?',
                'tool_sub' => 'Elija la situación y le mostramos qué revisaríamos y qué recibiría.',
                'steps' => [
                    ['Nos cuenta la decisión', 'Una primera conversación para entender la operación, los plazos y lo que está en juego.'],
                    ['Revisión documental', 'Analizamos contratos, contrapartes, flujos de pago y comunicaciones relevantes.'],
                    ['Mapa de contingencias', 'Identificamos los riesgos penales y regulatorios y su probabilidad.'],
                    ['Opinión y recomendaciones', 'Le entregamos una opinión escrita con ajustes concretos y cláusulas sugeridas.'],
                    ['Acompañamiento', 'Si la decisión avanza, seguimos a su lado en la negociación o ante la autoridad.'],
                ],
                'deliverables' => ['Opinión legal escrita', 'Cláusulas anticorrupción y LA/FT', 'Mapa de contingencias', 'Proyecto de respuesta a la autoridad'],
                'faqs' => [
                    ['¿Cuándo conviene consultar?', 'Antes de cerrar la operación o de responder a la autoridad: es el momento en que todavía se pueden ajustar condiciones, plazos y contenidos.'],
                    ['¿Entregan algo por escrito?', 'Sí. La opinión se entrega por escrito, con los riesgos identificados y las medidas recomendadas.'],
                    ['¿Atienden urgencias?', 'Sí. Indíquenos el plazo con el que cuenta y priorizamos la revisión.'],
                ],
            ],
            'defensa-penal-economica' => [
                'name' => 'Defensa Penal Económica',
                'icon' => 'scale',
                'card' => 'Defensa técnica de personas naturales y jurídicas.',
                'includes' => ['Lavado de activos y extinción de dominio', 'Delitos contra la administración pública', 'Responsabilidad de personas jurídicas', 'Investigación fiscal y juicio oral'],
                'cta' => 'Evaluar mi caso',
                'situation' => 'Hay una investigación fiscal o me citaron',
                'hero_title' => 'Defensa penal que entiende de números.',
                'hero_sub' => 'Los casos de lavado de activos, corrupción o responsabilidad de la empresa se defienden con prueba técnica y estrategia desde la primera citación.',
                'tool_title' => 'Ubique su caso en el proceso',
                'tool_sub' => 'Elija la materia y la etapa en la que se encuentra. Le mostramos qué ocurre en ella y cómo actuamos.',
                'steps' => [
                    ['Evaluación del caso', 'Revisamos la carpeta, las imputaciones y los plazos que corren.'],
                    ['Estrategia', 'Definimos la teoría del caso y las prioridades de la defensa.'],
                    ['Prueba técnica', 'Peritajes contables y financieros que explican el origen y el destino del dinero.'],
                    ['Defensa en cada etapa', 'Diligencias preliminares, investigación preparatoria, etapa intermedia y juicio oral.'],
                    ['Medidas y recursos', 'Oposición a medidas sobre bienes y personas, apelación y casación.'],
                ],
                'deliverables' => ['Informe de evaluación', 'Teoría del caso', 'Pericia de parte', 'Escritos y recursos'],
                'faqs' => [
                    ['¿Debo acudir a una citación fiscal sin abogado?', 'No es recomendable. Toda persona tiene derecho a ser asistida por un abogado desde la primera diligencia.'],
                    ['¿Defienden a empresas?', 'Sí. Representamos a personas jurídicas en procesos donde se les atribuye responsabilidad, incluidos los de la Ley 30424.'],
                    ['¿Qué es la extinción de dominio?', 'Es un proceso autónomo sobre bienes de presunto origen o destino ilícito, distinto del proceso penal contra la persona. Exige una defensa propia sobre la licitud de los bienes.'],
                ],
            ],
            'inmobiliario-notarial' => [
                'name' => 'Compliance Inmobiliario y Notarial',
                'icon' => 'house',
                'card' => 'Seguridad jurídica y prevención en operaciones sobre inmuebles.',
                'includes' => ['Due diligence y saneamiento técnico-legal', 'SPLAFT para inmobiliarias y agentes', 'Manual SPLAFT y reporte de operaciones sospechosas para notarías'],
                'cta' => 'Inmobiliario',
                'cta2' => 'Notarial',
                'situation' => 'Voy a comprar o vender un inmueble, o tengo una notaría',
                'hero_title' => 'Inmuebles sin sorpresas. Notarías preparadas.',
                'hero_sub' => 'Revisamos la propiedad, a las partes y el origen de los fondos antes de la firma, y ayudamos a inmobiliarias, agentes y notarías a cumplir como sujetos obligados.',
                'tool_title' => 'Simule su caso',
                'tool_sub' => 'Elija si su caso es una operación inmobiliaria o una notaría.',
                'steps' => [
                    ['Estudio de títulos', 'Revisamos la cadena de propiedad y la situación registral en SUNARP.'],
                    ['Cargas y saneamiento', 'Detectamos cargas, gravámenes y observaciones, y proponemos cómo sanearlas.'],
                    ['Las partes', 'Identificamos a compradores, vendedores y beneficiarios finales.'],
                    ['Origen de los fondos', 'Verificamos la procedencia del dinero y la forma de pago.'],
                    ['Firma y registro', 'Acompañamos la firma y la inscripción hasta su culminación.'],
                ],
                'deliverables' => ['Informe de due diligence', 'Plan de saneamiento', 'Manual SPLAFT inmobiliario', 'Manual SPLAFT notarial', 'Procedimiento de ROS'],
                'faqs' => [
                    ['¿Qué es el saneamiento técnico-legal?', 'Dejar el inmueble en condiciones de transferirse sin observaciones: títulos, linderos, áreas, cargas e inscripción registral en orden.'],
                    ['¿Las inmobiliarias deben tener un sistema de prevención?', 'En términos generales, quienes se dedican a la compraventa o intermediación inmobiliaria son sujetos obligados a informar a la UIF y deben contar con un sistema de prevención. Lo confirmamos para su actividad concreta.'],
                    ['¿Y las notarías?', 'Las notarías también son sujetos obligados: necesitan un manual, un registro de operaciones y un procedimiento para reportar operaciones sospechosas.'],
                ],
            ],
        ];
    }

    public static function find(string $slug): ?array
    {
        $all = static::all();

        return isset($all[$slug]) ? ['slug' => $slug] + $all[$slug] : null;
    }

    public static function whatsapp(string $text): string
    {
        return 'https://wa.me/'.static::WHATSAPP.'?text='.rawurlencode($text);
    }
}
