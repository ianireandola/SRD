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

        $proyectos = Proyecto::select('proyectos.id', 'proyectos.identificador', 'proyectos.nombre', 'proyectos.estado')
            ->join('trabajan', 'trabajan.proyecto_id', '=', 'proyectos.id')
            ->where('trabajan.seccion_id', '=', $usuario)
            ->get();    

        return $proyectos;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proyectos = Proyecto::select('proyectos.id', 'proyectos.identificador', 'proyectos.nombre', 'proyectos.estado')
            ->join('trabajan', 'trabajan.proyecto_id', '=', 'proyectos.id')
            ->where('trabajan.seccion_id', '=', $id)
            ->get();    

        return $proyectos;
    }

}
