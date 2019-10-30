<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    public function seccions()
    {
        return $this->hasMany(Seccion::class);
    }
    public $timestamps = false;
}
