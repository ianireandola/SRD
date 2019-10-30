<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dedicacion extends Model
{
    public function letras()
    {
        return $this->hasMany(Letra::class);
    }

    public $timestamps = false;
}
