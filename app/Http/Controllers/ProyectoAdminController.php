<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;

class ProyectoAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        return view ('proyecto');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyectos = Proyecto::select('*')
            ->orderBy('proyectos.nombre')
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
        $proyecto = new Proyecto();
        $proyecto->nombre = $request->nombre;
        $proyecto->descripcion = $request->descripcion;
        $proyecto->estado = $request->estado;
        $proyecto->cantidadActual = $request->cantidadActual;
        $proyecto->cantidadTotal = $request->cantidadTotal;
        $proyecto->Ed_PF = $request->Ed_PF;
        $proyecto->ultimaRevision = $request->ultimaRevision;
        $proyecto->fabricacion = $request->fabricacion;
        $proyecto->proyectoPadre_id = $request->proyectoPadre_id;
        $proyecto->save();

        return $proyecto;
    }

    public function showProyectoPadre($proyectoPadre_id)
    {
        $num = Proyecto::select('proyectos.id')
            ->where('proyectos.proyectoPadre_id', '=', $proyectoPadre_id)
            ->count();

        return $num;
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
        $proyecto = Proyecto::find($id);
        $proyecto->nombre = $request->nombre;
        $proyecto->descripcion = $request->descripcion;
        $proyecto->estado = $request->estado;
        $proyecto->cantidadActual = $proyecto->cantidadActual;
        $proyecto->cantidadTotal = $request->cantidadTotal;
        $proyecto->Ed_PF = $request->Ed_PF;
        $proyecto->ultimaRevision = $request->ultimaRevision;
        $proyecto->proyectoPadre_id = $request->proyectoPadre_id;
        $proyecto->fabricacion = $request->fabricacion;
        $proyecto->save();

        return $proyecto;
    }

    public function proyectoPadreUpdate(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->proyectoPadre_id = $request->proyectoPadre_id;
        $proyecto->save();

        return $proyecto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->delete();
    }
}
