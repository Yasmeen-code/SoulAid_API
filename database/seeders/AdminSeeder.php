<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            ['Name' => 'Yasmeen Saleh', 'Email' => 'Yasmeensaleh@gmail.com', 'Password' => Hash::make('password123')],
            ['Name' => 'Heba', 'Email' => 'heba@gmail.com', 'Password' => Hash::make('123456789')],
            ['Name' => 'Warda', 'Email' => 'warda@gmail.com', 'Password' => Hash::make('123456789')],
            ['Name' => 'Yasmeen', 'Email' => 'yasmeen@gmail.com', 'Password' => Hash::make('123456789')],
        ];

        foreach ($admins as $admin) {
            DB::table('admins')->insert($admin);
        }
    }
}