<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    public function proyectoPadre()
    {
        return $this->belongsTo(ProyectoPadre::class);
    }

    public function elementos()
    {
        return $this->hasMany(Elemento::class);
    }

    public function acciones2()
    {
        return $this->hasMany(Accion2::class);
    }

    public function seccions()
    {
        return $this->belongsToMany('\App\Seccion', 'trabajan')
            ->withPivot('horasEstimadas', 'presupuesto');
    }

    public function users()
    {
        return $this->belongsToMany('\App\User', 'srd_proyectos')
            ->withPivot('accion2_id', 'elemento_id', 'fecha', 'cantidadHoras', 'viaje');
    }

    public function usersproyectos()
    {
        return $this->belongsToMany('App\User', 'user_proyecto');
    }

    public function accion2s()
    {
        return $this->belongsToMany('App\Accion2', 'srd_proyectos')
            ->withPivot('user_id', 'elemento_id', 'fecha', 'cantidadHoras', 'viaje');
    }

    public function tipo_elementos()
    {
        return $this->belongsToMany('App\TipoElemento', 'composicion');
    }

    public $timestamps = false;
}
