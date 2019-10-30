<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nacion extends Model
{
    public function proyecto_padres()
    {
        return $this->hasMany(ProyectoPadre::class);
    }

    public $timestamps = false;
}
