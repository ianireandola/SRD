<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function planta()
    {
        return $this->belongsTo(Planta::class);
    }

    public function proyectos()
    {
        return $this->belongsToMany('\App\Proyecto', 'trabajan')
            ->withPivot('horasEstimadas', 'presupuesto');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public $timestamps = false;
}
