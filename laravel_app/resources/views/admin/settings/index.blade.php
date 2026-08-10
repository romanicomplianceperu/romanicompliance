@extends('admin.layout')

@section('title', 'Personalización del sitio')

@section('content')
<div class="page-head">
  <h2 style="font-size:1.15rem">Personalización del sitio</h2>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
  @csrf @method('PUT')

  @foreach($groups as $groupName => $fields)
    <div class="card">
      <h3 style="font-size:1rem;margin-bottom:1rem;">{{ $groupName }}</h3>
      @foreach($fields as $key => $field)
        <div class="form-group">
          <label>{{ $field['label'] }}</label>
          @if($field['type'] === 'textarea')
            <textarea name="{{ $key }}">{{ old($key, $values[$key] ?? '') }}</textarea>
          @else
            <input type="text" name="{{ $key }}" value="{{ old($key, $values[$key] ?? '') }}">
          @endif
        </div>
      @endforeach
    </div>
  @endforeach

  <button type="submit" class="btn btn-gold">Guardar cambios</button>
</form>
@endsection
