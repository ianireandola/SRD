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
            [
                'chapa' => '14036',
                'nombre' => 'Amondarain Martinez, Ainara',
                'password' => bcrypt('14036'),
                'password_confirmation' => '14036'
            ],
            [
                'chapa' => '13418',
                'nombre' => 'Iturrioz Mendizabal, Xabier',
                'password' => bcrypt('13418'),
                'password_confirmation' => '13418'
            ]           
        ]);
    }
}
