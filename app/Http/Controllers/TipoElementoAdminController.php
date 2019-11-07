<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoElemento;

class TipoElementoAdminController extends Controller
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
        return view ('tipo-elemento');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo_elementos = TipoElemento::select('*')
            ->orderBy('tipo_elementos.nombre')
            ->get();

        return $tipo_elementos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo_elemento = new TipoElemento();
        $tipo_elemento->nombre = $request->nombre;
        $tipo_elemento->save();

        return $tipo_elemento;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tipoelemento_id)
    {
        $tipo_elementos = TipoElemento::select('composicion.tipoElemento_id')
            ->where('tipo_elementos.id', '=', $tipoelemento_id)
            ->join('composicion', 'composicion.tipoElemento_id', '=', 'tipo_elementos.id')
            ->count();

        return $tipo_elementos;
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
        $tipo_elemento = TipoElemento::find($id);
        $tipo_elemento->nombre = $request->nombre;
        $tipo_elemento->save();

        return $tipo_elemento;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo_elemento = TipoElemento::find($id);
        $tipo_elemento->delete();
    }
}
