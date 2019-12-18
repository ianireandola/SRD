<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accion2;

class Accion2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acciones2 = Accion2::select('accion2s.id', 'accion2s.nombre', 'accion2s.identificador', 'accion2s.proyecto_id')
            ->orderBy('accion2s.identificador')
            ->get();

        return $acciones2;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acciones2 = Accion2::select('*')
            ->orderBy('accion2s.nombre')
            ->get();

        return $acciones2;
    }

}
