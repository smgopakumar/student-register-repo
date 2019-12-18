<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \Illuminate\Support\Facades\DB::table('users')->delete();

        \Illuminate\Support\Facades\DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Super Admin',
                    'user_type_id' => 2,
                    'email' => 'admin@student.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                    'status' => 1
                )

        ));


    }
}
