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
        $user->categoria_id = $request->categoria_id;
        $user->fijoeventual_id = $request->fijoeventual_id;
        $user->CPUportatil = $request->CPUportatil;
        $user->fechaCPUportatil = $fechabien;
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
        $fechaLarga = $request->input('fechaCPUportatil');

        $fecha = substr($fechaLarga, 0, 10);
        echo("Fecha por defecto: ".$fecha."\n");
        $año = substr($fecha, 0, -6);
        $mes = substr($fecha, 5, -3);
        $diaint = (int) substr($fecha, -2);
        $fechabien = '';
        if($diaint === 30)
        {
            if($mes === '04' || $mes === '06' || $mes === '09' || $mes === '11')
            {
                $dia = '01';
                $mesint = (int) substr($fecha, 5, -3);
                $mesint = $mesint + 1;
                $mes = (string) $mesint;
                $fechabien = $año."-".$mes."-".$dia;
                echo("Fecha modificada: ".$fechabien."\n");
            }
        }
        else if($diaint === 31)
        {
            echo("Entro en día === 31 \n");
            if($mes === '01' || $mes === '03' || $mes === '05' || $mes === '07' || $mes === '08' || $mes === '10' )
            {
                $dia = '01';
                $mesint = (int) substr($fecha, 5, -3);
                $mesint = $mesint + 1;
                $mes = (string) $mesint;
                $fechabien = $año."-".$mes."-".$dia;
                echo("Fecha modificada: ".$fechabien."\n");
            }
            if($mes === '12')
            {
                $dia = '01';
                $mesint = (int) substr($fecha, 5, -3);
                $mesint = $mesint + 1;
                $mes = (string) $mesint;
                $añoint = (int) substr($fecha, 5, -3);
                $añoint = $añoint + 1;
                $año = (string) $añoint;
                $fechabien = $año."-".$mes."-".$dia;
                echo("Fecha modificada: ".$fechabien."\n");
            }
        }else
        {
            if($diaint === 28  && $mes === '02')
            {
                $dia = '01';
                $mes = '03';
                $fechabien = $año."-".$mes."-".$dia;
                echo("Fecha modificada: ".$fechabien."\n");
            }else
            {
                $diaint = $diaint + 1;
                $dia = (string) $diaint;
                $fechabien = $año."-".$mes."-".$dia;
                echo("Fecha modificada: ".$fechabien."\n");
            }
        }

        $usuario = User::find($id);
        $usuario->chapa = $request->chapa;
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password_confirmation);
        $usuario->password_confirmation = $request->password_confirmation;
        $usuario->funcion = $request->funcion;
        $usuario->comentario = $request->comentario;
        $usuario->categoria_id = $request->categoria_id;
        $usuario->fijoeventual_id = $request->fijoeventual_id;
        $usuario->CPUportatil = $request->CPUportatil;
        $usuario->fechaCPUportatil = $fechabien;
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
