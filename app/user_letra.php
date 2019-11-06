<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_letra extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function letras()
    {
        return $this->hasMany(Letra::class);
    }
}
