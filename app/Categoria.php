<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public $timestamps = false;
}
