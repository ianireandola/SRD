<?php

use Illuminate\Database\Seeder;

class TipoProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_proyectos')->insert([
            ['nombre' => 'DMU'],
            ['nombre' => 'EMU'],
            ['nombre' => 'LRV'],
            ['nombre' => 'METRO'],
            ['nombre' => 'CIVITY'],
            ['nombre' => 'URBOS']
        ]);
    }
}
