<?php

namespace App\Http\Controllers;

use App\Avance;
use App\Hito;
use Illuminate\Http\Request;

class AvanceProyectoController extends Controller
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
        return view ('avance_proyecto');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hitos = Hito::select('avance_proyecto.id', 'avance_proyecto.hito_id', 'avance_proyecto.proyectoPadre_id', 'NTP')
            ->join('avance_proyecto', 'hitos.id', '=', 'avance_proyecto.hito_id')
            ->orderBy('avance_proyecto.proyectoPadre_id')
            ->get();

        return $hitos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $avance = new Avance();
        $avance->hito_id = $request->hito_id;
        $avance->proyectoPadre_id = $request->proyectoPadre_id;
        $avance->NTP = $request->NTP;

        $avance->save();

        return $avance;
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
        $avance = Avance::find($id);
        $avance->hito_id = $request->hito_id;
        $avance->proyectoPadre_id = $request->proyectoPadre_id;
        $avance->save();

        return $avance;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
