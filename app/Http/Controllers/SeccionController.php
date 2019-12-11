<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seccion;

class SeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seccion = Seccion::select('seccions.id', 'seccions.nombre', 'seccions.nivel2')
            ->join('users', 'users.seccion_id', '=', 'seccions.id')
            ->where('users.id', '=', auth()->user()->id)
            ->get();

        return $seccion;
    }
}
