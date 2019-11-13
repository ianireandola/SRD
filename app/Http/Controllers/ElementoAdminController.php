<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Elemento;

class ElementoAdminController extends Controller
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
        return view('elemento');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $elementos = Elemento::select('*')
            ->orderBy('elementos.nombre')
            ->get();

        return $elementos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $elemento = new Elemento();
        $elemento->nombre = $request->nombre;
        $elemento->descripcion = $request->descripcion;
        $elemento->estado= $request->estado;
        $elemento->tipoElemento_id = $request->tipoElemento_id;
        $elemento->proyecto_id = $request->proyecto_id;
        $elemento->save();

        return $elemento;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tipoelemento_id)
    {
        $elementos = Elemento::select('elementos.id')
            ->where('elementos.tipoElemento_id', '=', $tipoelemento_id)
            ->count();

        return $elementos;
    }

    public function showProyecto($proyecto_id)
    {
        $num = Elemento::select('elementos.id')
            ->where('elementos.proyecto_id', '=', $proyecto_id)
            ->count();

        return $num;
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

    public function tipoElementoUpdate(Request $request, $id)
    {
        $elemento = Elemento::find($id);
        $elemento->tipoElemento_id = $request->tipoElemento_id;
        $elemento->save();

        return $elemento;
    }

    public function proyectoUpdate(Request $request, $id)
    {
        $elemento = Elemento::find($id);
        $elemento->proyecto_id = $request->proyecto_id;
        $elemento->save();

        return $elemento;
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
        $elemento = Elemento::find($id);
        $elemento->nombre = $request->nombre;
        $elemento->descripcion = $request->descripcion;
        $elemento->estado = $request->estado;
        $elemento->tipoElemento_id = $request->tipoElemento_id;
        $elemento->proyecto_id = $request->proyecto_id;
        $elemento->save();

        return $elemento;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $elemento = Elemento::find($id);
        $elemento->delete();
    }
}
