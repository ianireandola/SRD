<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Composicion extends Model
{
    protected $table = 'composicion';

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    public function tipo_elementos()
    {
        return $this->hasMany(TipoElemento::class);
    }

    public $timestamps = false;
}
