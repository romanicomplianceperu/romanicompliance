<?php

namespace App\Models;

use App\Support\ServiceCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ServiceLead extends Model
{
    public const STATUSES = [
        'nuevo' => 'Nuevo',
        'contactado' => 'Contactado',
        'propuesta' => 'Propuesta enviada',
        'cliente' => 'Cliente',
        'descartado' => 'Descartado',
    ];

    protected $fillable = [
        'service_slug', 'service_name', 'name', 'organization', 'email', 'phone', 'summary', 'data',
        'score', 'level', 'status', 'admin_notes', 'quote_amount', 'quote_currency', 'follow_up_at',
        'contacted_at', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'data' => 'array',
        'follow_up_at' => 'date',
        'contacted_at' => 'datetime',
        'quote_amount' => 'decimal:2',
    ];

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function firstName(): string
    {
        return Str::of($this->name)->trim()->explode(' ')->first() ?: $this->name;
    }

    /** Número en formato internacional para wa.me (asume Perú si son 9 dígitos que empiezan en 9). */
    public function whatsappNumber(): ?string
    {
        $d = preg_replace('/\D+/', '', (string) $this->phone);
        if ($d === '') {
            return null;
        }
        if (strlen($d) === 9 && str_starts_with($d, '9')) {
            $d = '51'.$d;
        }

        return $d;
    }

    public function whatsappUrl(): ?string
    {
        $n = $this->whatsappNumber();
        if (! $n) {
            return null;
        }
        $text = 'Hola '.$this->firstName().', le escribimos de Romani Compliance por su solicitud sobre '.$this->service_name.'. ¿Tiene unos minutos para conversar?';

        return 'https://wa.me/'.$n.'?text='.rawurlencode($text);
    }

    public function isDiagnosis(): bool
    {
        return $this->score !== null;
    }

    public function documentTitle(): string
    {
        return $this->service_slug === 'compliance-penal' ? 'Diagnóstico de riesgo' : 'Resumen de su caso';
    }

    /** Enlace público y firmado al PDF (para quien lo solicitó). */
    public function publicPdfUrl(): string
    {
        return URL::temporarySignedRoute('services.leads.pdf', now()->addDays(30), ['lead' => $this->id], absolute: false);
    }

    public static function allowedSlug(string $slug): bool
    {
        return $slug === 'contacto' || ServiceCatalog::find($slug) !== null;
    }
}
