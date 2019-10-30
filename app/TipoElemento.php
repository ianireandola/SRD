<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoElemento extends Model
{
    public function elementos()
    {
        return $this->hasMany(Elemento::class);
    }

    public function accion2s()
    {
        return $this->hasMany(Accion2::class);
    }

    public function proyectos()
    {
        return $this->belongsToMany('App\Proyecto', 'composicion');
    }

    public $timestamps = false;

}
