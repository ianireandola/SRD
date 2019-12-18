<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seccion;

class SeccionAdminController extends Controller
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
        return view('seccion');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $secciones = Seccion::select('*')
            ->orderBy('seccions.identificador')
            ->get();

        return $secciones;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seccion = new Seccion();
        $seccion->identificador = $request->identificador;
        $seccion->nombre = $request->nombre;
        $seccion->nivel2 = $request->nivel2;
        $seccion->area_id = $request->area_id;
        $seccion->planta_id = $request->planta_id;
        $seccion->save();

        return $seccion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($area_id)
    {
        $secciones = Seccion::select('seccions.id')
            ->where('seccions.area_id', '=', $area_id)
            ->count();

        return $secciones;
    }

    public function showSeccion($seccion_id)
    {
        $secciones = Seccion::select('*')
            ->where('seccions.id', '=', $seccion_id)
            ->get();
    
        return $secciones;
    }

    public function showTrabajan($seccion_id)
    {
        $num = Seccion::select('seccions.id')
            ->join('trabajan', 'seccions.id', '=', 'trabajan.seccion_id')
            ->where('trabajan.seccion_id', '=', $seccion_id)
            ->count();

        return $num;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($planta_id)
    {
        $secciones = Seccion::select('seccions.id')
            ->where('seccions.planta_id', '=', $planta_id)
            ->count();

        return $secciones;
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
        $seccion = Seccion::find($id);
        $seccion->identificador = $request->identificador;
        $seccion->nombre = $request->nombre;
        $seccion->nivel2 = $request->nivel2;
        $seccion->area_id = $request->area_id;
        $seccion->planta_id = $request->planta_id;
        $seccion->save();

        return $seccion; 
    }

    public function areaUpdate()
    {
        $seccion = Seccion::find($id);
        $seccion->area_id = $request->area_id;
        $seccion->save();

        return $seccion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seccion = Seccion::find($id);
        $seccion->delete();
    }
}
