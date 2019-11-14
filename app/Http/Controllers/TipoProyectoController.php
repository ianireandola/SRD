<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoProyecto;

class TipoProyectoController extends Controller
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
        return view('tipo_proyecto');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos_proyecto = TipoProyecto::select('*')
            ->orderBy('tipo_proyectos.nombre')
            ->get();

        return $tipos_proyecto;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo_proyecto = new TipoProyecto();
        $tipo_proyecto->nombre = $request->nombre;
        $tipo_proyecto->save();

        return $tipo_proyecto;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipo_proyecto = TipoProyecto::select('tipo_proyectos.nombre')
            ->where('tipos_proyecto.id', '=', $id)
            ->get();
    
        return $tipo_proyecto;
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
        $tipo_proyecto = TipoProyecto::find($id);
        $tipo_proyecto->nombre = $request->nombre;
        $tipo_proyecto->save();

        return $tipo_proyecto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo_proyecto = TipoProyecto::find($id);
        $tipo_proyecto->delete();
    }
}
