<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestsSeeder extends Seeder
{
    public function run(): void
    {
        $requests = [
            [
                'Acceptor_Id' => 1,  // Changed from 4
                'Don_Type_Id' => 1,  // Changed from 6
                'Amount' => 500.00,
                'description' => 'Request for medical assistance',
                'Status' => 'Pending',
                'Date' => '2025-03-10',
                'Level_Of_Need' => 'High',
                'Admin_Id' => 1
            ],
            [
                'Acceptor_Id' => 2,  // Changed from 5
                'Don_Type_Id' => 2,  // Changed from 3
                'Amount' => null,
                'description' => 'Request for food supplies',
                'Status' => 'Approved',
                'Date' => '2025-03-11',
                'Level_Of_Need' => 'Medium',
                'Admin_Id' => 2
            ],
            [
                'Acceptor_Id' => 3,  // Changed from 6
                'Don_Type_Id' => 2,
                'Amount' => null,
                'description' => 'Need for clothing donations',
                'Status' => 'Pending',
                'Date' => '2025-03-12',
                'Level_Of_Need' => 'Low',
                'Admin_Id' => 3
            ],
            [
                'Acceptor_Id' => 4,  // Changed from 8
                'Don_Type_Id' => 1,
                'Amount' => 1000.00,
                'description' => 'Financial aid for surgery',
                'Status' => 'Approved',
                'Date' => '2025-03-13',
                'Level_Of_Need' => 'High',
                'Admin_Id' => 1
            ]
        ];

        foreach ($requests as $request) {
            DB::table('requests')->insert($request);
        }
    }
}