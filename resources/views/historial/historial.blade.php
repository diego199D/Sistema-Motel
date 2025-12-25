@extends('landing.principal')
<link rel="stylesheet" href="{{ asset('css/historial.css') }}">

@section('titulo', 'Historial del dia')

@section('contenido')
    <div class="body">
        <h1>Historial del dia</h1>
        <div class="contenedore">
            <div class="tabla-responsiva">
            <table>
                        <thead>
                            <tr>
                                <th>PIEZA</th>
                                <th>ENTRADA</th>
                                <th>SALIDA</th>
                                <th>A/C</th>
                                <th>CONSUMO</th>
                                <th>PRECIO</th>                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filas as $fila)
                                <tr>
                                    <td>{{ $fila->habitacion->numero }}</td>
                                    <td>{{$fila->entrada}}</td>
                                    <td>{{$fila->salida ? $fila->salida->format('g:i a') : '-'}}</td>
                                    <td>{{$fila->ac}}</td>
                                    <td>
                                        <ul>                                        
                                            @foreach ($fila->consumo as $consumo)
                                                <li>{{ $consumo->cantidad }}  {{$consumo->nombre}} {{$consumo->precio}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{$fila->monto_habitacion}}</td>
                                </tr>   
                            @endforeach                    
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection
