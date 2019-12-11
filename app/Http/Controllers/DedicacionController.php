<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dedicacion;

class DedicacionController extends Controller
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
        return view('dedicacion');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dedicaciones = Dedicacion::select('*')
            ->orderBy('dedicacions.nombre')
            ->get();

        return $dedicaciones;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dedicacion = new Dedicacion();
        $dedicacion->nombre = $request->nombre;
        $dedicacion->save();

        return $dedicacion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dedicacion = Dedicacion::select('dedicacions.nombre')
            ->where('dedicacions.id', '=', $id)
            ->get();
    
        return $dedicacion;
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
        $dedicacion = Dedicacion::find($id);
        $dedicacion->nombre = $request->nombre;
        $dedicacion->save();

        return $dedicacion;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dedicacion = Dedicacion::find($id);
        $dedicacion->delete();
    }
}
