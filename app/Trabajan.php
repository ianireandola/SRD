<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajan extends Model
{
    protected $table = 'trabajan';

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    public function secciones()
    {
        return $this->hasMany(Seccion::class);
    }

    public $timestamps = false;
}
