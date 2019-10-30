<?php

use Illuminate\Database\Seeder;

class PlantasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Planta::class, 3)->create();
    }
}
