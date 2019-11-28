<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProyectoPadre;

class ProyectoPadreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('proyecto-padre');
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
        $proyecto_padre = new ProyectoPadre();
        $proyecto_padre->nombre = $request->nombre;
        $proyecto_padre->descripcion = $request->descripcion;
        $proyecto_padre->estado = $request->estado;
        $proyecto_padre->Q_Proyecto = $request->Q_Proyecto;
        $proyecto_padre->planificacion = $request->planificacion;
        $proyecto_padre->safety = $request->safety;
        $proyecto_padre->homologaciones = $request->homologaciones;
        $proyecto_padre->tipoProyecto_id = $request->tipoProyecto_id;
        $proyecto_padre->nacion_id = $request->nacion_id;
        $proyecto_padre->dedicacion_id = '1';
        $proyecto_padre->save();

        return $proyecto_padre;
    }

    public function showAvance($proyectoPadre_id)
    {
        $num = ProyectoPadre::select('proyecto_padres.id')
            ->join('avance_proyecto', 'proyecto_padres.id', '=', 'avance_proyecto.proyectoPadre_id')
            ->where('avance_proyecto.proyectoPadre_id', '=', $proyectoPadre_id)
            ->count();

        return $num;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tipoProyecto_id)
    {
        $proyectospadre = ProyectoPadre::select('proyecto_padres.id')
            ->where('proyecto_padres.tipoProyecto_id', '=', $tipoProyecto_id)
            ->count();

        return $proyectospadre;
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
        $proyecto_padre = ProyectoPadre::find($id);
        $proyecto_padre->nombre = $request->nombre;
        $proyecto_padre->descripcion = $request->descripcion;
        $proyecto_padre->estado = $request->estado;
        $proyecto_padre->Q_Proyecto = $request->Q_Proyecto;
        $proyecto_padre->planificacion = $request->planificacion;
        $proyecto_padre->safety = $request->safety;
        $proyecto_padre->homologaciones = $request->homologaciones;
        $proyecto_padre->tipoProyecto_id = $request->tipoProyecto_id;
        $proyecto_padre->nacion_id = $request->nacion_id;
        $proyecto_padre->dedicacion_id = '1';
        $proyecto_padre->save();

        return $proyecto_padre;
    }

    public function nacionUpdate(Request $request, $id)
    {
        $proyectopadre = ProyectoPadre::find($id);
        $proyectopadre->nacion_id = $request->nacion_id;
        $proyectopadre->save();

        return $proyectopadre;
    }

    public function tipoProyectoUpdate(Request $request, $id)
    {
        $proyectopadre = ProyectoPadre::find($id);
        $proyectopadre->tipoProyecto_id = $request->tipoProyecto_id;
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
        $proyecto_padre = ProyectoPadre::find($id);
        $proyecto_padre->delete();
    }
}
