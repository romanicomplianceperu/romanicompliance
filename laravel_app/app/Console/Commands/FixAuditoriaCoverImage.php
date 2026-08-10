<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FixAuditoriaCoverImage extends Command
{
    protected $signature = 'courses:fix-auditoria-cover';

    protected $description = 'Restaura la portada SVG original del curso "Auditoría Interna del Sistema de Prevención LA/FT" (se había sobrescrito con una imagen subida manualmente)';

    public function handle(): int
    {
        $course = Course::where('slug', 'auditoria-interna-splaft')->first();

        if (! $course) {
            $this->error('No se encontró el curso auditoria-interna-splaft.');

            return self::FAILURE;
        }

        $oldPath = $course->cover_image;
        $newPath = 'courses/covers/auditoria-interna-splaft.svg';

        Storage::disk('public')->put($newPath, $this->svgCover('chart', 'AUDITORÍA INTERNA'));
        $course->update(['cover_image' => $newPath]);

        if ($oldPath && $oldPath !== $newPath) {
            Storage::disk('public')->delete($oldPath);
        }

        $this->info('Portada restaurada correctamente.');

        return self::SUCCESS;
    }

    private function svgCover(string $icon, string $label): string
    {
        $iconMarkup = '<rect x="360" y="180" width="14" height="40" fill="#8B7340"/><rect x="384" y="155" width="14" height="65" fill="#B89A56"/><rect x="408" y="130" width="14" height="90" fill="#8B7340"/><rect x="432" y="165" width="14" height="55" fill="#B89A56"/><line x1="352" y1="228" x2="452" y2="228" stroke="#FAFAF6" stroke-width="1.5"/>';

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

  {$iconMarkup}

  <line x1="260" y1="255" x2="540" y2="255" stroke="url(#lineFade)" stroke-width="1.5"/>

  <text x="400" y="325" font-family="Arial, sans-serif" font-size="15" fill="#B89A56" text-anchor="middle" letter-spacing="3">{$label}</text>

  <text x="400" y="410" font-family="Georgia, 'Times New Roman', serif" font-size="16" font-weight="700" fill="#FAFAF6" text-anchor="middle" letter-spacing="2" opacity="0.85">ROMANI COMPLIANCE</text>
</svg>
SVG;
    }
}
