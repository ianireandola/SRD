<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seccion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $seccion = Seccion::select('seccions.id', 'seccions.nombre', 'seccions.nivel2')
            ->join('users', 'users.seccion_id', '=', 'seccions.id')
            ->where('users.id', '=', auth()->user()->id)
            ->get();
 
        return view('home', compact('seccion'));
        
    }


}
