<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    public function hitos()
    {
        return $this->hasMany(Hito::class);
    }

    public $timestamps = false;
}
