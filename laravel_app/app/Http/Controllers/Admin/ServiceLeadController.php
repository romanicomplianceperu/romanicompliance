<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ServiceLeadController as PublicLeadController;
use App\Models\ServiceLead;
use App\Support\ServiceCatalog;
use Illuminate\Http\Request;

class ServiceLeadController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('estado');
        $service = $request->query('servicio');
        $q = trim((string) $request->query('q'));

        $leads = ServiceLead::query()
            ->when($status, fn ($x) => $x->where('status', $status))
            ->when($service, fn ($x) => $x->where('service_slug', $service))
            ->when($q !== '', fn ($x) => $x->where(fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('organization', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%")->orWhere('phone', 'like', "%{$q}%")))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $counts = ServiceLead::selectRaw('status, count(*) as n')->groupBy('status')->pluck('n', 'status');
        $services = collect(ServiceCatalog::all())->map(fn ($s) => $s['name'])->put('contacto', 'Formulario de contacto');

        return view('admin.leads.index', compact('leads', 'counts', 'services', 'status', 'service', 'q'));
    }

    public function show(ServiceLead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function update(Request $request, ServiceLead $lead)
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(ServiceLead::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:10000'],
            'quote_amount' => ['nullable', 'numeric', 'min:0', 'max:9999999999'],
            'quote_currency' => ['required', 'in:PEN,USD'],
            'follow_up_at' => ['nullable', 'date'],
            'organization' => ['nullable', 'string', 'max:160'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        if ($data['status'] !== 'nuevo' && ! $lead->contacted_at) {
            $data['contacted_at'] = now();
        }

        $lead->update($data);

        return back()->with('success', 'Solicitud actualizada.');
    }

    public function pdf(ServiceLead $lead)
    {
        return PublicLeadController::renderPdf($lead);
    }
}
