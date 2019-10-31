<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProyectoPadre;

class ProyectoPadreController extends Controller
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
        $proyectospadre = ProyectoPadre::select('*')
            ->orderBy('proyecto_padres.nombre')
            ->get();

        return $proyectospadre;
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
    public function edit($nacion_id)
    {
        $proyectospadre = ProyectoPadre::select('proyecto_padres.id')
            ->where('proyecto_padres.nacion_id', '=', $nacion_id)
            ->count();

        return $proyectospadre;
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
        //
    }

    public function nacionUpdate(Request $request, $id)
    {
        $proyectopadre = ProyectoPadre::find($id);
        $proyectopadre->nacion_id = $request->nacion_id;
        $proyectopadre->save();

        return $proyectopadre;
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
