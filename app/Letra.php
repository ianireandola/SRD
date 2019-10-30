<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letra extends Model
{
    public function dedicacion()
    {
        return $this->belongsTo(Dedicacion::class);
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'srd_letras')
            ->withPivot('id', 'fecha', 'cantidadHoras');
    }

    public function usersletras()
    {
        return $this->belongsToMany('App\User', 'user_letra');
    }

    public $timestamps = false;
}
