<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letra;
use App\srd_letra;
use App\user_letra;
use DB;

class SRDLetraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $letras = Letra::select('srd_letras.id', 'srd_letras.fecha', 'letras.identificador', 'letras.nombre', 'letras.dedicacion_id', 'srd_letras.cantidadHoras', 'srd_letras.viaje')
            ->join('srd_letras', 'letras.id', '=', 'srd_letras.letra_id')
            ->where('srd_letras.user_id', '=', auth()->id())
            ->orderBy('srd_letras.fecha')
            ->get();

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
        $srd_letra = new srd_letra();
        $srd_letra->letra_id = $request->letra_id;
        $srd_letra->user_id = $request->user_id;
        $srd_letra->fecha = $request->fecha;
        $srd_letra->cantidadHoras = $request->cantidadHoras;
        $srd_letra->viaje = $request->viaje;

        $srd_letra->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($fecha)
    {
        $letras = Letra::select('srd_letras.id', 'letras.nombre', 'srd_letras.user_id', 'srd_letras.fecha', 'srd_letras.cantidadHoras', 'srd_letras.viaje')
            ->join('srd_letras', 'letras.id', '=', 'srd_letras.letra_id')
            ->where('srd_letras.fecha', '=', $fecha)
            ->get();
        
        return $letras;        
    }

    public function showLetra($letra_id)
    {
        $num = srd_letra::select('srd_letras.id')
            ->where('srd_letras.letra_id', '=', $letra_id)
            ->count();

        $num2 = user_letra::select('user_letras.letra_id')
            ->where('user_letras.letra_id', '=', $letra_id)
            ->count();

        $total = $num + $num2;
        
        return $total;   
    }

    public function showUsuario($user_id)
    {
        $ids = srd_letra::select('srd_letras.id')
            ->where('srd_letras.user_id', '=', $user_id)
            ->get();

        return $ids;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($fecha)
    {
        $srd_letras = srd_letra::select('srd_letras.id')
            ->where([
                ['srd_letras.fecha', '=', $fecha],
                ['srd_letras.user_id', '=', auth()->id()]
            ])
            ->count();
            
        return $srd_letras;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $srd_letra = srd_letra::find($id);
        $srd_letra->delete();
        
    }
}
