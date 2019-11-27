<?php

use Illuminate\Database\Seeder;

class DedicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dedicacions')->insert([
            ['nombre' => 'Proyecto'], 
            ['nombre' => 'Gasto General'], 
            ['nombre' => 'No Presencia'], 
            ['nombre' => 'SAT']
        ]);
        
    }
}
