<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accion2 extends Model
{
    public function fase()
    {
        return $this->belongsTo(TipoElemento::class);
    }

    public function proyectos()
    {
        return $this->belongsToMany('\App\Proyecto', 'srd_proyectos')
            ->withPivot('user_id', 'elemento_id', 'fecha', 'cantidadHoras', 'viaje');
    }

    public function users()
    {
        return $this->belongsToMany('\App\User', 'srd_proyectos')
            ->withPivot('proyecto_id', 'elemento_id', 'fecha', 'cantidadHoras', 'viaje');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public $timestamps = false;
}
