{{-- Iconos de línea del sitio público. Uso: @include('site.partials.icon', ['name' => 'shield']) --}}
<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
@switch($name)
  @case('shield')<path d="M12 3l7.5 3v5.5c0 4.6-3.2 8.2-7.5 9.5-4.3-1.3-7.5-4.9-7.5-9.5V6L12 3z"/><path d="M9 12l2.2 2.2L15.5 10"/>@break
  @case('snow')<rect x="4" y="3.5" width="16" height="17" rx="2.5"/><path d="M12 8v8M8.5 10l7 4M15.5 10l-7 4"/>@break
  @case('coin')<circle cx="12" cy="12" r="8.5"/><path d="M9.5 8.5h4a2 2 0 010 4h-4m0 0h4.5a2 2 0 010 4h-4.5m0-8v8m1.5-9.5v1.5m0 8v1.5"/>@break
  @case('doc')<path d="M7 3h7l4 4v14H7z"/><path d="M14 3v4h4M10 12h5M10 15.5h5"/>@break
  @case('scale')<path d="M12 4v16M7 20h10M5 7h14"/><path d="M5 7l-2.5 6a3 3 0 005 0L5 7zM19 7l-2.5 6a3 3 0 005 0L19 7z"/>@break
  @case('house')<path d="M4 20V10l8-6 8 6v10"/><path d="M9.5 20v-6h5v6M3 20h18"/>@break
  @case('cap')<path d="M3 9l9-4 9 4-9 4-9-4z"/><path d="M7 11v4c0 1.4 2.2 2.5 5 2.5s5-1.1 5-2.5v-4M21 9v5"/>@break
  @case('arrow')<path d="M5 12h14M13 6l6 6-6 6"/>@break
  @case('check')<path d="M5 12.5l4.5 4.5L19 7.5"/>@break
  @case('plus')<path d="M12 5v14M5 12h14"/>@break
  @case('chat')<path d="M4 5h16v11H9l-5 4z"/>@break
  @case('mail')<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3.5 6.5l8.5 6 8.5-6"/>@break
  @case('alert')<path d="M12 3.5l9.5 16.5h-19L12 3.5z"/><path d="M12 10v4.5M12 17.5h.01"/>@break
  @case('clock')<circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/>@break
  @default<circle cx="12" cy="12" r="8"/>
@endswitch
</svg>
