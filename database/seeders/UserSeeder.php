<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    { 
        $users = [
            [
                'Name' => 'Samir Rashad',
               'Password' => Hash::make('password123'),
                'Email' => 'samir.rashad@gmail.com',
                'Address' => 'Sharm El-Sheikh, Egypt',
                'Image' => 'vghjk.jpg',
                'UserType' => 'Acceptor',
                'Admin_Id' => 1
            ],
            [
                'Name' => 'Omar Mohamed',
                'Password' => Hash::make('Xy9@pLmAqZt3#'),
                'Email' => 'omar.mohamed@gmail.com',
                'Address' => 'Cairo, Egypt',
                'Image' => 'omar.jpg',
                'UserType' => 'Donor',
                'Admin_Id' => 2
            ],
            [
                'Name' => 'Aisha Khalil',
                'Password' => Hash::make('Kh@l1L2023'),
                'Email' => 'aisha.khalil@gmail.com',
                'Address' => 'Alexandria, Egypt',
                'Image' => 'aisha.jpg',
                'UserType' => 'Acceptor',
                'Admin_Id' => 3
            ],
            [
                'Name' => 'Karim Ibrahim',
                'Password' => Hash::make('Ibr@h1m2024'),
                'Email' => 'karim.ibrahim@gmail.com',
                'Address' => 'Giza, Egypt',
                'Image' => 'karim.jpg',
                'UserType' => 'Donor',
                'Admin_Id' => 4
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}