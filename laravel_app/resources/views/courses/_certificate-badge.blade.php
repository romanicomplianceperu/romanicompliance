@if(($course->certificate_type ?? 'gratuita') === 'gratuita')
  <span class="cert-type-badge free">Certificación gratuita</span>
@else
  <span class="cert-type-badge optional">Certificación opcional</span>
@endif
