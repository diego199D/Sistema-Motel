<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


@extends('landing.principal')
@section('titulo', 'Dashboard')

@section('contenido')
<div class="body">
    <h1 class="titulo">Dashboard</h1>
    <div class="contenedor-targetas">
        <div class="targeta-dashboard amarillo">
                <h1>100</h1>
                <p>Clientes</p>
        </div>

        <div class="targeta-dashboard verde">
                <h1>100</h1>
                <p>Bs Total</p>
        </div>

        <div class="targeta-dashboard celeste">
                <h1>100</h1>
                <p>Habitaciones limpias</p>
        </div>

        <div class="targeta-dashboard naranja">
                <h1>100</h1>
                <p>Habitaciones sucias</p>
        </div>
    </div>
</div>
@endsection
