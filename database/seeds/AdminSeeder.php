<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'chapa' => '64267',
            'nombre' => 'Admin',
            'password' => bcrypt('admin'),
            'password_confirmation' => 'admin'
        ]);
    }
}
