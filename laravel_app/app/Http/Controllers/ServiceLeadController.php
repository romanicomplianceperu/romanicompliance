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

        $lead = ServiceLead::create([
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
        ]);

        return response()->json(['ok' => true, 'pdf' => $lead->publicPdfUrl()]);
    }

    /** PDF para quien hizo la solicitud (enlace firmado, válido 30 días). */
    public function pdf(ServiceLead $lead)
    {
        return $this->renderPdf($lead);
    }

    public static function renderPdf(ServiceLead $lead)
    {
        $logo = 'data:image/png;base64,'.base64_encode((string) @file_get_contents(public_path('images/logos.png')));
        $pdf = Pdf::loadView('site.pdf.lead', compact('lead', 'logo'))->setPaper('a4')->setOption('isFontSubsettingEnabled', true);
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
