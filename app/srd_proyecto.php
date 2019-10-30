<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class srd_proyecto extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function accion2s()
    {
        return $this->hasMany(Accion2::class);
    }

    public function elementos()
    {
        return $this->hasMany(Elemento::class);
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    public $timestamps = false;
}
