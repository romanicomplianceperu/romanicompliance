@if($course->project)
  <span class="cert-type-badge" style="background:rgba(139,115,64,0.12);color:#8B7340;border:1px solid rgba(139,115,64,0.3);">Exclusivo para personal de {{ $course->project->company->name }}</span>
@endif
