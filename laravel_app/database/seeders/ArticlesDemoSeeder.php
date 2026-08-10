<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticlesDemoSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'omaroliden1@gmail.com')->first();

        if (! $author) {
            $this->command?->warn('No se encontró el usuario de Omar; se omite la siembra de artículos.');

            return;
        }

        $articles = [
            [
                'title' => 'El Oficial de Cumplimiento: funciones, requisitos y responsabilidades',
                'category' => 'Oficial de Cumplimiento',
                'cover' => 'articles/covers/oficial-cumplimiento.svg',
                'reading_minutes' => 7,
                'tags' => ['SPLAFT', 'Oficial de Cumplimiento', 'UIF'],
                'excerpt' => 'Guía práctica sobre el rol del Oficial de Cumplimiento en organizaciones sujetas al régimen de prevención LA/FT: cómo se designa, qué funciones cumple y qué responsabilidad asume.',
                'content' => "El Oficial de Cumplimiento es la persona designada por el sujeto obligado para velar por el correcto funcionamiento del Sistema de Prevención del Lavado de Activos y Financiamiento del Terrorismo (SPLAFT) dentro de la organización. Su designación no es un formalismo administrativo: la normativa vigente exige que cuente con autonomía e independencia suficientes para ejercer sus funciones, y que su nombramiento sea comunicado formalmente a la Unidad de Inteligencia Financiera del Perú (UIF).\n\nRequisitos para la designación\n\nLa persona propuesta como Oficial de Cumplimiento debe reunir condiciones de idoneidad técnica y moral. Dependiendo del tamaño y la actividad del sujeto obligado, el cargo puede ser ejercido a tiempo completo o, en el caso de empresas de menor envergadura, de forma compartida con otras funciones, siempre que ello no comprometa su independencia de criterio frente a las áreas comerciales u operativas.\n\nPrincipales funciones\n\nEntre las funciones más relevantes del Oficial de Cumplimiento se encuentran: liderar el diseño e implementación del Manual de Prevención y el Código de Conducta; supervisar la aplicación de las políticas de debida diligencia en el conocimiento del cliente; evaluar y calificar las operaciones inusuales detectadas por el personal; decidir, con criterio técnico, la comunicación de operaciones sospechosas a la UIF mediante el Reporte de Operaciones Sospechosas (ROS); y elaborar el informe anual o semestral sobre la situación del sistema de prevención.\n\nResponsabilidad administrativa y penal\n\nUn aspecto que suele generar dudas es el alcance de la responsabilidad personal del Oficial de Cumplimiento. Si bien el diseño e implementación del SPLAFT es una obligación de la organización en su conjunto, el Oficial de Cumplimiento puede verse expuesto a responsabilidad administrativa ante la SBS si se determina negligencia grave en el ejercicio de sus funciones, y en supuestos excepcionales, a responsabilidad penal si se acredita su participación dolosa en la comisión de delitos de lavado de activos.\n\nPor esta razón, la capacitación continua, la documentación adecuada de cada decisión y el respaldo institucional del directorio son elementos que no solo fortalecen el sistema de prevención, sino que también protegen al propio Oficial de Cumplimiento en el ejercicio de su cargo.\n\nEn Romani Compliance acompañamos a organizaciones de distintos sectores en la designación, capacitación y fortalecimiento de sus Oficiales de Cumplimiento, brindando el respaldo técnico necesario para el ejercicio idóneo de esta función crítica.",
            ],
            [
                'title' => 'Nueva Circular del BCRP para Empresas de Servicios de Pago: lo que debe saber',
                'category' => 'Normativa BCRP',
                'cover' => 'articles/covers/normativa-bcrp.svg',
                'reading_minutes' => 6,
                'tags' => ['BCRP', 'ESP', 'Regulación'],
                'excerpt' => 'Análisis de las implicancias regulatorias de la nueva circular del BCRP para empresas de servicios de pago (ESP) y su impacto en el cumplimiento normativo del sector fintech.',
                'content' => "El Banco Central de Reserva del Perú (BCRP) continúa fortaleciendo el marco regulatorio aplicable a las Empresas de Servicios de Pago (ESP), en línea con el crecimiento acelerado de los medios de pago digitales en el país. La circular más reciente introduce precisiones relevantes sobre los requisitos operativos, los mecanismos de reporte y las obligaciones de transparencia que estas entidades deben observar frente a sus usuarios y frente al propio ente regulador.\n\n¿A quiénes alcanza la circular?\n\nLa norma está dirigida a las empresas autorizadas para operar como proveedoras de servicios de pago, incluyendo billeteras digitales, agregadores y procesadores de pago que no califican como empresas del sistema financiero tradicional, pero que canalizan volúmenes crecientes de transacciones electrónicas.\n\nPrincipales implicancias\n\nEntre los puntos más relevantes destaca el reforzamiento de los estándares de continuidad operativa, la exigencia de mecanismos más robustos de conciliación de saldos y la obligación de reportar con mayor periodicidad indicadores operativos al BCRP. Estas exigencias buscan reducir el riesgo sistémico asociado al crecimiento del volumen transaccional gestionado por las ESP y garantizar la protección de los fondos de los usuarios.\n\nVinculación con la prevención de LA/FT\n\nSi bien la circular tiene un enfoque primordialmente operativo y de estabilidad del sistema de pagos, sus disposiciones se entrelazan con las obligaciones de prevención de lavado de activos y financiamiento del terrorismo que estas empresas ya deben cumplir como sujetos obligados ante la UIF. Un sistema de conciliación y trazabilidad más riguroso facilita, en la práctica, la detección de patrones inusuales en el uso de las plataformas de pago, reforzando indirectamente el sistema de prevención LA/FT del sector.\n\nRecomendaciones para las ESP\n\nLas empresas alcanzadas por esta circular deben revisar sus procedimientos internos de conciliación, actualizar sus políticas de continuidad de negocio y verificar que sus reportes periódicos al BCRP se ajusten a los nuevos formatos y plazos exigidos. La articulación entre las áreas de cumplimiento normativo, tecnología y operaciones resulta clave para una adecuada adaptación a estos cambios.\n\nDesde Romani Compliance, apoyamos a empresas de servicios de pago y otras entidades del ecosistema fintech en la adecuación de sus procedimientos internos a las exigencias regulatorias del BCRP y de la SBS/UIF.",
            ],
            [
                'title' => 'Criptoactivos y riesgo de lavado de activos: qué deben saber los sujetos obligados',
                'category' => 'Criptoactivos',
                'cover' => 'articles/covers/criptoactivos.svg',
                'reading_minutes' => 8,
                'tags' => ['Criptoactivos', 'LA/FT', 'GAFI'],
                'excerpt' => 'Los criptoactivos plantean desafíos particulares para los sistemas de prevención LA/FT. Repasamos los principales riesgos y las medidas de debida diligencia recomendadas por el GAFI.',
                'content' => "El crecimiento sostenido de los criptoactivos como medio de inversión y, en algunos casos, como medio de pago, ha puesto en la agenda regulatoria mundial la necesidad de extender los estándares de prevención del lavado de activos y financiamiento del terrorismo (LA/FT) a este tipo de operaciones. El Grupo de Acción Financiera Internacional (GAFI) ha sido explícito al respecto: los proveedores de servicios de activos virtuales (conocidos como VASP, por sus siglas en inglés) deben ser considerados sujetos obligados y aplicar medidas de debida diligencia equivalentes a las exigidas al sistema financiero tradicional.\n\n¿Por qué los criptoactivos concentran mayor riesgo?\n\nA diferencia de las transferencias bancarias tradicionales, las operaciones con criptoactivos pueden ejecutarse con un alto grado de pseudo-anonimato, atravesar fronteras de forma casi instantánea y, en determinados casos, involucrar plataformas no reguladas o descentralizadas. Estas características, sumadas a la volatilidad de su valor, los convierten en un vehículo atractivo para estructurar operaciones de lavado de activos o para financiar actividades ilícitas, incluyendo el financiamiento del terrorismo.\n\nLa Recomendación 15 del GAFI\n\nA través de su Recomendación 15, el GAFI ha establecido que los países deben regular a los proveedores de servicios de activos virtuales bajo el mismo enfoque basado en riesgos aplicable a las instituciones financieras, exigiéndoles registro o licenciamiento, supervisión efectiva y la aplicación de la conocida 'regla de viaje' (travel rule), que obliga a acompañar cada transferencia de criptoactivos con la información identificatoria del originador y del beneficiario.\n\nImplicancias para sujetos obligados en el Perú\n\nEn el Perú, si bien la regulación específica sobre criptoactivos se encuentra en desarrollo, las entidades que ya califican como sujetos obligados —por ejemplo, empresas del sistema financiero o notarios que intermedian en operaciones vinculadas a estos activos— deben incorporar en su matriz de riesgo LA/FT las señales de alerta propias de este tipo de operaciones: transferencias fraccionadas hacia exchanges internacionales, uso de mezcladores de criptomonedas, o clientes cuyo perfil declarado no guarda coherencia con los montos operados.\n\nRecomendaciones prácticas\n\nLos sujetos obligados que interactúan, directa o indirectamente, con operaciones vinculadas a criptoactivos deben reforzar su debida diligencia del cliente, documentar el origen de fondos declarado, monitorear el uso de plataformas de intercambio no reguladas y mantenerse actualizados respecto a la evolución regulatoria nacional e internacional en esta materia.\n\nEn Romani Compliance asesoramos a nuestros clientes en la incorporación del riesgo de criptoactivos dentro de sus sistemas de prevención LA/FT, alineando sus procedimientos internos con los estándares internacionales del GAFI.",
            ],
        ];

        foreach ($articles as $data) {
            $category = ArticleCategory::firstOrCreate(
                ['slug' => Str::slug($data['category'])],
                ['name' => $data['category']]
            );

            $article = Article::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'author_id' => $author->id,
                    'article_category_id' => $category->id,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'cover_image' => $data['cover'],
                    'reading_minutes' => $data['reading_minutes'],
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );

            $tagIds = collect($data['tags'])->map(
                fn ($name) => Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name])->id
            );
            $article->tags()->sync($tagIds);
        }

        $this->command?->info('Artículos de prueba creados: '.count($articles));
    }
}
