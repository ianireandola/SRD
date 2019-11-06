<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hito;

class HitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hitos = Hito::select('*')
            ->orderBy('hitos.nombre')
            ->get();

        return $hitos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($fase_id)
    {
        $hitos = Hito::select('hitos.id')
            ->where('hitos.fase_id', '=', $fase_id)
            ->count();

        return $hitos;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hito = Hito::find($id);
        $hito->fase_id = $request->fase_id;
        $hito->nombre = $request->nombre;
        $hito->descripcion = $request->descripcion;
        $hito->save();

        return $hito;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
