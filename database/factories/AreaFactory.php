<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Area::class, function (Faker $faker) {
    return [
        'nombre'=>$faker->name(),
        'Q_Ind'=>$faker->boolean(),
    ];
    
});
