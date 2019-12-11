<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letra;

class LetrasTodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $letras = Letra::all();
        return $letras;
    }
}
