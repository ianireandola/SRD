<?php

use Illuminate\Database\Seeder;

class NacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nacions')->insert([
            ['nombre' => 'España'],
            ['nombre' => 'USA'],
            ['nombre' => 'UK'],
            ['nombre' => 'Mexico'],
            ['nombre' => 'Brasil'],
            ['nombre' => 'Noruega'],
            ['nombre' => 'Holanda'],
            ['nombre' => 'Francia']
        ]);
    }
}
