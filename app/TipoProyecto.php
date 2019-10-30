<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProyecto extends Model
{
    public function proyecto_padres()
    {
        return $this->hasMany(ProyectoPadre::class);
    }

    public $timestamps = false;
}
