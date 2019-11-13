<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trabajan;

class TrabajanController extends Controller
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
        return view ('trabajan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trabajan = Trabajan::select('*')
            ->orderBy('trabajan.seccion_id')
            ->get();

        return $trabajan;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trabajan = new Trabajan();
        $trabajan->proyecto_id = $request->proyecto_id;
        $trabajan->seccion_id = $request->seccion_id;
        $trabajan->horasEstimadas = $request->horasEstimadas;
        $trabajan->presupuesto = $request->presupuesto;
        $trabajan ->save();

        return $trabajan;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($proyecto_id)
    {
        $num = trabajan::select('trabajan.id')
            ->where('trabajan.proyecto_id', '=', $proyecto_id)
            ->count();
        return $num;
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
        $trabajan = Trabajan::find($id);
        $trabajan->proyecto_id = $request->proyecto_id;
        $trabajan->seccion_id = $request->seccion_id;
        $trabajan->horasEstimadas = $request->horasEstimadas;
        $trabajan->presupuesto = $request->presupuesto;
        $trabajan->save();

        return $trabajan; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trabajan = Trabajan::find($id);
        $trabajan->delete();
    }
}
