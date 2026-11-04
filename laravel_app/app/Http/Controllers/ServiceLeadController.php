<?php

namespace App\Http\Controllers;

use App\Models\ServiceLead;
use App\Support\ServiceCatalog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceLeadController extends Controller
{
    /**
     * Guarda la solicitud que envía una herramienta de servicio (o el formulario de contacto) y
     * devuelve el enlace firmado al PDF con el resumen.
     */
    public function store(Request $request, string $slug)
    {
        abort_unless(ServiceLead::allowedSlug($slug), 404);

        // Campo trampa: los bots lo rellenan, las personas no lo ven.
        if (filled($request->input('website'))) {
            return response()->json(['ok' => true]);
        }

        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:120', 'required_without:organization'],
            'organization' => ['nullable', 'string', 'max:160'],
            'email' => ['nullable', 'email', 'max:255', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'max:30', 'required_without:email'],
            'summary' => ['required', 'string', 'max:4000'],
            'data' => ['nullable', 'array'],
            'score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'level' => ['nullable', 'string', 'max:60'],
            'consent' => ['accepted'],
        ], [
            'name.required_without' => 'Indique su nombre o el de su organización.',
            'email.required_without' => 'Indique un correo o un teléfono para contactarle.',
            'phone.required_without' => 'Indique un correo o un teléfono para contactarle.',
            'email.email' => 'El correo no es válido.',
            'consent.accepted' => 'Necesitamos su autorización para contactarle.',
        ]);

        $service = ServiceCatalog::find($slug);

        $attrs = [
            'service_slug' => $slug,
            'service_name' => $service['name'] ?? 'Consulta general',
            'name' => filled($data['name'] ?? null) ? (string) Str::of($data['name'])->squish()->title() : Str::limit(Str::squish($data['organization']), 120, ''),
            'organization' => isset($data['organization']) ? Str::squish($data['organization']) : null,
            'email' => $data['email'] ?? null,
            'phone' => isset($data['phone']) ? trim($data['phone']) : null,
            'summary' => $data['summary'],
            'data' => $this->cleanData($data['data'] ?? []),
            'score' => $data['score'] ?? null,
            'level' => $data['level'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ];

        // Se guarda para el panel admin; si la base de datos falla, el cliente igual recibe su PDF.
        try {
            $lead = ServiceLead::create($attrs);
        } catch (\Throwable $e) {
            report($e);
            $lead = new ServiceLead($attrs);
            $lead->id = 0;
            $lead->created_at = now();
        }

        // Desde las herramientas se pide el PDF directamente en la respuesta.
        if ($request->boolean('download')) {
            return static::renderPdf($lead);
        }

        return response()->json(['ok' => true, 'pdf' => $lead->exists ? $lead->publicPdfUrl() : null]);
    }

    /** PDF para quien hizo la solicitud (enlace firmado, válido 30 días). */
    public function pdf(ServiceLead $lead)
    {
        return $this->renderPdf($lead);
    }

    public static function renderPdf(ServiceLead $lead)
    {
        $logo = 'data:image/png;base64,'.base64_encode((string) @file_get_contents(public_path('images/logos.png')));
        $fonts = storage_path('fonts');
        if (! is_dir($fonts)) {
            @mkdir($fonts, 0775, true);
        }
        $web = 'https://romanicompliance.com';
        $ref = 'RC-'.str_pad((string) $lead->id, 5, '0', STR_PAD_LEFT);
        $wa = 'https://wa.me/'.ServiceCatalog::WHATSAPP.'?text='.rawurlencode('Hola, descargué mi '.mb_strtolower($lead->documentTitle()).' ('.($lead->id ? $ref : $lead->service_name).') y quisiera conversar con el equipo de Romani Compliance.');
        $pdf = Pdf::loadView('site.pdf.lead', compact('lead', 'logo', 'web', 'wa', 'ref'))->setPaper('a4')
            ->setOption('isFontSubsettingEnabled', true)->setOption('fontDir', $fonts)->setOption('fontCache', $fonts);
        $file = Str::slug($lead->documentTitle().' '.($lead->organization ?: $lead->name)).'.pdf';

        return $pdf->download($file);
    }

    /** Solo listas de textos cortos: lo que la herramienta quiera mostrar en el PDF. */
    private function cleanData(array $data): array
    {
        $out = [];
        foreach (['lines', 'priorities', 'next'] as $key) {
            if (! empty($data[$key]) && is_array($data[$key])) {
                $out[$key] = array_values(array_map(fn ($v) => Str::limit(strip_tags((string) $v), 300), array_slice($data[$key], 0, 15)));
            }
        }
        if (! empty($data['title'])) {
            $out['title'] = Str::limit(strip_tags((string) $data['title']), 160);
        }

        return $out;
    }
}
