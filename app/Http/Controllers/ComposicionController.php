<?php

namespace App\Http\Controllers;

use App\Composicion;
use Illuminate\Http\Request;

class ComposicionController extends Controller
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
        return view ('composicion');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $composiciones = Composicion::select('*')
            ->orderBy('composicion.proyecto_id')
            ->get();

        return $composiciones;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $composicion = new Composicion();
        $composicion->proyecto_id = $request->proyecto_id;
        $composicion->tipoElemento_id = $request->tipoElemento_id;
        $composicion->save();

        return $composicion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($proyecto_id)
    {
        $num = Composicion::select('composicion.id')
            ->where('composicion.proyecto_id', '=', $proyecto_id)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $composicion = Composicion::find($id);
        $composicion->proyecto_id = $request->proyecto_id;
        $composicion->tipoElemento_id = $request->tipoElemento_id;
        $composicion->save();

        return $composicion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $composicion = Composicion::find($id);
        $composicion->delete();
    }
}
