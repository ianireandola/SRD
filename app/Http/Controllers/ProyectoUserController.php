<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;

class ProyectoUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyectos = Proyecto::select('proyectos.id', 'proyectos.nombre', 'proyectos.descripcion', 'proyectos.estado')
            ->join('user_proyectos', 'proyectos.id', '=', 'user_proyectos.proyecto_id')
            ->where('user_proyectos.user_id', '=', auth()->id())
            ->get();

        return $proyectos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proyecto_id = $request->input('proyecto_id');
        $user_id = $request->input('user_id');

        $proyecto = Proyecto::findOrFail($proyecto_id);
        $proyecto->usersproyectos()->attach($user_id);
        dd($proyecto->usersproyectos());

        //$user = User::findOrFail($user_id);
        //$user->usersletras()->attach($letra_id);
        //dd($user->usersLetras());
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($proyecto_id, $user_id)
    {
        $proyecto = Proyecto::find($proyecto_id);
        $proyecto->usersproyectos()->detach($user_id);
        dd($proyecto->usersletras);
    }
}
