<?php

namespace App\Http\Controllers;

use App\srd_letra;
use App\srd_proyecto;
use App\Proyecto;
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
                'srd_letras.id, srd_letras.fecha, srd_letras.user_id, users.chapa AS "user_nombre", 
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
        $srd_proyectos = srd_proyecto::select('srd_proyectos.id', 'srd_proyectos.fecha', 'srd_proyectos.us_id', 'users.chapa AS user_nombre', 'srd_proyectos.proy_id', 
        'proyectos.nombre AS proyecto_nombre', 'srd_proyectos.acc_id', 'srd_proyectos.el_id', 'srd_proyectos.cantidadHoras', 'srd_proyectos.viaje', 'srd_proyectos.nivel2')
            ->join('users', 'srd_proyectos.us_id', '=', 'users.id')
            ->join('proyectos', 'srd_proyectos.proy_id', '=', 'proyectos.id')
            ->orderBy('srd_proyectos.fecha')
            ->get();

        return $srd_proyectos;
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
    public function show($date)
    {
        $mes = substr($date, -4, 2);
        if($mes == 12)
        {
            $año = substr($date, -8, 4);
            $año = $año + 1;
            $tope = $año."01"."01";
        }else{
            $tope = $date + 100;
        }

        $srd_proyectos = srd_proyecto::select('srd_proyectos.id', 'srd_proyectos.fecha', 'srd_proyectos.us_id', 'users.chapa AS user_nombre', 'srd_proyectos.proy_id', 
        'proyectos.nombre AS proyecto_nombre', 'srd_proyectos.acc_id', 'srd_proyectos.el_id', 'srd_proyectos.cantidadHoras', 'srd_proyectos.viaje', 'srd_proyectos.nivel2')
            ->join('users', 'srd_proyectos.us_id', '=', 'users.id')
            ->join('proyectos', 'srd_proyectos.proy_id', '=', 'proyectos.id')
            ->whereBetween('srd_proyectos.fecha', [$date, $tope])
            ->orderBy('srd_proyectos.fecha')
            ->get();

        return $srd_proyectos;
    }

    public function showLetras($date)
    {
        $mes = substr($date, -4, 2);
        if($mes == 12)
        {
            $año = substr($date, -8, 4);
            $año = $año + 1;
            $tope = $año."01"."01";
        }else{
            $tope = $date + 100;
        }

        $srd_letras = srd_letra::select('srd_letras.id', 'srd_letras.fecha', 'srd_letras.user_id', 'users.chapa AS user_nombre', 'srd_letras.letra_id', 
            'letras.nombre AS letra_nombre', 'srd_letras.cantidadHoras', 'srd_letras.viaje')
            ->join('letras', 'srd_letras.letra_id', '=', 'letras.id')
            ->join('users', 'srd_letras.user_id', '=', 'users.id')
            ->whereBetween('srd_letras.fecha', [$date, $tope])
            ->orderBy('srd_letras.fecha')
            ->get();

        return $srd_letras;
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
