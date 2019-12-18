<?php

namespace App\Exports;

use App\Accion2;
use App\srd_letra;
use App\srd_proyecto;
use App\Elemento;
use App\Proyecto;
use App\User;
use App\Letra;
use App\Seccion;
use App\Categoria;
use App\Dedicacion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class SRDExport implements FromView
{
    use Exportable;  

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.srds', [
            'srd_proyectos' => srd_proyecto::all(),
            'srd_letras' => srd_letra::all(),
            'users' => User::all(),
            'categorias' => Categoria::all(),
            'dedicaciones' => Dedicacion::all(),
            'secciones' => Seccion::all(),
            'proyectos' => Proyecto::all(),
            'letras' => Letra::all(),
            'acciones' => Accion2::all(),
            'elementos' => Elemento::all()
        ]);
    }
}
