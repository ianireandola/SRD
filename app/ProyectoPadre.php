<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoPadre extends Model
{
    public function tipoProyecto()
    {
        return $this->belongsTo(TipoProyecto::class);
    }

    public function nacion()
    {
        return $this->belongsTo(Nacion::class);
    }

    public function hitos()
    {
        return $this->belongsToMany('App\Hito', 'avance_proyecto')
            ->withPivot('NTP');
    }

    public $timestamps = false;
}
