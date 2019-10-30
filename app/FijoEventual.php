<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FijoEventual extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public $timestamps = false;
}
