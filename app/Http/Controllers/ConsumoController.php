<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use Illuminate\Http\Request;
use App\Models\Planilla;
class ConsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $consumo = new Consumo();
        $consumo->planilla_id = $request->planilla_id;
        $consumo->nombre = $request->nombre;
        $consumo->cantidad = $request->cantidad;
        $consumo->precio = $request->precio;
        $consumo->save();

        $planilla = Planilla::find($request->planilla_id);
        $nuevo_monto = $consumo->cantidad * $consumo->precio;
        $planilla->monto_consumo = $planilla->monto_consumo + $nuevo_monto;
        $planilla->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Consumo $consumo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consumo $consumo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consumo $consumo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consumo $consumo)
    {
        //
    }
}
