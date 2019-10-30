<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password', 'chapa', 'password_confirmation',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function fijo_eventual()
    {
        return $this->belongsTo(FijoEventual::class);
    }

    public function proyectos()
    {
        return $this->belongsToMany('\App\Proyecto', 'srd_proyectos')
            ->withPivot('accion2_id', 'elemento_id', 'fecha', 'cantidadHoras', 'viaje');
    }

    public function usersproyectos()
    {
        return $this->belongsToMany('App\Proyecto', 'user_proyecto');
    }

    public function accion2s()
    {
        return $this-> belongsToMany('App\Accion2', 'srd_proyectos')
            ->withPivot('proyecto_id', 'elemento_id', 'fecha', 'cantidadHoras', 'viaje');
    }

    public function letras()
    {
        return $this->belongsToMany('\App\Letra', 'srd_letras')
            ->withPivot('fecha', 'cantidadHoras');
    }

    public function usersletras()
    {
        return $this->belongsToMany('App\Letra', 'user_letra');
    }

    
}
