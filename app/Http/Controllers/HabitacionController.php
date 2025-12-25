<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function index() {}

    public function liberar(Request $request)
    {
        $habitacion = Habitacion::where('numero', $request->numero)->first();
        if ($habitacion) {
            $habitacion->estado = 'libre';
            $habitacion->save();
        }

        return redirect()->route('planilla.index');
    }

    public function create()
    {
        // return view('habitacion.create');
    }

    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Habitacion $habitacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habitacion $habitacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitacion $habitacion) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitacion $habitacion)
    {
        //
    }
}
