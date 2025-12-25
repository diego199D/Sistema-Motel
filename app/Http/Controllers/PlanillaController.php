<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Planilla;
use Illuminate\Http\Request;

class PlanillaController extends Controller
{
    public function index()
    {
        $habitaciones = Habitacion::all();
        $activas = Planilla::with('habitacion')->whereNull('salida')->get();
        $limpias = Habitacion::where('estado', 'libre')->get();
        $sucias = Habitacion::where('estado', 'sucia')->get();

        return view('planilla.planilla', compact('habitaciones', 'activas', 'limpias', 'sucias'));
    }

    public function historial()
    {
        $habitacion_archivada = Planilla::with('habitacion')->whereNotNull('salida')->get();
        $filas = Planilla::where('monto_habitacion', '>', 0)->get();

        return view('historial.historial', compact('habitacion_archivada', 'filas'));
    }

    public function create()
    {
        return view('planilla.planilla');
    }

    public function store(Request $request)
    {
        $habitacion = Habitacion::where('numero', $request->habitacion_id)->first();
        if (! $habitacion) {
            return redirect()->back();
        }

        $planilla = new Planilla;
        $planilla->habitacion_id = $habitacion->id;
        $planilla->fecha = now()->toDateString();
        $planilla->entrada = now();
        $planilla->pago_adelantado = $request->pago_adelantado ?? 0;
        $planilla->ac = $request->has('ac');
        $planilla->monto_habitacion = $request->monto_habitacion;
        $planilla->monto_total = $request->monto_habitacion;
        $planilla->save();

        $habitacion->update(['estado' => 'ocupada']);

        return redirect()->route('planilla.index');
    }

    public function finalizar(Request $request)
    {
        $planilla = Planilla::find($request->planilla_id);

        $planilla->salida = $request->fecha_salida; // La hora que editaste o la actual
        $planilla->monto_total = $request->monto_final; // El total calculado

        // (Opcional) Si quieres guardar el costo de habitacion separado tambien:
        $planilla->monto_habitacion = $request->monto_final - $planilla->monto_consumo;
        $planilla->monto_habitacion = $request->monto_habitacion;
        $planilla->save();

        // 3. Cambiamos el estado de la habitación a "sucia"
        $habitacion = $planilla->habitacion;
        $habitacion->update(['estado' => 'sucia']);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Planilla $planilla) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Planilla $planilla)
    {
        return view('editar.editar', compact('planilla'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Planilla $planilla)
    {
        $habitacion_nueva = Habitacion::where('numero', $request->numero)->first();

        if ($habitacion_nueva && $habitacion_nueva->id != $planilla->habitacion_id) {
            $habitacion_vieja = Habitacion::find($planilla->habitacion_id);
            if ($habitacion_vieja) {
                $habitacion_vieja->update(['estado' => 'libre']);
            }
            $habitacion_nueva->update(['estado' => 'ocupada']);
            $planilla->habitacion_id = $habitacion_nueva->id;
        }

        $planilla->entrada = $request->entrada;
        $planilla->ac = $request->has('ac');
        $planilla->pago_adelantado = $request->pago_adelantado;
        $planilla->save();

        return redirect()->route('planilla.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Planilla $planilla)
    {
        // 1. Buscamos la habitación y la liberamos
        $habitacion = Habitacion::find($planilla->habitacion_id);
        if ($habitacion) {
            $habitacion->update(['estado' => 'sucia']);
        }

        // 2. Borramos la planilla
        $planilla->delete();

        // 3. Volvemos al inicio
        return redirect()->route('planilla.index');
    }
}
