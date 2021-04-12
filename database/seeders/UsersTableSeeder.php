<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Mats Alkemade',
            'email' => 'matsalkemade@gmail.com',
            'password' => bcrypt('laravel'),
        ]);

        DB::table('users')->insert([
            'name' => 'Davino Rosaria',
            'email' => 'davino.rosaria@gmail.com',
            'password' => bcrypt('laravel'),
        ]);

        DB::table('users')->insert([
            'name' => 'Roy Oosterlee',
            'email' => 'roy@famoosterlee.nl',
            'password' => bcrypt('laravel'),
        ]);
    }
}
