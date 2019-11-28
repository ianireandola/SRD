<?php

use Illuminate\Database\Seeder;

class FijoEventualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fijo_eventuals')->insert([
            ['nombre' => 'E'],
            ['nombre' => 'F'],
            ['nombre' => 'B'],
            ['nombre' => 'SUBC']
        ]);
    }
}
