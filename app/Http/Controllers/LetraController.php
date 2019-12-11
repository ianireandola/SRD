<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Letra;

class LetraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $letras = Letra::select('letras.id', 'letras.dedicacion_id', 'letras.nombre', 'letras.descripcion')
            ->join('user_letras', 'letras.id', '=', 'user_letras.letra_id')
            ->where('user_letras.user_id', '=', auth()->id())
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
        $letra_id = $request->input('letra_id');
        $user_id = $request->input('user_id');

        $letra = Letra::findOrFail($letra_id);
        $letra->usersletras()->attach($user_id);
        dd($letra->usersletras());

        //$user = User::findOrFail($user_id);
        //$user->usersletras()->attach($letra_id);
        //dd($user->usersLetras());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($letra_id, $user_id)
    {
        $letra = Letra::find($letra_id);
        $letra->usersletras()->detach($user_id);
        dd($letra->usersletras);
    }
}
