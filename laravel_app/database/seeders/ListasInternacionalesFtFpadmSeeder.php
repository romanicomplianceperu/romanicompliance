<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ListasInternacionalesFtFpadmSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::where('email', 'denis@romanicompliance.com')->first();

        $coverPath = 'courses/covers/listas-internacionales-ft-fpadm.svg';
        Storage::disk('public')->put($coverPath, $this->svgCover());

        $category = Category::firstOrCreate(
            ['slug' => 'prevencion-laft'],
            ['name' => 'Prevención LA/FT', 'description' => 'Capacitaciones sobre el sistema de prevención de lavado de activos y financiamiento del terrorismo.']
        );

        $course = Course::updateOrCreate(
            ['slug' => 'listas-internacionales-ft-fpadm'],
            [
                'category_id' => $category->id,
                'created_by' => $instructor?->id,
                'instructor_id' => $instructor?->id,
                'instructor_name' => 'Denis Gabriel Romani Seminario',
                'title' => 'Listas Internacionales y FPADM: Identificación, Coincidencias y Congelamiento de Activos',
                'description' => 'Curso práctico e interactivo sobre identificación, coincidencias y congelamiento de activos frente a listas internacionales: régimen CSNU 1267/1989/2253, Resolución 1373, financiamiento de la proliferación de armas de destrucción masiva (FPADM), Corea del Norte e Irán, OFAC/SDN, jurisdicciones GAFI, y el procedimiento de escalamiento frente a una coincidencia.',
                'cover_image' => $coverPath,
                'duration_minutes' => 80,
                'is_published' => true,
                'certificate_type' => 'opcional',
                'certificate_price' => 50.00,
            ]
        );

        $course->modules->each(fn ($module) => $module->lessons()->delete());
        $course->modules()->delete();
        $course->exam()->delete();

        // ---------------------------------------------------------------
        // Módulo 1 — Personalización + ¿Por qué revisamos listas?
        // ---------------------------------------------------------------
        $porQueSlide = [
            'intro' => 'Antes de aprender a manejar una coincidencia, hay que entender por qué el sistema de prevención exige revisar listas en cada relación comercial.',
            'slides' => [
                [
                    'heading' => 'Una obligación, no una opción',
                    'text' => 'Todo sujeto obligado debe verificar a sus clientes, beneficiarios finales, proveedores y contrapartes contra las listas relevantes para el Sistema de Prevención del Lavado de Activos y del Financiamiento del Terrorismo, antes y durante toda la relación comercial.',
                    'highlight' => ['sujeto', 'obligado', 'beneficiarios', 'finales'],
                ],
                [
                    'heading' => 'Un riesgo con un reloj distinto',
                    'text' => 'El screening de listas responde a un riesgo particular: el financiamiento del terrorismo y el financiamiento de la proliferación de armas de destrucción masiva, donde la oportunidad de actuar a tiempo puede ser más corta que en otros delitos.',
                    'highlight' => ['financiamiento', 'terrorismo', 'proliferación'],
                    'citation' => ['label' => 'Res. SBS N.º 3862-2016', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos', 'note' => 'Reglamento de gestión de riesgos de LA/FT que exige la revisión de listas como parte de la debida diligencia del cliente.'],
                ],
                [
                    'heading' => 'Lo que deberías poder responder al terminar',
                    'text' => 'Al final de este curso deberías distinguir una coincidencia nominal de una identidad confirmada, saber qué lista exige qué actuación, y saber exactamente a quién escalar un caso sin alertar al cliente.',
                    'highlight' => ['coincidencia', 'identidad', 'confirmada', 'escalar'],
                ],
            ],
            'sources' => [
                ['label' => 'Ley N.º 27693 y modificatorias', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos', 'desc' => 'Crea y regula la Unidad de Inteligencia Financiera del Perú (UIF-Perú).'],
                ['label' => 'D.S. N.º 020-2017-JUS y modificatorias', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos', 'desc' => 'Reglamento de la Ley que crea la UIF-Perú, en lo relativo al régimen de listas y comunicación de coincidencias.'],
                ['label' => 'Res. SBS N.º 3862-2016 y modificatorias', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos', 'desc' => 'Reglamento de gestión de riesgos de LA/FT aplicable a los sujetos obligados bajo su ámbito.'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 2 — Mapa de listas internacionales
        // ---------------------------------------------------------------
        $mapaListas = [
            'intro' => 'Existen 4 fuentes indispensables que todo sujeto obligado debe dominar. A ellas se suman factores de riesgo complementarios, que no son designaciones de sanciones por sí solos.',
            'cards' => [
                ['icon' => '1️⃣', 'tag' => '1 DE 4 · INDISPENSABLE', 'color' => 'red', 'title' => 'CSNU — Terrorismo (Régimen 1267/1989/2253)', 'body' => 'Lista de sanciones del Consejo de Seguridad de la ONU sobre personas y entidades asociadas a ISIL (Da\'esh) y Al-Qaida. Genera obligación de congelamiento cuando existe una designación vigente aplicable.'],
                ['icon' => '2️⃣', 'tag' => '2 DE 4 · INDISPENSABLE', 'color' => 'red', 'title' => 'CSNU — FPADM (Corea del Norte e Irán)', 'body' => 'Sanciones del Consejo de Seguridad vinculadas al financiamiento de la proliferación de armas de destrucción masiva (Resolución 1718 y sucesivas; régimen aplicable a Irán).'],
                ['icon' => '3️⃣', 'tag' => '3 DE 4 · INDISPENSABLE', 'color' => 'gold', 'title' => 'OFAC / SDN (Departamento del Tesoro de EE. UU.)', 'body' => 'Lista de Nacionales Especialmente Designados. Es una fuente de interés que todo sujeto obligado debe verificar, aunque jurídicamente no equivale a una designación vinculante del CSNU sobre Perú.'],
                ['icon' => '4️⃣', 'tag' => '4 DE 4 · INDISPENSABLE', 'color' => 'gold', 'title' => 'Listas de interés de la SBS / UIF-Perú', 'body' => 'Listas y comunicaciones adicionales que la SBS/UIF-Perú identifica como relevantes para el sistema de prevención, complementarias a las tres anteriores.'],
                ['icon' => '🌐', 'tag' => 'FACTOR DE RIESGO', 'color' => 'ink', 'title' => 'GAFI', 'body' => 'Identifica países, no personas: jurisdicciones de alto riesgo o bajo monitoreo reforzado. Es un factor de riesgo que exige mayor análisis, no una designación individual.'],
                ['icon' => '🏛️', 'tag' => 'FACTOR DE RIESGO', 'color' => 'ink', 'title' => 'PEP', 'body' => 'Persona Expuesta Políticamente: no es una lista de sanciones, es una categoría de cliente que exige debida diligencia reforzada.'],
            ],
            'sources' => [
                ['label' => 'Comité 1267/1989/2253 (ISIL/Da\'esh y Al-Qaida)', 'url' => 'https://www.un.org/securitycouncil/es/sanctions/1267', 'desc' => 'Página oficial del comité de sanciones del Consejo de Seguridad de la ONU.'],
                ['label' => 'Comité 1718 (Corea del Norte)', 'url' => 'https://www.un.org/securitycouncil/es/sanctions/1718', 'desc' => 'Página oficial del comité de sanciones sobre el programa nuclear y de misiles de Corea del Norte.'],
                ['label' => 'OFAC — Sanctions List Search', 'url' => 'https://sanctionssearch.ofac.treas.gov/', 'desc' => 'Buscador oficial de la lista SDN del Departamento del Tesoro de EE. UU.'],
                ['label' => 'GAFI — Listas de jurisdicciones', 'url' => 'https://www.fatf-gafi.org/en/countries/black-and-grey-lists.html', 'desc' => 'Listado oficial y actualizado de jurisdicciones de alto riesgo y bajo monitoreo reforzado.'],
                ['label' => 'SBS / UIF-Perú', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos', 'desc' => 'Portal oficial de prevención del lavado de activos y financiamiento del terrorismo de la SBS.'],
            ],
        ];

        $herramientaListas = [
            'intro' => 'Estos son los buscadores oficiales reales — los mismos que usa un Oficial de Cumplimiento en el Perú. Aquí no simulamos nada: úsalos para practicar navegando el contenido real de cada lista.',
            'tools' => [
                ['icon' => '🇵🇪', 'title' => 'SBS — Revisión de Listas de Interés', 'desc' => 'Portal oficial donde la SBS/UIF-Perú centraliza y actualiza las listas de interés: CSNU (terrorismo y FPADM), OFAC, Unión Europea, GAFI y funciones PEP.', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos/listas-de-interes', 'color' => 'ink'],
                ['icon' => '🇺🇳', 'title' => 'Lista Consolidada del CSNU', 'desc' => 'Busca directamente en la lista consolidada de sanciones del Consejo de Seguridad de las Naciones Unidas (ISIL/Da\'esh, Al-Qaida, Talibanes, Corea del Norte, Irán y demás regímenes vigentes).', 'url' => 'https://www.un.org/securitycouncil/content/un-sc-consolidated-list', 'color' => 'red'],
                ['icon' => '🇺🇸', 'title' => 'OFAC Sanctions List Search', 'desc' => 'Buscador oficial del Departamento del Tesoro de EE. UU. para consultar la lista SDN ("lista Clinton") y otras listas de sanciones administradas por OFAC.', 'url' => 'https://sanctionssearch.ofac.treas.gov/', 'color' => 'gold'],
                ['icon' => '🇪🇺', 'title' => 'Lista de Terroristas de la Unión Europea', 'desc' => 'Lista de personas y entidades vinculadas a actos terroristas, adoptada por la UE en aplicación de la Resolución 1373 del CSNU. Se revisa cada seis meses.', 'url' => 'https://eur-lex.europa.eu/legal-content/es/TXT/HTML/?uri=CELEX:32019D1341&from=en', 'color' => 'gold'],
                ['icon' => '🌐', 'title' => 'Listas del GAFI/FATF', 'desc' => 'Listado oficial y actualizado de jurisdicciones de alto riesgo (Call for Action) y bajo monitoreo reforzado (Increased Monitoring) — la SBS las llama "países y territorios no cooperantes".', 'url' => 'https://www.fatf-gafi.org/en/countries/black-and-grey-lists.html', 'color' => 'ink'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 3 — Régimen 1267 vs Resolución 1373 (drag & drop)
        // ---------------------------------------------------------------
        $regimen1267vs1373 = [
            'intro' => 'Arrastra cada característica hacia el régimen del Consejo de Seguridad al que corresponde. No son lo mismo.',
            'categories' => [
                ['id' => 'r1267', 'label' => 'Régimen 1267 / 1989 / 2253'],
                ['id' => 'r1373', 'label' => 'Resolución 1373'],
            ],
            'items' => [
                ['id' => 'c1', 'label' => 'Lista consolidada de sanciones sobre ISIL (Da\'esh) y Al-Qaida', 'category' => 'r1267', 'hint' => 'Es la lista específica administrada por el comité de sanciones respectivo.'],
                ['id' => 'c2', 'label' => 'Comité de sanciones que administra una lista específica de personas y entidades', 'category' => 'r1267', 'hint' => 'El régimen 1267 se apoya en un comité con una lista propia.'],
                ['id' => 'c3', 'label' => 'Genera obligación de congelamiento cuando existe una designación vigente aplicable', 'category' => 'r1267', 'hint' => 'La designación en esta lista es la que activa el congelamiento.'],
                ['id' => 'c4', 'label' => 'No es, en sí misma, una lista única consolidada a nivel mundial', 'category' => 'r1373', 'hint' => 'A diferencia del 1267, no existe una "lista 1373" equivalente y centralizada.'],
                ['id' => 'c5', 'label' => 'Obliga a los Estados a criminalizar y combatir el financiamiento del terrorismo', 'category' => 'r1373', 'hint' => 'Es una resolución de obligaciones generales, no de designación directa de personas.'],
                ['id' => 'c6', 'label' => 'Habilita mecanismos de designación propios de cada Estado', 'category' => 'r1373', 'hint' => 'Cada país puede implementar su propio listado bajo este mandato.'],
                ['id' => 'c7', 'label' => 'Cada país puede tener su propio listado de designaciones bajo este mecanismo', 'category' => 'r1373', 'hint' => 'Por eso no hay una lista única mundial equivalente a la 1267.'],
                ['id' => 'c8', 'label' => 'Fue adoptada en 1999 y ha sido desarrollada por resoluciones sucesivas hasta hoy', 'category' => 'r1267', 'hint' => 'El régimen 1267 nació en 1999 y se ha actualizado con la 1989, la 2253 y sucesivas.'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 4 — FPADM: Corea del Norte e Irán
        // ---------------------------------------------------------------
        $fpadmSlide = [
            'intro' => 'La proliferación no siempre se ve como algo militar: muchas veces se disfraza de comercio ordinario.',
            'slides' => [
                [
                    'heading' => '¿Qué es la proliferación?',
                    'text' => 'La proliferación es la difusión de armas nucleares, químicas o biológicas, y de los medios para fabricarlas o transportarlas, hacia actores no autorizados. El financiamiento de esa proliferación (FPADM) es el conjunto de fondos y servicios financieros que la hacen posible.',
                    'highlight' => ['proliferación', 'FPADM'],
                ],
                [
                    'heading' => 'El camino del dinero',
                    'text' => 'Muchas operaciones de FPADM aparentan ser comercio ordinario: fondos que pasan por una empresa intermediaria para financiar la compra de componentes que, al final de la cadena, alimentan un programa prohibido.',
                    'highlight' => ['empresa', 'intermediaria', 'componentes'],
                ],
                [
                    'heading' => 'Corea del Norte: Resolución 1718 y sucesivas',
                    'text' => 'Desde 2006, el Consejo de Seguridad ha adoptado la Resolución 1718 y numerosas resoluciones sucesivas que sancionan a Corea del Norte por sus programas nuclear y de misiles balísticos, incluyendo designaciones de personas, entidades y buques.',
                    'highlight' => ['Resolución 1718', 'Corea del Norte'],
                    'citation' => ['label' => 'Resolución 1718 (2006) y sucesivas', 'url' => 'https://www.un.org/securitycouncil/es/sanctions/1718', 'note' => 'Régimen de sanciones del CSNU sobre el programa nuclear y de misiles balísticos de Corea del Norte.'],
                ],
                [
                    'heading' => 'Irán: una evolución que hay que conocer',
                    'text' => 'El régimen aplicable a Irán no ha sido estático. La Resolución 1737 de 2006 creó el comité de sanciones original; la Resolución 2231 de 2015 endosó el acuerdo nuclear y estableció un esquema de levantamiento progresivo de sanciones con una cláusula de reversión.',
                    'highlight' => ['Resolución 1737', 'Resolución 2231'],
                ],
                [
                    'heading' => 'El "snapback" de 2025',
                    'text' => 'En agosto de 2025, ante el incumplimiento del acuerdo nuclear, un grupo de Estados activó el mecanismo de reversión ("snapback") previsto en la Resolución 2231. Como consecuencia, a fines de septiembre de 2025 Naciones Unidas restableció las resoluciones de sanciones anteriores sobre Irán, y el comité de sanciones asociado al régimen de la Resolución 1737 volvió a estar operativo.',
                    'highlight' => ['snapback', 'restableció', '1737'],
                    'citation' => ['label' => 'Resolución 2231 (2015) y mecanismo de "snapback" (2025)', 'url' => 'https://www.un.org/securitycouncil/es/sanctions/information', 'note' => 'Tras la activación del mecanismo de reversión en agosto de 2025, el Consejo de Seguridad restableció las resoluciones de sanciones previas sobre Irán a partir de septiembre de 2025.'],
                ],
                [
                    'heading' => 'Qué significa esto para tu trabajo',
                    'text' => 'No necesitas memorizar cada resolución: necesitas saber que el régimen sobre Irán está vigente y activo, y que cualquier coincidencia con una persona o entidad iraní o norcoreana designada exige la misma disciplina de verificación y escalamiento que cualquier otra alerta del CSNU.',
                    'highlight' => ['vigente', 'escalamiento'],
                ],
            ],
            'sources' => [
                ['label' => 'Resolución 1718 (2006) y sucesivas', 'url' => 'https://www.un.org/securitycouncil/es/sanctions/1718', 'desc' => 'Régimen de sanciones del CSNU sobre Corea del Norte.'],
                ['label' => 'Comité 1737 sobre Irán', 'url' => 'https://www.un.org/securitycouncil/es/sanctions/information', 'desc' => 'Creó el comité de sanciones original sobre el programa nuclear de Irán.'],
                ['label' => 'Resolución 2231 (2015)', 'url' => 'https://www.un.org/securitycouncil/es/sanctions/information', 'desc' => 'Endosó el acuerdo nuclear (JCPOA) y estableció el esquema de levantamiento progresivo de sanciones, con cláusula de reversión ("snapback").'],
                ['label' => 'Restablecimiento de sanciones sobre Irán (2025)', 'url' => 'https://www.un.org/securitycouncil/es/sanctions/information', 'desc' => 'Tras el procedimiento de "snapback" activado en agosto de 2025, el Consejo de Seguridad restableció resoluciones de sanciones previas a partir de septiembre de 2025.'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 5 — OFAC y SDN
        // ---------------------------------------------------------------
        $ofacCards = [
            'intro' => '¿OFAC es lo mismo que Naciones Unidas? No. Entender la diferencia evita errores graves de calificación.',
            'cards' => [
                ['icon' => '🏦', 'tag' => 'QUÉ ES', 'color' => 'ink', 'title' => 'Departamento del Tesoro de EE. UU.', 'body' => 'OFAC (Office of Foreign Assets Control) administra sanciones económicas de Estados Unidos, no del Consejo de Seguridad de la ONU.'],
                ['icon' => '📜', 'tag' => 'SU LISTA PRINCIPAL', 'color' => 'gold', 'title' => 'SDN List', 'body' => 'La lista de Nacionales Especialmente Designados incluye personas y entidades vinculadas a terrorismo, narcotráfico, proliferación, crimen organizado y regímenes sancionados por EE. UU.'],
                ['icon' => '⚠️', 'tag' => 'NO CONFUNDIR', 'color' => 'red', 'title' => 'OFAC ≠ CSNU', 'body' => 'Una coincidencia OFAC no activa, por sí sola, el mismo mecanismo jurídico previsto para una designación vinculante del CSNU en el sujeto obligado peruano. Es una fuente de interés que exige verificar y analizar.'],
                ['icon' => '✅', 'tag' => 'QUÉ HACER', 'color' => 'green', 'title' => 'Detectar → Verificar → Escalar', 'body' => 'Detectar la coincidencia, verificar los datos identificatorios, escalar al Oficial de Cumplimiento, evaluar el riesgo conforme a la política interna y documentar la decisión.'],
            ],
            'sources' => [
                ['label' => 'OFAC — Sanctions List Search', 'url' => 'https://sanctionssearch.ofac.treas.gov/', 'desc' => 'Buscador oficial de la lista SDN del Departamento del Tesoro de EE. UU.'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 6 — GAFI
        // ---------------------------------------------------------------
        $gafiSlide = [
            'intro' => 'El GAFI no sanciona personas: sanciona, en la práctica, la reputación de países enteros frente al sistema financiero internacional.',
            'slides' => [
                [
                    'heading' => 'País ≠ persona sancionada',
                    'text' => 'El GAFI (Grupo de Acción Financiera Internacional) no designa personas: identifica jurisdicciones con deficiencias estratégicas en sus sistemas de prevención de LA/FT y del financiamiento de la proliferación.',
                    'highlight' => ['GAFI', 'jurisdicciones'],
                ],
                [
                    'heading' => 'Dos listas, dos nombres técnicos',
                    'text' => 'La prensa suele hablar de "lista negra" y "lista gris", pero los nombres técnicos son High-Risk Jurisdictions subject to a Call for Action y Jurisdictions under Increased Monitoring.',
                    'highlight' => ['High-Risk Jurisdictions', 'Increased Monitoring'],
                ],
                [
                    'heading' => '¿Se congela automáticamente?',
                    'text' => 'No. Que un cliente proceda de un país bajo monitoreo reforzado es un factor de riesgo que exige mayor análisis y, cuando corresponda, debida diligencia reforzada — pero no equivale por sí solo a una designación de sanciones ni genera congelamiento automático.',
                    'highlight' => ['factor de riesgo', 'no equivale'],
                    'citation' => ['label' => 'Res. SBS N.º 789-2018', 'note' => 'Exige aplicar medidas reforzadas frente a clientes o contrapartes vinculados a países identificados por el GAFI, en función del riesgo.'],
                ],
            ],
            'sources' => [
                ['label' => 'Listados públicos del GAFI/FATF', 'url' => 'https://www.fatf-gafi.org/en/countries/black-and-grey-lists.html', 'desc' => 'High-Risk Jurisdictions subject to a Call for Action y Jurisdictions under Increased Monitoring, actualizados periódicamente por el GAFI.'],
                ['label' => 'Res. SBS N.º 789-2018 y modificatorias', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos', 'desc' => 'Prevención del LA/FT aplicable a los sujetos obligados bajo supervisión de la UIF-Perú, incluyendo el tratamiento de jurisdicciones de riesgo.'],
            ],
        ];

        $gafiMap = [
            'intro' => 'Haz clic en cada marcador del mapa para ver el estatus de esa jurisdicción ante el GAFI.',
            'countries' => [
                ['name' => 'Corea del Norte', 'status' => 'red', 'x' => 760, 'y' => 108, 'note' => 'En la lista de jurisdicciones de alto riesgo desde hace más de una década, por deficiencias estratégicas graves y persistentes.'],
                ['name' => 'Myanmar', 'status' => 'red', 'x' => 700, 'y' => 205, 'note' => 'Incorporada a la lista de alto riesgo por deficiencias estratégicas en su sistema de prevención de LA/FT.'],
                ['name' => 'Irán', 'status' => 'red', 'x' => 560, 'y' => 158, 'note' => 'En la lista de alto riesgo desde 2020, además del régimen de sanciones específico del CSNU explicado en el Módulo 4.'],
                ['name' => 'Siria', 'status' => 'amber', 'x' => 528, 'y' => 142, 'note' => 'Bajo monitoreo reforzado del GAFI mientras implementa su plan de acción acordado.'],
                ['name' => 'Yemen', 'status' => 'amber', 'x' => 555, 'y' => 188, 'note' => 'Bajo monitoreo reforzado del GAFI mientras implementa su plan de acción acordado.'],
                ['name' => 'Sudán del Sur', 'status' => 'amber', 'x' => 500, 'y' => 218, 'note' => 'Bajo monitoreo reforzado del GAFI mientras implementa su plan de acción acordado.'],
                ['name' => 'Rep. Dem. del Congo', 'status' => 'amber', 'x' => 478, 'y' => 258, 'note' => 'Bajo monitoreo reforzado del GAFI mientras implementa su plan de acción acordado.'],
                ['name' => 'Nigeria', 'status' => 'amber', 'x' => 420, 'y' => 218, 'note' => 'Bajo monitoreo reforzado del GAFI mientras implementa su plan de acción acordado.'],
                ['name' => 'Haití', 'status' => 'amber', 'x' => 190, 'y' => 195, 'note' => 'Bajo monitoreo reforzado del GAFI mientras implementa su plan de acción acordado.'],
            ],
            'disclaimer' => 'Este mapa es ilustrativo del tipo de jurisdicciones que el GAFI clasifica en cada categoría. La lista vigente cambia varias veces al año — antes de tomar cualquier decisión, verifica siempre el listado oficial actualizado.',
            'officialUrl' => 'https://www.fatf-gafi.org/en/countries/black-and-grey-lists.html',
        ];

        // ---------------------------------------------------------------
        // Módulo 7 — Coincidencia real o falso positivo
        // ---------------------------------------------------------------
        $glosarioListas = [
            'intro' => 'Haz clic en cada término para ver su definición completa y qué otro concepto no debes confundir con él.',
            'terms' => [
                ['term' => 'Coincidencia potencial', 'icon' => '🔎', 'short' => 'Alerta inicial de screening', 'definition' => 'Resultado que arroja el sistema de screening cuando el nombre u otros datos de un cliente se asemejan a los de una persona o entidad incluida en una lista. Es solo un punto de partida para el análisis.', 'confuse' => 'Coincidencia confirmada: la coincidencia potencial todavía no demuestra que se trate de la misma persona.'],
                ['term' => 'Coincidencia confirmada', 'icon' => '✅', 'short' => 'Identidad verificada', 'definition' => 'Situación en la que, tras verificar datos identificatorios adicionales (fecha de nacimiento, documento, nacionalidad, alias), se concluye razonablemente que el cliente es la misma persona designada.', 'confuse' => 'Coincidencia potencial: toda coincidencia confirmada empezó como una alerta que debía verificarse.'],
                ['term' => 'Falso positivo', 'icon' => '⬜', 'short' => 'Alerta descartada', 'definition' => 'Coincidencia potencial que, tras la verificación, se determina que no corresponde a la persona designada. Debe documentarse con el sustento de la verificación realizada.', 'confuse' => 'Coincidencia confirmada: son los dos resultados posibles de analizar una misma alerta.'],
                ['term' => 'Tipping off', 'icon' => '🤐', 'short' => 'Revelación indebida', 'definition' => 'Dar a conocer al cliente, directa o indirectamente, que se está evaluando una coincidencia, un reporte o una investigación en curso. Debe evitarse durante todo el proceso de análisis.', 'confuse' => 'Comunicación normal con el cliente: informar sobre un proceso interno de validación no es lo mismo que revelar el motivo real de la alerta.'],
                ['term' => 'Debida diligencia reforzada', 'icon' => '🛡️', 'short' => 'Análisis ampliado', 'definition' => 'Conjunto de medidas adicionales de verificación y monitoreo que se aplican a clientes, productos o zonas de mayor riesgo, incluyendo coincidencias que no llegan a confirmarse pero tampoco se descartan de plano.', 'confuse' => 'Congelamiento: la debida diligencia reforzada es una medida de análisis, no de inmovilización de fondos.'],
                ['term' => 'Escalamiento', 'icon' => '📈', 'short' => 'Derivar el caso', 'definition' => 'Acción de trasladar de inmediato una alerta relevante al Oficial de Cumplimiento, siguiendo el procedimiento interno, para que decida el curso de acción correspondiente.', 'confuse' => 'Congelamiento: escalar es informar y derivar la decisión; congelar es una consecuencia posterior que aplica según el marco legal.'],
            ],
        ];

        $memoryListas = [
            'instructions' => 'Encuentra las parejas: cada concepto con su definición corta.',
            'pairs' => [
                ['a' => 'Coincidencia potencial', 'b' => 'Alerta inicial de screening', 'icon' => '🔎'],
                ['a' => 'Coincidencia confirmada', 'b' => 'Identidad verificada', 'icon' => '✅'],
                ['a' => 'Falso positivo', 'b' => 'Alerta descartada y documentada', 'icon' => '⬜'],
                ['a' => 'Tipping off', 'b' => 'Revelación indebida al cliente', 'icon' => '🤐'],
                ['a' => 'GAFI', 'b' => 'Identifica países, no personas', 'icon' => '🌐'],
                ['a' => 'OFAC', 'b' => 'Sanciones del Tesoro de EE. UU.', 'icon' => '🇺🇸'],
            ],
        ];

        $screeningSearch = [
            'intro' => 'Escribe un nombre y compáralo contra una base de práctica. Así se siente un sistema de screening real — y por qué una coincidencia de nombre nunca es, por sí sola, la respuesta final.',
            'disclaimer' => 'Esta es una base de datos de práctica con nombres ilustrativos (ficticios), no la lista oficial en tiempo real. Para una consulta real, usa los buscadores oficiales de la lección "Herramienta" del Módulo 2.',
            'examples' => ['Khalid Mansouri', 'Nadia Volkov', 'Juan Carlos Ramírez'],
            'dataset' => [
                ['name' => 'Khalid Ibrahim Al-Mansouri', 'aliases' => ['Khalid I. Mansouri', 'Abu Ibrahim'], 'list' => 'CSNU · Terrorismo (práctica)', 'note' => 'Registro ilustrativo para practicar el flujo de verificación.'],
                ['name' => 'Farrukh Tashkentov', 'aliases' => ['F. Tashkentov'], 'list' => 'CSNU · FPADM (práctica)', 'note' => 'Registro ilustrativo asociado a una empresa intermediaria ficticia.'],
                ['name' => 'Nadia Petrova Volkova', 'aliases' => ['Nadia Volkov', 'N. Petrova'], 'list' => 'OFAC · SDN (práctica)', 'note' => 'Registro ilustrativo para practicar el flujo de verificación.'],
                ['name' => 'Inversiones Al-Rashid E.I.R.L.', 'aliases' => ['Grupo Al-Rashid'], 'list' => 'CSNU · Terrorismo (práctica)', 'note' => 'Entidad ficticia — practica también el screening de personas jurídicas, no solo naturales.'],
                ['name' => 'TransGlobal Trading Company', 'aliases' => ['TransGlobal Trading Co.'], 'list' => 'CSNU · FPADM (práctica)', 'note' => 'Entidad ficticia usada como ejemplo de empresa pantalla en comercio internacional.'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 8 — Congelamiento administrativo y semáforo de consecuencias
        // ---------------------------------------------------------------
        $semaforoCards = [
            'intro' => 'Este semáforo resume el nivel de reacción esperado frente a distintos escenarios. No todas las coincidencias exigen lo mismo.',
            'cards' => [
                ['icon' => '🔴', 'tag' => 'ROJO', 'color' => 'red', 'title' => 'Escalamiento inmediato', 'body' => 'Coincidencia con una designación vigente aplicable del CSNU: se activa el procedimiento de congelamiento administrativo cuando jurídicamente corresponde, sin alertar al cliente.'],
                ['icon' => '🟠', 'tag' => 'NARANJA', 'color' => 'gold', 'title' => 'Análisis reforzado', 'body' => 'Coincidencias OFAC, PEP de alto riesgo o beneficiarios finales con antecedentes: exige debida diligencia reforzada y evaluación por el Oficial de Cumplimiento.'],
                ['icon' => '🟡', 'tag' => 'AMARILLO', 'color' => 'ink', 'title' => 'Verificación adicional', 'body' => 'Coincidencia parcial de nombre, cliente de país bajo monitoreo GAFI, o alerta de baja severidad: se verifica información adicional antes de decidir si se escala.'],
                ['icon' => '⚪', 'tag' => 'GRIS', 'color' => 'green', 'title' => 'Falso positivo documentado', 'body' => 'Tras la verificación, se concluye que no se trata de la misma persona. Se documenta la decisión y el sustento que la respalda.'],
            ],
        ];

        $congelamientoSlide = [
            'intro' => 'El congelamiento administrativo es una de las consecuencias más delicadas de todo el sistema: por eso la ley distribuye con precisión quién hace qué.',
            'slides' => [
                [
                    'heading' => 'No es una decisión de una sola persona',
                    'text' => 'El marco peruano distingue con claridad entre lo que corresponde al colaborador que detecta la alerta, lo que corresponde al Oficial de Cumplimiento que la evalúa, y lo que corresponde a la autoridad competente conforme al marco legal vigente.',
                    'highlight' => ['colaborador', 'Oficial de Cumplimiento', 'autoridad competente'],
                    'citation' => ['label' => 'Ley N.º 27693 y D.S. N.º 020-2017-JUS', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos/listas-de-interes', 'note' => 'Distribuyen las competencias del sujeto obligado, el Oficial de Cumplimiento y la UIF-Perú frente a las coincidencias con listas y el régimen de congelamiento.'],
                ],
                [
                    'heading' => 'La facultad expresa de la UIF-Perú',
                    'text' => 'La Ley N.º 30437 amplió las facultades de la UIF-Perú en la lucha contra el terrorismo: le corresponde disponer el congelamiento inmediato de los fondos u otros activos de las personas comprendidas en las listas del CSNU sobre terrorismo y sobre FPADM.',
                    'highlight' => ['Ley N.º 30437', 'congelamiento inmediato'],
                    'citation' => ['label' => 'Ley N.º 30437', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos/listas-de-interes', 'note' => 'Otorga a la UIF-Perú la facultad de disponer el congelamiento inmediato de fondos u otros activos vinculados a las listas del CSNU de terrorismo y de FPADM.'],
                ],
                [
                    'heading' => 'El colaborador detecta, no decide',
                    'text' => 'Tu responsabilidad como colaborador es detectar la coincidencia, verificar los datos disponibles y escalarla de inmediato, sin adelantar conclusiones ni comunicárselas al cliente.',
                    'highlight' => ['detecta', 'escalarla'],
                ],
                [
                    'heading' => 'Congelamiento, DDR y ROS no son lo mismo',
                    'text' => 'El congelamiento inmoviliza fondos u otros activos; la debida diligencia reforzada es un nivel de análisis más exigente; y el Reporte de Operación Sospechosa comunica a la UIF-Perú una operación cuyo análisis genera sospecha, aunque no exista una designación de listas de por medio.',
                    'highlight' => ['congelamiento', 'debida diligencia reforzada', 'ROS'],
                ],
            ],
            'sources' => [
                ['label' => 'Ley N.º 27693 y modificatorias', 'desc' => 'Marco general del sistema de prevención y de la UIF-Perú.'],
                ['label' => 'Ley N.º 30437', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos/listas-de-interes', 'desc' => 'Otorga a la UIF-Perú la facultad de disponer el congelamiento inmediato de fondos vinculados a las listas del CSNU de terrorismo y FPADM.'],
                ['label' => 'D.S. N.º 020-2017-JUS y modificatorias', 'desc' => 'Reglamento que desarrolla las competencias y el procedimiento frente a coincidencias y comunicación a la UIF-Perú.'],
                ['label' => 'Res. SBS N.º 3862-2016', 'url' => 'https://www.sbs.gob.pe/prevencion-de-lavado-activos/listas-de-interes', 'desc' => 'Regula los mecanismos y procedimientos para que la UIF-Perú congele administrativamente fondos vinculados al terrorismo y al FPADM.'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 9 — ¿Qué debe hacer el trabajador? (clasificar por actor)
        // ---------------------------------------------------------------
        $quienHaceQue = [
            'intro' => 'Arrastra cada actuación hacia quién es responsable de realizarla dentro del sujeto obligado.',
            'categories' => [
                ['id' => 'colaborador', 'label' => 'El colaborador'],
                ['id' => 'oficial', 'label' => 'El Oficial de Cumplimiento'],
                ['id' => 'uif', 'label' => 'Sujeto obligado / UIF-Perú'],
            ],
            'items' => [
                ['id' => 'a1', 'label' => 'Detectar la coincidencia y no ignorarla', 'category' => 'colaborador', 'hint' => 'Es el primer filtro humano del proceso.'],
                ['id' => 'a2', 'label' => 'Evitar revelar la alerta al cliente (no tipping off)', 'category' => 'colaborador', 'hint' => 'Aplica desde el primer momento de la detección.'],
                ['id' => 'a3', 'label' => 'Verificar los datos identificatorios disponibles', 'category' => 'colaborador', 'hint' => 'Antes de escalar, reúne la información que ya tienes a la mano.'],
                ['id' => 'a4', 'label' => 'Evaluar el nivel de coincidencia y decidir el curso de acción', 'category' => 'oficial', 'hint' => 'Es una decisión técnica que corresponde al Oficial de Cumplimiento.'],
                ['id' => 'a5', 'label' => 'Aplicar el procedimiento normativo correspondiente', 'category' => 'oficial', 'hint' => 'El Oficial de Cumplimiento activa el procedimiento interno aplicable.'],
                ['id' => 'a6', 'label' => 'Registrar la actuación y su sustento documental', 'category' => 'oficial', 'hint' => 'Toda decisión debe quedar documentada.'],
                ['id' => 'a7', 'label' => 'Ejecutar el congelamiento administrativo cuando jurídicamente corresponda', 'category' => 'uif', 'hint' => 'Esta actuación se enmarca en las competencias que fija la normativa vigente.'],
                ['id' => 'a8', 'label' => 'Recibir y evaluar el Reporte de Operación Sospechosa cuando corresponda', 'category' => 'uif', 'hint' => 'La UIF-Perú es la autoridad receptora del ROS.'],
            ],
        ];

        // ---------------------------------------------------------------
        // Módulo 10 — Casos prácticos por sector
        // ---------------------------------------------------------------
        $casosSectoriales = [
            'intro' => 'Un mismo principio, aplicado a distintos giros de negocio. Lee cada caso y piensa qué harías antes de seguir al siguiente módulo.',
            'cards' => [
                ['icon' => '📜', 'tag' => 'NOTARÍA', 'color' => 'ink', 'title' => 'Caso Notaría Rivera', 'sectorKey' => 'notaria', 'body' => 'Un cliente participa en la compraventa de un inmueble de S/ 780,000. Durante el screening, uno de los intervinientes presenta una coincidencia parcial de nombre con una persona incluida en una lista del CSNU. Se verifica y se escala sin firmar la escritura hasta resolver la alerta.'],
                ['icon' => '🎰', 'tag' => 'CASINO', 'color' => 'ink', 'title' => 'Caso Casino Golden Palace', 'sectorKey' => 'casino', 'body' => 'Un cliente frecuente compra S/ 48,000 en fichas y las canjea poco después sin haber jugado. El sistema genera además una alerta de screening por similitud de nombre. Se documenta la operación inusual y se verifica la alerta de forma independiente.'],
                ['icon' => '💳', 'tag' => 'PRÉSTAMOS', 'color' => 'ink', 'title' => 'Caso Financiera Crédito Express', 'sectorKey' => 'prestamos', 'body' => 'Un cliente solicita un crédito de S/ 120,000 y, poco después, un tercero no relacionado pretende cancelarlo de forma anticipada. Al revisar al beneficiario final de la empresa solicitante, aparece una coincidencia con una lista de interés que debe verificarse antes de aceptar el pago.'],
                ['icon' => '🪙', 'tag' => 'CRIPTOACTIVOS', 'color' => 'ink', 'title' => 'Caso AndeanCrypto Exchange', 'sectorKey' => 'cripto', 'body' => 'Un cliente recibe activos virtuales desde múltiples wallets. El screening de una de las contrapartes genera una alerta de coincidencia. Se congela temporalmente el retiro mientras el Oficial de Cumplimiento evalúa la operación, sin informar al cliente el motivo exacto de la demora.'],
                ['icon' => '💱', 'tag' => 'CASA DE CAMBIO', 'color' => 'ink', 'title' => 'Caso Cambios del Sur', 'sectorKey' => 'casas_cambio', 'body' => 'Un mismo domicilio realiza operaciones sucesivas de cambio de moneda a nombre de distintos titulares, uno de los cuales activa una coincidencia de nombre con una lista GAFI de interés. Se analiza el patrón en conjunto, no cada operación de forma aislada.'],
                ['icon' => '🏗️', 'tag' => 'INMOBILIARIA', 'color' => 'ink', 'title' => 'Caso Inversiones Costa Verde', 'sectorKey' => 'inmobiliaria', 'body' => 'Un proyecto inmobiliario recibe un pago inicial de un tercero distinto al comprador registrado en el contrato. Al verificar al beneficiario final de la empresa compradora, se detecta una coincidencia con una lista de interés que exige análisis antes de continuar.'],
            ],
        ];

        $modulesData = [
            ['title' => 'Módulo 1: ¿Por qué revisamos listas?', 'lessons' => [
                ['title' => '¿Por qué revisamos listas?', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'slide'] + $porQueSlide)],
            ]],
            ['title' => 'Módulo 2: Mapa de listas internacionales', 'lessons' => [
                ['title' => 'Mapa de listas internacionales', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'cards'] + $mapaListas)],
                ['title' => 'Herramienta: busca en las listas oficiales reales', 'type' => 'interactive', 'duration_minutes' => 5, 'content' => json_encode(['kind' => 'tool_links'] + $herramientaListas)],
            ]],
            ['title' => 'Módulo 3: Régimen 1267 y Resolución 1373', 'lessons' => [
                ['title' => 'Arrastra: ¿Régimen 1267 o Resolución 1373?', 'type' => 'interactive', 'duration_minutes' => 10, 'content' => json_encode(['kind' => 'matrix_builder'] + $regimen1267vs1373)],
            ]],
            ['title' => 'Módulo 4: FPADM — Corea del Norte e Irán', 'lessons' => [
                ['title' => 'Financiamiento de la Proliferación de Armas de Destrucción Masiva', 'type' => 'interactive', 'duration_minutes' => 12, 'content' => json_encode(['kind' => 'slide'] + $fpadmSlide)],
            ]],
            ['title' => 'Módulo 5: OFAC y SDN', 'lessons' => [
                ['title' => 'OFAC y la lista SDN', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'cards'] + $ofacCards)],
            ]],
            ['title' => 'Módulo 6: GAFI y jurisdicciones de riesgo', 'lessons' => [
                ['title' => 'GAFI: país no es lo mismo que persona sancionada', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'slide'] + $gafiSlide)],
                ['title' => 'Mapa de jurisdicciones GAFI por región', 'type' => 'interactive', 'duration_minutes' => 6, 'content' => json_encode(['kind' => 'gafi_map'] + $gafiMap)],
            ]],
            ['title' => 'Módulo 7: Coincidencia real o falso positivo', 'lessons' => [
                ['title' => 'Glosario: coincidencia, falso positivo y tipping off', 'type' => 'glossary', 'duration_minutes' => 10, 'content' => json_encode($glosarioListas)],
                ['title' => 'Juego: empareja los conceptos clave', 'type' => 'memory', 'duration_minutes' => 8, 'content' => json_encode($memoryListas)],
                ['title' => 'Buscador de práctica: ¿está en la lista?', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'screening_search'] + $screeningSearch)],
            ]],
            ['title' => 'Módulo 8: Congelamiento administrativo', 'lessons' => [
                ['title' => 'Semáforo de consecuencias', 'type' => 'interactive', 'duration_minutes' => 8, 'content' => json_encode(['kind' => 'cards'] + $semaforoCards)],
                ['title' => 'El congelamiento administrativo en el Perú', 'type' => 'interactive', 'duration_minutes' => 10, 'content' => json_encode(['kind' => 'slide'] + $congelamientoSlide)],
            ]],
            ['title' => 'Módulo 9: ¿Qué debe hacer el trabajador?', 'lessons' => [
                ['title' => 'Arrastra: ¿quién hace qué?', 'type' => 'interactive', 'duration_minutes' => 10, 'content' => json_encode(['kind' => 'matrix_builder'] + $quienHaceQue)],
            ]],
            ['title' => 'Módulo 10: Casos prácticos por sector', 'lessons' => [
                ['title' => 'Casos prácticos por sector', 'type' => 'interactive', 'duration_minutes' => 10, 'content' => json_encode(['kind' => 'cards'] + $casosSectoriales)],
            ]],
        ];

        foreach ($modulesData as $order => $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
                'order' => $order + 1,
            ]);

            foreach ($moduleData['lessons'] as $lessonOrder => $lessonData) {
                $module->lessons()->create([
                    'title' => $lessonData['title'],
                    'type' => $lessonData['type'],
                    'content' => $lessonData['content'] ?? null,
                    'duration_minutes' => $lessonData['duration_minutes'] ?? null,
                    'order' => $lessonOrder + 1,
                ]);
            }
        }

        $exam = $course->exam()->create([
            'title' => 'Autoevaluación: Listas Internacionales, FT y FPADM',
            'passing_score' => 70,
            'max_attempts' => 3,
            'time_limit_minutes' => 25,
        ]);

        $questions = [
            [
                'q' => '¿Qué diferencia principal existe entre el régimen 1267/1989/2253 y la Resolución 1373?',
                'options' => [
                    'Son exactamente lo mismo, solo cambia el nombre',
                    'El 1267 administra una lista consolidada específica; la 1373 obliga a los Estados y habilita designaciones nacionales, sin ser una lista única mundial',
                    'La 1373 es la lista más antigua y el 1267 la reemplazó por completo',
                    'El 1267 solo aplica a Corea del Norte',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿OFAC es lo mismo que el Consejo de Seguridad de la ONU?',
                'options' => [
                    'Sí, ambos son el mismo organismo',
                    'No: OFAC es una entidad del Departamento del Tesoro de EE. UU.; el CSNU es un órgano de Naciones Unidas',
                    'OFAC es un comité del CSNU',
                    'OFAC solo existe para sancionar a Perú',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'Un cliente procede de un país bajo monitoreo reforzado del GAFI. ¿Se deben congelar automáticamente sus fondos?',
                'options' => [
                    'Sí, siempre',
                    'No: es un factor de riesgo que exige mayor análisis y, cuando corresponda, debida diligencia reforzada',
                    'Solo si el cliente es extranjero',
                    'Solo si el monto supera S/ 1,000',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Qué es una "coincidencia potencial"?',
                'options' => [
                    'La confirmación definitiva de que el cliente es una persona sancionada',
                    'Una alerta inicial de screening que aún debe verificarse antes de sacar conclusiones',
                    'Un tipo de operación inusual',
                    'Un documento que emite la UIF-Perú',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Qué significa "tipping off" y por qué debe evitarse?',
                'options' => [
                    'Es dar propina a un cliente y no tiene relación con este curso',
                    'Es revelar al cliente, directa o indirectamente, que existe una alerta o investigación en curso',
                    'Es un tipo de coincidencia de nombre',
                    'Es el nombre de una lista de la ONU',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'Ante una coincidencia de nombre con una lista, ¿cuál es la actuación correcta del colaborador?',
                'options' => [
                    'Confirmar de inmediato que el cliente es la persona designada',
                    'Ignorar la alerta si el cliente es conocido',
                    'Verificar los datos disponibles y escalar de inmediato al Oficial de Cumplimiento, sin alertar al cliente',
                    'Explicarle al cliente que apareció en una lista internacional',
                ],
                'correct' => 2,
            ],
            [
                'q' => '¿Qué significa FPADM?',
                'options' => [
                    'Financiamiento de la Proliferación de Armas de Destrucción Masiva',
                    'Fondo Peruano de Ahorro y Depósitos Múltiples',
                    'Un tipo de operación bancaria internacional',
                    'Una lista administrada exclusivamente por OFAC',
                ],
                'correct' => 0,
            ],
            [
                'q' => 'Respecto del régimen de sanciones sobre Irán, ¿cuál de las siguientes afirmaciones es correcta?',
                'options' => [
                    'La Resolución 2231 de 2015 sigue siendo, sin ningún cambio, el único marco vigente hasta hoy',
                    'Tras el mecanismo de "snapback" activado en 2025, el Consejo de Seguridad restableció resoluciones de sanciones previas sobre Irán',
                    'Irán nunca ha estado sujeto a sanciones del Consejo de Seguridad',
                    'El régimen sobre Irán fue derogado completamente en 2015 y no se ha vuelto a activar',
                ],
                'correct' => 1,
            ],
            [
                'q' => '¿Cuál es la diferencia entre congelamiento administrativo, debida diligencia reforzada y ROS?',
                'options' => [
                    'Son sinónimos y se usan indistintamente',
                    'El congelamiento inmoviliza activos, la DDR es un nivel de análisis más exigente, y el ROS comunica una operación sospechosa a la UIF-Perú',
                    'El ROS es lo mismo que congelar fondos',
                    'La DDR solo aplica a los bancos',
                ],
                'correct' => 1,
            ],
            [
                'q' => 'Un cliente coincide plenamente en nombre, fecha de nacimiento, nacionalidad y número de documento con una persona incluida en una designación vigente aplicable del CSNU. ¿Qué corresponde?',
                'options' => [
                    'Continuar la operación con normalidad',
                    'Escalar de inmediato al Oficial de Cumplimiento para activar el procedimiento correspondiente, sin informar al cliente el motivo exacto',
                    'Informarle al cliente que apareció en una lista terrorista',
                    'Esperar a que el cliente lo mencione primero',
                ],
                'correct' => 1,
            ],
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

        $this->command?->info('Curso "Listas Internacionales, FT y FPADM" creado con '.count($modulesData).' módulos y '.count($questions).' preguntas.');
    }

    private function svgCover(): string
    {
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 450" width="800" height="450">
  <defs>
    <radialGradient id="glow" cx="80%" cy="10%" r="60%">
      <stop offset="0%" stop-color="#8B7340" stop-opacity="0.35"/>
      <stop offset="100%" stop-color="#8B7340" stop-opacity="0"/>
    </radialGradient>
    <linearGradient id="lineFade" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0%" stop-color="#8B7340" stop-opacity="0"/>
      <stop offset="50%" stop-color="#B89A56" stop-opacity="1"/>
      <stop offset="100%" stop-color="#8B7340" stop-opacity="0"/>
    </linearGradient>
  </defs>
  <rect width="800" height="450" fill="#0B1829"/>
  <rect width="800" height="450" fill="url(#glow)"/>
  <g stroke="#1C2E45" stroke-width="1.5" opacity="0.7">
    <line x1="0" y1="380" x2="420" y2="0"/>
    <line x1="60" y1="450" x2="500" y2="0"/>
    <line x1="160" y1="450" x2="600" y2="0"/>
    <line x1="280" y1="450" x2="720" y2="0"/>
  </g>
  <g transform="translate(400,175)">
    <circle r="46" fill="#0B1829" stroke="#B89A56" stroke-width="2.5"/>
    <path d="M-20 -6 L-6 10 L22 -18" fill="none" stroke="#FAFAF6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
  </g>
  <line x1="260" y1="255" x2="540" y2="255" stroke="url(#lineFade)" stroke-width="1.5"/>
  <text x="400" y="325" font-family="Arial, sans-serif" font-size="15" fill="#B89A56" text-anchor="middle" letter-spacing="3">LISTAS INTERNACIONALES</text>
  <text x="400" y="410" font-family="Georgia, 'Times New Roman', serif" font-size="16" font-weight="700" fill="#FAFAF6" text-anchor="middle" letter-spacing="2" opacity="0.85">ROMANI COMPLIANCE</text>
</svg>
SVG;
    }
}
