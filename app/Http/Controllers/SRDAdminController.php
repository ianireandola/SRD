<?php

namespace App\Http\Controllers;

use App\srd_letra;
use App\srd_proyecto;
use App\User;
use Illuminate\Http\Request;

class SRDAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('srd');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLetras()
    {
        $srd_letras = srd_letra::selectRaw(
                'srd_letras.id, srd_letras.fecha, srd_letras.user_id, users.nombre AS "user_nombre", 
                srd_letras.letra_id, letras.nombre AS "letra_nombre", srd_letras.cantidadHoras, srd_letras.viaje')
            ->join('letras', 'srd_letras.letra_id', '=', 'letras.id')
            ->join('users', 'srd_letras.user_id', '=', 'users.id')
            ->orderBy('srd_letras.fecha')
            ->get();

        return $srd_letras;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProyectos()
    {
        $srd_proyectos = srd_proyecto::selectRaw('srd_proyectos.id, srd_proyectos.fecha, srd_proyectos.us_id, users.nombre AS "user_nombre", srd_proyectos.proy_id, 
            proyectos.nombre AS "proyecto_nombre", srd_proyectos.acc_id, accion2s.nombre AS "accion2_nombre", srd_proyectos.el_id, elementos.nombre AS "elemento_nombre", 
            srd_proyectos.fecha, srd_proyectos.cantidadHoras, srd_proyectos.viaje')
            ->join('users', 'srd_proyectos.us_id', '=', 'users.id')
            ->join('proyectos', 'srd_proyectos.proy_id', '=', 'proyectos.id')
            ->join('accion2s', 'srd_proyectos.acc_id', '=', 'accion2s.id')
            ->join('elementos', 'srd_proyectos.el_id', '=', 'elementos.id')
            ->orderBy('srd_proyectos.fecha')
            ->get();

        return $srd_proyectos;
    }

    public function createProyectos2()
    {
        $srd_proyectos = srd_proyecto::selectRaw('srd_proyectos.id, srd_proyectos.fecha, srd_proyectos.us_id, users.nombre AS "user_nombre", srd_proyectos.proy_id, 
            proyectos.nombre AS "proyecto_nombre", srd_proyectos.fecha, srd_proyectos.cantidadHoras, srd_proyectos.viaje')
            ->join('users', 'srd_proyectos.us_id', '=', 'users.id')
            ->join('proyectos', 'srd_proyectos.proy_id', '=', 'proyectos.id')
            ->orderBy('srd_proyectos.fecha')
            ->get();

        return $srd_proyectos;
    }

    public function createUsers()
    {
        $srd_proyectos = srd_proyecto::select('srd_proyectos.us_id')
            ->groupBy('srd_proyectos.us_id')
            ->get();

        return $srd_proyectos;
    }

    public function createNivel2()
    {
        $usuarios = User::selectRaw('users.id AS "id", seccions.nivel2 AS "nivel2"')
            ->join('seccions', 'seccions.id', '=', 'users.seccion_id')
            ->join('srd_proyectos', 'us_id', '=', 'users.id')
            ->groupBy('users.id', 'seccions.nivel2')
            ->get();

        return $usuarios;
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
    public function show($user_id)
    {
        $seccion = Seccion::select('seccions.nivel2')
            ->join('users', 'users.seccion_id', '=', 'seccions.id')
            ->where('users.id', '=', auth()->user()->id)
            ->get();

        return $seccion;
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
