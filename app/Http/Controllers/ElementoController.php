<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Elemento;

class ElementoController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elementos = Elemento::select('elementos.id', 'elementos.nombre', 'elementos.proyecto_id')
            ->orderBy('elementos.nombre')
            ->get();

        return $elementos;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $elementos = Elemento::select('elementos.id', 'elementos.nombre')
            ->where('elementos.proyecto_id', '=', $id)
            ->orderBy('elementos.nombre')
            ->get();

        return $elementos;
    }

}
