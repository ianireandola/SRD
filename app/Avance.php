<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avance extends Model
{
    protected $table = 'avance_proyecto';

    public function hitos()
    {
        return $this->hasMany(Hito::class);
    }

    public function proyectosPadre()
    {
        return $this->hasMany(ProyectoPadre::class);
    }

    public $timestamps = false;
}
