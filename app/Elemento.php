<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elemento extends Model
{
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function tipoElemento()
    {
        return $this->belongsTo(TipoElemento::class);
    }

    public $timestamps = false;
}
