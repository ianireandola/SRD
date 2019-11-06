<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letra;

class LetraAdminController extends Controller
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
        return view('letra');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $letras = Letra::all();

        return $letras;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $letra = new Letra();
        $letra->nombre = $request->nombre;
        $letra->descripcion = $request->descripcion;
        $letra->dedicacion_id = $request->dedicacion_id;
        $letra->save();

        return $letra;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $letra = Letra::find($id);
        $letra->nombre = $request->nombre;
        $letra->descripcion = $request->descripcion;
        $letra->dedicacion_id = $request->dedicacion_id;
        $letra->save();

        return $letra;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $letra = Letra::find($id);
        $letra->delete();
    }
}
