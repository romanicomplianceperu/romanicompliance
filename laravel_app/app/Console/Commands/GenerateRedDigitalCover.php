<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateRedDigitalCover extends Command
{
    protected $signature = 'courses:generate-red-digital-cover';

    protected $description = 'Genera una portada SVG profesional para el curso ligado al proyecto Red Digital, con buena composición y el nombre del cliente visible.';

    public function handle(): int
    {
        $course = Course::where('slug', 'splaft-integral')->first();

        if (! $course) {
            $this->error('No se encontró el curso splaft-integral.');

            return self::FAILURE;
        }

        $path = 'courses/covers/splaft-integral-red-digital.svg';

        $svg = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 450" width="800" height="450">
  <defs>
    <radialGradient id="glow" cx="82%" cy="15%" r="65%">
      <stop offset="0%" stop-color="#8B7340" stop-opacity="0.4"/>
      <stop offset="100%" stop-color="#8B7340" stop-opacity="0"/>
    </radialGradient>
  </defs>
  <rect width="800" height="450" fill="#0B1829"/>
  <rect width="800" height="450" fill="url(#glow)"/>
  <g stroke="#1C2E45" stroke-width="1.5" opacity="0.6">
    <line x1="0" y1="380" x2="420" y2="0"/>
    <line x1="120" y1="450" x2="560" y2="0"/>
    <line x1="280" y1="450" x2="720" y2="0"/>
  </g>
  <circle cx="640" cy="140" r="90" fill="none" stroke="#B89A56" stroke-width="1.2" stroke-dasharray="3 6" opacity="0.6"/>
  <g transform="translate(640,140)" stroke="#B89A56" stroke-width="1.6" fill="none" opacity="0.9">
    <line x1="0" y1="0" x2="-46" y2="-30"/>
    <line x1="0" y1="0" x2="50" y2="-22"/>
    <line x1="0" y1="0" x2="-38" y2="34"/>
    <line x1="0" y1="0" x2="44" y2="38"/>
  </g>
  <g fill="#0B1829" stroke="#B89A56" stroke-width="2">
    <circle cx="640" cy="140" r="9"/>
    <circle cx="594" cy="110" r="5"/>
    <circle cx="690" cy="118" r="5"/>
    <circle cx="602" cy="174" r="5"/>
    <circle cx="684" cy="178" r="5"/>
  </g>
  <text x="64" y="170" font-family="Arial, sans-serif" font-size="13" font-weight="700" fill="#8B7340" letter-spacing="3">CAPACITACIÓN EMPRESARIAL</text>
  <text x="64" y="222" font-family="Georgia, 'Times New Roman', serif" font-size="40" font-weight="bold" fill="#FAFAF6">SPLAFT Integral</text>
  <text x="64" y="264" font-family="Georgia, 'Times New Roman', serif" font-size="24" fill="#B89A56">para Red Digital</text>
  <text x="64" y="392" font-family="Arial, sans-serif" font-size="14" fill="#8A919D" letter-spacing="1">Exclusivo para personal de Red Digital del Perú S.A.C.</text>
</svg>
SVG;

        Storage::disk('public')->put($path, $svg);
        $course->update(['cover_image' => $path]);

        $this->info('Portada de Red Digital generada correctamente.');

        return self::SUCCESS;
    }
}
