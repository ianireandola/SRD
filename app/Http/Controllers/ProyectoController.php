<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\User;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = User::select('users.seccion_id')
            ->where('users.id', '=', auth()->id())
            ->get();

        echo($usuario);

        $proyectos = Proyecto::select('proyectos.id', 'proyectos.nombre', 'proyectos.descripcion', 'proyectos.estado')
            ->join('trabajan', 'trabajan.proyecto_id', '=', 'proyectos.id')
            ->where('trabajan.seccion_id', '=', $usuario)
            ->get();    

        return $proyectos;

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $proyectos = Proyecto::select('proyectos.id', 'proyectos.nombre', 'proyectos.descripcion', 'proyectos.estado')
            ->join('trabajan', 'trabajan.proyecto_id', '=', 'proyectos.id')
            ->where('trabajan.seccion_id', '=', $id)
            ->get();    

        return $proyectos;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
