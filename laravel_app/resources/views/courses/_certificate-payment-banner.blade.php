@php
  $bannerEnrollment = $enrollment ?? $course->enrollmentFor(auth()->user());
  $bannerId = 'certNotice-'.$course->id;
  $isProcessing = $stage === 'processing';
@endphp
<style>
.cert-payment-banner { display: flex; gap: 1.4rem; align-items: center; background: var(--gold-pale); border: 1px solid rgba(139,115,64,0.25); border-left: 4px solid var(--gold); border-radius: 8px; padding: 1.3rem 1.5rem; margin-bottom: 2rem; position: relative; flex-wrap: wrap; }
.cert-payment-close { position: absolute; top: 10px; right: 12px; background: none; border: none; font-size: 1.2rem; color: var(--slate-light); cursor: pointer; line-height: 1; }
.cert-payment-close:hover { color: var(--ink); }
.cert-preview-wrap { position: relative; width: 150px; flex-shrink: 0; }
.cert-preview-mock { width: 150px; height: 100px; border-radius: 4px; overflow: hidden; display: flex; box-shadow: var(--shadow-s); filter: blur(3.5px); user-select: none; }
.cpm-sidebar { width: 34px; flex-shrink: 0; background: var(--ink); display: flex; align-items: center; justify-content: center; }
.cpm-sidebar span { color: var(--white); font-family: var(--serif); font-size: 0.6rem; font-weight: 700; transform: rotate(-90deg); white-space: nowrap; }
.cpm-content { flex: 1; background: var(--ivory); padding: 8px 9px; overflow: hidden; }
.cpm-eyebrow { font-size: 0.42rem; font-weight: 700; letter-spacing: 0.05em; color: var(--gold); text-transform: uppercase; margin-bottom: 2px; }
.cpm-title { font-family: var(--serif); font-size: 0.85rem; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
.cpm-name { font-family: var(--serif); font-size: 0.62rem; font-weight: 700; color: var(--ink); border-bottom: 0.5px solid var(--ink); display: inline-block; margin-bottom: 3px; }
.cpm-course { font-size: 0.4rem; color: var(--slate); line-height: 1.3; }
.cert-preview-lock { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px; background: rgba(11,24,41,0.18); border-radius: 4px; }
.cert-preview-lock svg { width: 18px; height: 18px; color: var(--white); }
.cert-preview-lock span { font-size: 0.6rem; font-weight: 700; color: var(--white); text-transform: uppercase; letter-spacing: 0.04em; text-shadow: 0 1px 2px rgba(0,0,0,0.4); }
.cert-payment-text { flex: 1; min-width: 240px; }
.cert-payment-text h4 { font-size: 1rem; margin-bottom: 6px; color: var(--ink); }
.cert-payment-text p { font-size: 0.85rem; color: var(--slate); line-height: 1.6; margin-bottom: 0; }
.cert-payment-form { margin-top: 10px; }
.cert-payment-form input { width: 100%; max-width: 320px; padding: 9px 12px; border: 1px solid var(--line); border-radius: var(--radius); font-family: var(--sans); font-size: 0.85rem; margin-bottom: 10px; }
.cert-payment-actions { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.btn-whatsapp-sm { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: var(--green-wa); color: var(--white); border-radius: var(--radius); font-family: var(--sans); font-size: 0.8rem; font-weight: 600; }
.btn-whatsapp-sm:hover { background: #1fb955; }
.btn-whatsapp-sm svg { width: 14px; height: 14px; fill: currentColor; }
.btn-claim-sm { padding: 9px 18px; background: var(--ink); color: var(--white); border: none; border-radius: var(--radius); font-family: var(--sans); font-size: 0.8rem; font-weight: 600; cursor: pointer; }
.btn-claim-sm:hover { background: var(--ink-light); }
.cert-payment-later { font-size: 0.8rem; color: var(--slate); font-weight: 600; background: none; border: none; cursor: pointer; text-decoration: underline; padding: 0; }
@media (max-width: 640px) { .cert-payment-banner { flex-direction: column; align-items: flex-start; } }
</style>
<div class="cert-payment-banner" id="{{ $bannerId }}">
  <button type="button" class="cert-payment-close" onclick="document.getElementById('{{ $bannerId }}').style.display='none'" aria-label="Cerrar">&times;</button>

  <div class="cert-preview-wrap">
    <div class="cert-preview-mock">
      <div class="cpm-sidebar"><span>ROMANI.</span></div>
      <div class="cpm-content">
        <div class="cpm-eyebrow">Certificado de finalización</div>
        <div class="cpm-title">Certificado</div>
        <div class="cpm-name">{{ $bannerEnrollment->certificate_name ?? auth()->user()->name }}</div>
        <div class="cpm-course">{{ $course->title }}</div>
      </div>
    </div>
    <div class="cert-preview-lock">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="11" width="14" height="9" rx="1.5"/><path d="M8 11V8a4 4 0 018 0v3"/></svg>
      <span>Vista previa</span>
    </div>
  </div>

  <div class="cert-payment-text">
    @if($isProcessing)
      <h4>Tu certificado está en proceso</h4>
      <p>Registramos tu solicitud para <strong>{{ $course->title }}</strong>. En cuanto confirmemos tu pago, emitiremos tu certificado y podrás descargarlo desde aquí.</p>
    @else
      <h4>Completaste «{{ $course->title }}» — obtén tu certificación</h4>
      <p>Esta certificación tiene un costo de <strong>S/ {{ number_format($course->certificate_price ?? 0, 2) }}</strong>. Indica el nombre que debe aparecer en tu certificado y elige una opción.</p>
      <form action="{{ route('courses.claim-payment', $course) }}" method="POST" class="cert-payment-form">
        @csrf
        <input type="text" name="certificate_name" value="{{ old('certificate_name', $bannerEnrollment->certificate_name ?? auth()->user()->name) }}" required placeholder="Nombre para tu certificado">
        <div class="cert-payment-actions">
          <a href="https://wa.me/51969754983?text={{ urlencode('Hola, deseo pagar la certificación del curso "'.$course->title.'".') }}" target="_blank" class="btn-whatsapp-sm">
            <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Hacer el pago ahora
          </a>
          <button type="submit" class="btn-claim-sm">Ya hice el pago</button>
          <button type="button" class="cert-payment-later" onclick="document.getElementById('{{ $bannerId }}').style.display='none'">En otro momento</button>
        </div>
      </form>
    @endif
  </div>
</div>
