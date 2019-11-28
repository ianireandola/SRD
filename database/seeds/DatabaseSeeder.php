<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(DedicacionSeeder::class);
        $this->call(LetraSeeder::class);
        $this->call(PlantaSeeder::class);
        $this->call(FijoEventualSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(TipoProyectoSeeder::class);
        $this->call(NacionSeeder::class);
    }
}
