<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seccion;
use App\Proyecto;
use App\srd_proyecto;
use App\srd_letra;

class SRDProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secciones = Seccion::select('seccions.id', 'seccions.nombre')    
            ->join('c_v', 'c_v.seccion_id', '=', 'seccions.id')
            ->where([
                ['seccions.nivel2', '=', 'seccions.id'],
                ['c_v.user_id', '=', auth()->id()]
            ])
            ->get();
        
            return $secciones;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyectos = Proyecto::select('srd_proyectos.id', 'srd_proyectos.fecha', 'proyectos.nombre', 'srd_proyectos.acc_id', 
                                        'srd_proyectos.el_id', 'srd_proyectos.cantidadHoras', 'srd_proyectos.viaje')
            ->join('srd_proyectos', 'proyectos.id', '=', 'srd_proyectos.proy_id')
            ->where('srd_proyectos.us_id', '=', auth()->id())
            ->orderBy('srd_proyectos.fecha')
            ->get();

        return $proyectos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seccion_user_nivel2 = $request->input('seccion_user_nivel2');
        
        //SRD_proyecto de nivel 2 (con accion2 y elemento)
        if($seccion_user_nivel2 === 1)
        {
            $srd_proyecto = new srd_proyecto();
            $srd_proyecto->proy_id = $request->proyecto_id;
            $srd_proyecto->us_id = $request->user_id;
            $srd_proyecto->acc_id = $request->accion2_id;
            $srd_proyecto->el_id = $request->elemento_id;
            $srd_proyecto->fecha = $request->fecha;
            $srd_proyecto->cantidadHoras = $request->cantidadHoras;
            $srd_proyecto->viaje = $request->viaje;

            $srd_proyecto->save();
        }else{
            $srd_proyecto = new srd_proyecto();
            $srd_proyecto->proy_id = $request->proyecto_id;
            $srd_proyecto->us_id = $request->user_id;
            $srd_proyecto->fecha = $request->fecha;
            $srd_proyecto->cantidadHoras = $request->cantidadHoras;
            $srd_proyecto->viaje = $request->viaje;

            $srd_proyecto->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($fecha)
    {
        $proyectos = Proyecto::select('srd_proyectos.id', 'srd_proyectos.fecha', 'proyectos.nombre', 'srd_proyectos.acc_id', 'srd_proyectos.el_id', 
                                    'srd_proyectos.cantidadHoras', 'srd_proyectos.viaje')
            ->join('srd_proyectos', 'proyectos.id', '=', 'srd_proyectos.proy_id')
            ->where('srd_proyectos.fecha', '=', $fecha)
            ->get();

        return $proyectos;
    }

    public function showAccion2($accion2_id)
    {
        $num = srd_proyecto::select('srd_proyectos.id')
            ->where('srd_proyectos.acc_id', '=', $accion2_id)
            ->count();

        return $num;
    }

    public function showElemento($elemento_id)
    {
        $num = srd_proyecto::select('srd_proyectos.id')
            ->where('srd_proyectos.el_id', '=', $elemento_id)
            ->count();

        return $num;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($fecha)
    {
        $srd_proyectos = srd_proyecto::select('srd_proyectos.id')
            ->where('srd_proyectos.fecha', '=', $fecha)
            ->count();

        $srd_letras = srd_letra::select('srd_letras.id')
            ->where('srd_letras.fecha', '=', $fecha)
            ->count();

        $srd_total = $srd_letras + $srd_proyectos;

        return $srd_total;
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
        $srd_proyecto = srd_proyecto::find($id);
        $srd_proyecto->delete();
    }
}
