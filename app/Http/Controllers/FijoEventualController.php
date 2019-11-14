<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FijoEventual;

class FijoEventualController extends Controller
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
        return view('fijo_eventual');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fijos_eventuales = FijoEventual::select('*')
            ->orderBy('fijo_eventuals.nombre')
            ->get();

        return $fijos_eventuales;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fijo_eventual = new FijoEventual();
        $fijo_eventual->nombre = $request->nombre;
        $fijo_eventual->save();

        return $fijo_eventual;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fijos_eventuales = FijoEventual::select('fijo_eventuals.nombre')
            ->where('fijo_eventuals.id', '=', $id)
            ->get();
    
        return $fijos_eventuales;
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
        $fijo_eventual = FijoEventual::find($id);
        $fijo_eventual->nombre = $request->nombre;
        $fijo_eventual->save();

        return $fijo_eventual;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fijo_eventual = FijoEventual::find($id);
        $fijo_eventual->delete();
    }
}
