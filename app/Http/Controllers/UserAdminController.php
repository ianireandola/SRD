<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
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
        return view('user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = User::select('*')
            ->orderBy('users.nombre')
            ->get();

        return $usuarios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fechaLarga = $request->input('fechaCPUportatil');
        $fecha = substr($fechaLarga, 0, 10);
        $año = substr($fecha, 0, -6);
        $mes = substr($fecha, 5, -3);
        $diaInt = (int) substr($fecha, -2);
        $diaInt = $diaInt + 1;
        $dia = (string) $diaInt;
        $fechabien = $año."-".$mes."-".$dia;        

        $user = new User();
        $user->chapa = $request->chapa;
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->password = Hash::make($request->password_confirmation);
        $user->password_confirmation = $request->password_confirmation;
        $user->funcion = $request->funcion;
        $user->comentario = $request->comentario;
        $user->seccion_id = $request->seccion_id;
        $user->categoria_id = $request->categoria_id;
        $user->fijoeventual_id = $request->fijoeventual_id;
        $user->CPUportatil = $request->CPUportatil;
        $user->fechaCPUportatil = $request->fechaCPUportatil;
        $user->save();

        return $user;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::select('users.seccion_id')
            ->where('users.id', '=', auth()->id)
            ->get();

        return $usuario;
    }

    public function showSeccion($seccion_id)
    {
        $num = User::select('users.id')
            ->where('users.seccion_id', '=', $seccion_id)
            ->count();

        return $num;
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categoria_id)
    {
        $usuarios = User::select('users.id')
            ->where('users.categoria_id', '=', $categoria_id)
            ->count();

        return $usuarios;
    }


    public function FEcoincidentes($fijoeventual_id)
    {
        $usuarios = User::select('users.id')
            ->where('users.fijoeventual_id', '=', $fijoeventual_id)
            ->count();

        return $usuarios;
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
        $usuario = User::find($id);
        $usuario->chapa = $request->chapa;
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password_confirmation);
        $usuario->password_confirmation = $request->password_confirmation;
        $usuario->funcion = $request->funcion;
        $usuario->comentario = $request->comentario;
        $usuario->seccion_id = $request->seccion_id;
        $usuario->categoria_id = $request->categoria_id;
        $usuario->fijoeventual_id = $request->fijoeventual_id;
        $usuario->CPUportatil = $request->CPUportatil;
        $usuario->fechaCPUportatil = $request->fechaCPUportatil;
        $usuario->save();

        return $usuario;
    }

    public function categoriaUpdate(Request $request, $id)
    {
        $usuario = User::find($id);
        $usuario->categoria_id = $request->categoria_id;
        $usuario->save();

        return $usuario;
    }

    public function fijoeventualUpdate(Request $request, $id)
    {
        $usuario = User::find($id);
        $usuario->fijoeventual_id = $request->fijo_eventual_id;
        $usuario->save();

        return $usuario;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
