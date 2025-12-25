<link rel="stylesheet" href="{{ asset('css/editar.css') }}">
@extends('landing.principal')
@section('contenido')
    <div class="body">
        <h1>Editar</h1>
        <a href="{{ route('planilla.index') }}" class="boton-volver">Volver</a>
        <form action="{{ route('planilla.update', $planilla->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="fila corta">
                <label for="">Numero</label>
                <input type="text" name="numero" value="{{ $planilla->habitacion->numero }}" required>
            </div>
            <div class="fila">
                <label for="">Entrada</label>
                <input type="datetime-local" name="entrada" value="{{ $planilla->entrada->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="fila">
                <label for="">A/C</label>
                <input type="checkbox" name="ac" {{ $planilla->ac ? 'checked' : '' }}>
            </div>
            <div class="fila corta">
                <label for="">Pago Adelantado</label>
                <input type="text" name="pago_adelantado" value="{{ $planilla->pago_adelantado }}" required>
            </div>
            <button type="submit" class="boton-submit">Editar</button>
        </form>

        {{-- eliminar: --}}
        <form action="{{ route('planilla.destroy', $planilla->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta planilla? La habitación quedará LIBRE.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="boton-submit boton-submit-rojo">Eliminar</button>
        </form>
    </div>

@endsection