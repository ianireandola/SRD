<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Planta::class, function (Faker $faker) {
    return [
        'nombre'=> $faker->unique()->randomElement(['Irun' ,'Beasain', 'Zaragoza']),
    ];
});
