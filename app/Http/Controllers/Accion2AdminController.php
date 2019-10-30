<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accion2;

class Accion2AdminController extends Controller
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
        return view('accion2');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accion2s = Accion2::all();

        return $accion2s;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accion2 = new Accion2();
        $accion2->nombre = $request->nombre;
        $accion2->descripcion = $request->descripcion;
        $accion2->save();

        return $accion2;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $accion2 = Accion2::select('accion2s.nombre')
            ->where('accion2s.id', '=', $id)
            ->get();
    
        return $accion2;
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
        $accion2 = Accion2::find($id);
        $accion2->nombre = $request->nombre;
        $accion2->descripcion = $request->descripcion;
        $accion2->save();

        return $accion2;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $accion2 = Accion2::find($id);
        $accion2->delete();
    }
}
