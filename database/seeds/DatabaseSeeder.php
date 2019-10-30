<?php

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseSeeder extends Seeder
{
    use RefreshDatabase;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(AreasTableSeeder::class);
        //$this->call(PlantasTableSeeder::class);
        $this->call(SeccionsTableSeeder::class);
    }
}
