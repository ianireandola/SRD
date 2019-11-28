<?php

use Illuminate\Database\Seeder;

class PlantaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plantas')->insert([
            ['nombre' => 'Beasain'],
            ['nombre' => 'Irun'],
            ['nombre' => 'Zaragoza'],
            ['nombre' => 'Bagneres de Bigorre'],
            ['nombre' => 'Newport'],
            ['nombre' => 'Huehuetoca'],
            ['nombre' => 'Hortolandia'],
            ['nombre' => 'Elmnira']
        ]);
    }
}
