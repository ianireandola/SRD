<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hito extends Model
{
    public function fase()
    {
        return $this->belongsTo(Fase::class);
    }

    public function proyectoPadres()
    {
        return $this->belongsToMany('\App\ProyectoPadre', 'avance_proyecto')
            ->withPivot('NTP');
    }

    public $timestamps = false;
}
