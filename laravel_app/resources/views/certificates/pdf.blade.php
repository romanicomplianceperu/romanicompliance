<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
@page { margin: 0; }
* { box-sizing: border-box; }
body { margin: 0; padding: 0; font-family: 'DejaVu Sans', sans-serif; }

.frame {
  position: relative;
  width: 297mm;
  height: 210mm;
  background: #0B1829;
}
.frame.page2 { page-break-before: always; }

.card {
  position: absolute;
  top: 8mm; left: 8mm; right: 8mm; bottom: 8mm;
  background: #FAFAF6;
  border: 0.6mm solid #8A919D;
}

.sidebar {
  position: absolute;
  top: 0; left: 0;
  width: 68mm;
  height: 194mm;
  background: #0B1829;
}
.sidebar-center {
  padding: 78mm 9mm 0;
}
.sidebar .brand {
  color: #FFFFFF;
  font-family: Georgia, 'Times New Roman', serif;
  font-size: 19pt;
  font-weight: bold;
  letter-spacing: 1px;
}
.sidebar .tagline {
  color: #B89A56;
  font-size: 8pt;
  letter-spacing: 0.5px;
  margin-top: 2mm;
}
.sidebar .course-tag {
  color: rgba(255,255,255,0.45);
  font-size: 7.5pt;
  letter-spacing: 0.5px;
  line-height: 1.6;
  border-top: 0.3mm solid rgba(255,255,255,0.15);
  padding-top: 4mm;
  margin-top: 9mm;
}

.ribbon {
  position: absolute;
  top: 0mm;
  right: 26mm;
  width: 14mm;
  height: 26mm;
  background: #0B1829;
}
.ribbon-cut {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 0 7mm 7mm 7mm;
  border-color: transparent transparent #FAFAF6 transparent;
}

.content {
  position: absolute;
  top: 0; left: 68mm;
  width: 213mm;
  height: 194mm;
}
.content-center {
  padding: 34mm 18mm 0;
}

.eyebrow {
  color: #8B7340;
  font-size: 9pt;
  letter-spacing: 2px;
  font-weight: bold;
  margin-bottom: 3mm;
}
h1.title {
  font-family: Georgia, 'Times New Roman', serif;
  color: #0B1829;
  font-size: 28pt;
  font-weight: bold;
  margin: 0 0 6mm 0;
}

.intro {
  font-size: 10.5pt;
  color: #0B1829;
  margin-bottom: 3mm;
}

.name {
  font-family: Georgia, 'Times New Roman', serif;
  font-size: 22pt;
  font-weight: bold;
  color: #0B1829;
  border-bottom: 0.4mm solid #0B1829;
  display: inline-block;
  padding: 0 3mm 2mm 0;
  margin-bottom: 7mm;
}

.body-text {
  font-size: 10pt;
  color: #333333;
  line-height: 1.55;
  margin-bottom: 4mm;
  max-width: 160mm;
}
.body-text strong { color: #0B1829; }

.meta-line {
  font-size: 9.5pt;
  color: #5A6475;
  margin-top: 2mm;
  margin-bottom: 9mm;
}

.bottom-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 4mm;
}
.bottom-table td {
  vertical-align: bottom;
  padding: 0;
}
.verify-cell { width: 62%; }
.signature-cell { width: 38%; text-align: right; }

.verify-block { width: 120mm; }
.verify-block .qr { float: left; width: 19mm; }
.verify-block .qr img { width: 19mm; height: 19mm; display: block; }
.verify-block .verify-text {
  margin-left: 24mm;
  font-size: 7.5pt;
  color: #5A6475;
  line-height: 1.5;
  padding-top: 1mm;
}
.verify-block .code {
  font-family: Georgia, 'Times New Roman', serif;
  font-weight: bold;
  color: #0B1829;
  font-size: 9pt;
}
.verify-block .clear { clear: both; }

.signature-img { width: 46mm; height: auto; display: inline-block; }

