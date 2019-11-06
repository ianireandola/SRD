<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_proyecto extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    public $timestamps = false;
}
