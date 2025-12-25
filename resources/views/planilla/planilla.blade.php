@extends('landing.principal')
<link rel="stylesheet" href="{{ asset('css/planilla.css') }}">
@section('titulo', 'Planilla')

@section('contenido')
    <div class="body">
        <h1>Planilla</h1>

        <div class="contenedore">
            <div class="contenedor-registro-pieza"> 
                <form action="{{ route('habitacion.liberar') }}" method="POST">
                    @csrf
                    <label for="">Anadir habitacion</label>
                    <input type="text" autocomplete="off" name="numero" required>
                    <button type="submit" class="boton-submit">Anadir</button>
                </form>
            </div>

            <div class="contenedor-piezas">
                <div class="piezas">
                    <h3>Habitaciones libres</h3>
                    <div class="grid-habitacion-libre">
                        @foreach($limpias as $limpia)
                            <div class="cuadrito">
                                <h1>{{ $limpia->numero }}</h1>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="piezas">
                    <h3>Habitaciones sucias</h3>
                    <div class="grid-habitacion-sucia">
                        @foreach($sucias as $sucia)
                            <div class="cuadrito">
                                <h1>{{ $sucia->numero }}</h1>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="contenedor-registro-cliente">
                <form action="{{ route('planilla.store')}}" method="POST">
                @csrf
                    <div class="fila">
                        <label>Habitación:</label>
                        <input type="text" name="habitacion_id"  autocomplete="off" required >
                    </div>

                    <div class="fila">
                        <label>A/C:</label>
                        <input type="checkbox" name="ac" >
                    </div>

                    <div class="fila">
                        <label>Pago:</label>
                        <input type="text" name="pago_adelantado" autocomplete="off">
                    </div>
                    <button type="submit" class="boton-submit">Ingreso</button>
                </form>
            </div>
            <div class="tabla-responsiva">
                <div class="contenedor-clientes-dentro">
                    <table class="tabla-clientes-dentro">
                        <thead>
                            <tr>
                                <th>PIEZA</th>
                                <th>ACCIONES</th>
                                <th>ENTRADA</th>
                                <th>CONSUMO</th>
                                <th>A/C</th>
                                <th>PAGADO</th>                            
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($activas as $activa)
                            <tr>                                
                                <td>{{$activa->habitacion->numero}}</td>
                                <td>                                    
                                    <a href="{{ route('planilla.editar', $activa->id) }}" class="boton-tabla-editar">
                                        Editar
                                    </a>
                                    <button type="button" class="boton-tabla verde" 
                                        onclick="abrirCobro(
                                            {{ $activa->id }}, 
                                            '{{ $activa->entrada->toIso8601String() }}', 
                                            {{ number_format($activa->monto_consumo ?? 0, 2, '.', '') }}, 
                                            {{ number_format($activa->pago_adelantado ?? 0, 2, '.', '') }}, 
                                            {{ $activa->ac ? 1 : 0 }} 
                                        )">
                                        Salida
                                    </button>

                                    <dialog id="modal-salida-{{ $activa->id }}" class="modal-salida">
                                        <h2>Habitación {{ $activa->habitacion->numero}}</h2>
                                        
                                        <h5><span class="titulo">Entrada:</span> {{ $activa->entrada->format('g:i a') }}</h5>
                                        
                                        <div class="campo-salida">
                                            <span class="titulo">Salida:</span>
                                            <input type="datetime-local" id="input-salida-{{ $activa->id }}" 
                                                class="input-fecha"
                                                onchange="recalcular('{{ $activa->id }}', '{{ $activa->entrada->toIso8601String() }}', {{ $activa->habitacion->precio }}, {{ $activa->monto_consumo ?? 0 }}, {{ $activa->pago_adelantado ?? 0 }}, {{ $activa->ac ? 1 : 0 }})">
                                        </div>

                                        <div class="contenedor-tabla-scroll">
                                            <table class="tabla-consumo">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Cant.</th>
                                                        <th>Precio</th>  
                                                    </tr>                                       
                                                </thead>
                                                <tbody>                                                                         
                                                    @forelse($activa->consumo ?? [] as $consu)
                                                        <tr>
                                                            <td>{{ $consu->nombre }}</td>
                                                            <td>{{ $consu->cantidad }}</td>
                                                            <td>{{ $consu->precio * $consu->cantidad }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="3">No hay consumos</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <h5><span class="titulo">Pago Adelantado:</span> -{{ $activa->pago_adelantado ?? 0 }} bs</h5>
                                        <h5><span class="titulo">Consumo total:</span> {{ $activa->monto_consumo ?? 0 }} bs</h5>
                                        
                                        <h5><span class="titulo">Tiempo Total:</span> <span id="txt-tiempo-{{ $activa->id }}">...</span></h5>
                                        
                                        <h5><span class="titulo">Precio Habitación:</span> <span id="txt-precio-hab-{{ $activa->id }}">0</span> bs</h5>
                                        
                                        <h4 class="texto-total">
                                            <span class="texto-dinero">PRECIO TOTAL: <span id="txt-total-{{ $activa->id }}">0</span> bs </span>
                                        </h4>

                                        <div class="contenedor-botones">
                                            <form method="dialog">
                                                <button class="boton-submit">Cerrar</button>
                                            </form>
                                            
                                            <form action="{{ route('planilla.finalizar') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="planilla_id" value="{{ $activa->id }}">
                                                <input type="hidden" name="fecha_salida" id="hidden-fecha-{{ $activa->id }}">
                                                <input type="hidden" name="monto_final" id="hidden-total-{{ $activa->id }}">
                                                <input type="hidden" name="monto_habitacion" id="hidden-precio-hab-{{ $activa->id }}">
                                                <button type="submit" class="boton-submit">DESPACHAR</button>
                                            </form>
                                        </div>
                                    </dialog>
                                </td>
                                <td>{{ $activa->entrada->format('g:i a') }}</td>
                                <td>
                                    {{ $activa->monto_consumo}}
                                    <button type="submit" class="boton-tabla" onclick="document.getElementById('mi-modal-{{ $activa->id }}').showModal()">Add</button>
                                    <dialog class="mi-modal" id="mi-modal-{{ $activa->id }}">
                                        <h4>Habitacion {{$activa->habitacion->numero}}</h4>
                                        
                                        <table class="tabla-consumo">
                                            <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>  
                                            </tr>                                              
                                            </thead>
                                            <tbody>                                                                                        
                                                @forelse($activa->consumo as $consu)
                                                    <tr>
                                                        <td>{{ $consu->nombre }}</td>
                                                        <td>{{ $consu->cantidad }}</td>
                                                        <td>{{ $consu->precio }}</td>
                                                    </tr>
                                                @empty
                                                        <tr><td>No hay consumos</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        {{-- anadir mas productos --}}
                                        <form action="{{ route('consumo.store') }}" method="POST" class="anadir-consumo">
                                        @csrf                                            
                                            <input type="hidden" name="planilla_id" value="{{ $activa->id}}">
                                            <div class="inputs-consumo">    
                                                <label>Nombre</label>
                                                <input type="text" name="nombre" autocomplete="off" required>
                                            </div>
                                            <div class="inputs-consumo">
                                                <label>Cantidad</label>
                                                <input type="text" name="cantidad" autocomplete="off" required>
                                            </div>
                                            <div class="inputs-consumo">
                                                <label>Precio</label>
                                                <input type="text" name="precio" autocomplete="off" required>
                                            </div>
                                            <button type="submit" class="boton-submit">Agregar</button>
                                        </form>                                               
                                    
                                        <form method="dialog">
                                            <button class="boton-cerrar-modal">Cerrar</button>
                                        </form>
                                    </dialog>
                                </td>
                                <td>{{ $activa->ac ? 'SI' : 'NO'}}</td>
                                <td>{{ $activa->pago_adelantado}}</td> 
                            </tr>                            
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>






    <script>
    // Función que llama el botón directamente
    function abrirCobro(id, fechaEntrada, consumo, adelanto, tieneAire) {
        // 1. Poner hora actual
        const ahora = new Date();
        ahora.setMinutes(ahora.getMinutes() - ahora.getTimezoneOffset());
        
        const inputSalida = document.getElementById('input-salida-' + id);
        if(inputSalida) inputSalida.value = ahora.toISOString().slice(0, 16);

        // 2. Calcular
        recalcular(id, fechaEntrada, consumo, adelanto, tieneAire);

        // 3. ABRIR MODAL
        document.getElementById('modal-salida-' + id).showModal();
    }

    // Función de cálculo con precios FIJOS (30 y 35)
    function recalcular(id, fechaEntradaStr, consumo, adelanto, tieneAire) {
        const entrada = new Date(fechaEntradaStr);
        const inputVal = document.getElementById('input-salida-' + id).value;
        const salida = inputVal ? new Date(inputVal) : new Date();

        let diffMs = salida - entrada;
        if (diffMs < 0) diffMs = 0;
        
        let minutosTotales = Math.floor(diffMs / 1000 / 60);
        let horas = Math.floor(minutosTotales / 60);
        let minutos = minutosTotales % 60;
        
        let costoHab = 0;

        if (tieneAire == 1) {
            // CON AIRE: 35bs la primera hora (hasta 76 min), luego 30bs la hora
            if (minutosTotales <= 76) {
                costoHab = 35; 
            } else {
                costoHab = horas * 30; 
                if (minutos >= 24) costoHab += 30; 
                else if (minutos >= 17) costoHab += 15;
            }
        } else {
            // SIN AIRE: 30bs siempre la base, extras a 20bs
            if (horas === 0 && minutos === 0) costoHab = 0;
            else if (horas === 0) costoHab = 30; 
            else {
                costoHab = 30; 
                let horasExtras = horas - 1;
                costoHab += horasExtras * 20; 
                
                if (minutos >= 24) costoHab += 20;
                else if (minutos >= 17) costoHab += 10;
            }
        }

        let totalPagar = (costoHab + consumo) - adelanto;
        if (totalPagar < 0) totalPagar = 0;

        // Pintar en pantalla
        document.getElementById('txt-tiempo-' + id).innerText = `${horas}h ${minutos}m`;
        document.getElementById('txt-precio-hab-' + id).innerText = costoHab.toFixed(2);
        document.getElementById('txt-total-' + id).innerText = totalPagar.toFixed(2);

        // Llenar inputs ocultos para guardar
        const hiddenFecha = document.getElementById('hidden-fecha-' + id);
        const hiddenTotal = document.getElementById('hidden-total-' + id);
        
        // --- AQUÍ ESTÁ EL AGREGADO PARA GUARDAR EL DATO EN LA BD ---
        const hiddenPrecioHab = document.getElementById('hidden-precio-hab-' + id);
        
        if(hiddenFecha) hiddenFecha.value = inputVal;
        if(hiddenTotal) hiddenTotal.value = totalPagar.toFixed(2);
        
        // Guardamos el costo solo de la habitación
        if(hiddenPrecioHab) hiddenPrecioHab.value = costoHab.toFixed(2);
    }
</script>

@endsection