/* ── PAGE 2: TEMARIO ── */
.syllabus-card {
  position: absolute;
  top: 8mm; left: 8mm; right: 8mm; bottom: 8mm;
  background: #FAFAF6;
  border: 0.6mm solid #8A919D;
  padding: 14mm 20mm;
}
.syllabus-topbar {
  display: table;
  width: 100%;
  border-bottom: 0.5mm solid #0B1829;
  padding-bottom: 5mm;
  margin-bottom: 8mm;
}
.syllabus-topbar .brand-mini {
  display: table-cell;
  font-family: Georgia, 'Times New Roman', serif;
  font-size: 13pt;
  font-weight: bold;
  color: #0B1829;
  vertical-align: bottom;
}
.syllabus-topbar .code-mini {
  display: table-cell;
  text-align: right;
  font-size: 8.5pt;
  color: #5A6475;
  vertical-align: bottom;
}
.syllabus-eyebrow {
  color: #8B7340;
  font-size: 9pt;
  letter-spacing: 2px;
  font-weight: bold;
  margin-bottom: 2mm;
}
.syllabus-title {
  font-family: Georgia, 'Times New Roman', serif;
  color: #0B1829;
  font-size: 19pt;
  font-weight: bold;
  margin-bottom: 8mm;
  max-width: 220mm;
}
.syllabus-columns { display: table; width: 100%; table-layout: fixed; }
.syllabus-col { display: table-cell; width: 50%; vertical-align: top; padding-right: 10mm; }
.syllabus-col:last-child { padding-right: 0; padding-left: 10mm; }
.syllabus-module { margin-bottom: 6mm; }
.syllabus-module-title {
  font-family: Georgia, 'Times New Roman', serif;
  font-size: 11.5pt;
  font-weight: bold;
  color: #0B1829;
  margin-bottom: 2mm;
  padding-bottom: 1.5mm;
  border-bottom: 0.3mm solid #DDD9D0;
}
.syllabus-lessons { margin: 0; padding: 0; list-style: none; }
.syllabus-lessons li {
  font-size: 9pt;
  color: #333333;
  padding: 1.3mm 0;
  line-height: 1.4;
}
.syllabus-type {
  font-size: 7.5pt;
  color: #8B7340;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}
.syllabus-signature-row {
  position: absolute;
  bottom: 24mm; right: 20mm;
  text-align: center;
}
.syllabus-signature-row img { width: 40mm; height: auto; }
.syllabus-footer {
  position: absolute;
  bottom: 10mm; left: 20mm; right: 20mm;
  font-size: 7.5pt;
  color: #8A919D;
  border-top: 0.3mm solid #DDD9D0;
  padding-top: 3mm;
  text-align: center;
}
</style>
</head>
<body>
<div class="frame">
  <div class="card">
    <div class="sidebar">
      <div class="sidebar-center">
        <div class="brand">ROMANI.</div>
        <div class="tagline">Compliance, Advisory &amp; Due Diligence</div>
        <div class="course-tag">{{ \Illuminate\Support\Str::upper($certificate->course->title) }}</div>
      </div>
    </div>

    <div class="ribbon"><div class="ribbon-cut"></div></div>

    <div class="content">
      <div class="content-center">
        <div class="eyebrow">CERTIFICADO DE FINALIZACIÓN</div>
        <h1 class="title">Certificado</h1>

        <div class="intro">Romani Compliance otorga el presente certificado a:</div>
        <div class="name">{{ $certificate->holderDisplayName() }}</div>

        <div class="body-text">
          Por haber culminado satisfactoriamente el curso <strong>&laquo;{{ $certificate->course->title }}&raquo;</strong>,
          aprobando la evaluación correspondiente con el puntaje requerido por el programa.
        </div>
        <div class="meta-line">
          Emitido el {{ $certificate->issued_at->translatedFormat('d \d\e F \d\e Y') }}
          &middot; Duración: {{ $certificate->course->lectiveHours() }} {{ $certificate->course->lectiveHours() === 1 ? 'hora lectiva' : 'horas lectivas' }}
        </div>

        <table class="bottom-table">
          <tr>
            <td class="verify-cell">
              <div class="verify-block">
                <div class="qr"><img src="{{ $qrDataUri }}" alt="QR"></div>
                <div class="verify-text">
                  <div class="code">{{ $certificate->code }}</div>
                  Verifique la autenticidad de este certificado en<br>{{ $verifyUrl }}
                </div>
                <div class="clear"></div>
              </div>
            </td>
            <td class="signature-cell">
              <img src="{{ $signatureDataUri }}" alt="Firma" class="signature-img">
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="frame page2">
  <div class="syllabus-card">
    <div class="syllabus-topbar">
      <div class="brand-mini">ROMANI.</div>
      <div class="code-mini">Certificado {{ $certificate->code }}</div>
    </div>

    <div class="syllabus-eyebrow">TEMARIO DEL CURSO</div>
    <div class="syllabus-title">{{ $certificate->course->title }}</div>

    <div class="syllabus-columns">
      @foreach($certificate->course->modules->chunk((int) ceil(max($certificate->course->modules->count(), 1) / 2)) as $columnModules)
        <div class="syllabus-col">
          @foreach($columnModules as $module)
            <div class="syllabus-module">
              <div class="syllabus-module-title">{{ sprintf('%02d', $module->order) }}. {{ $module->title }}</div>
              <ul class="syllabus-lessons">
                @foreach($module->lessons as $lesson)
                  <li>{{ $lesson->title }} <span class="syllabus-type">&middot; {{ $lesson->typeLabel() }}</span></li>
                @endforeach
              </ul>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>

    <div class="syllabus-signature-row">
      <img src="{{ $signatureDataUri }}" alt="Firma">
    </div>

    <div class="syllabus-footer">ROMANI. Compliance, Advisory &amp; Due Diligence &middot; Verifique este certificado en {{ $verifyUrl }}</div>
  </div>
</div>
</body>
</html>
