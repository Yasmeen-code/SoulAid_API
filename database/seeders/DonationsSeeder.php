<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationsSeeder extends Seeder
{
    public function run(): void
    {
        $donations = [
            [
                'Amount' => 200.50,
                'Donation_Date' => '2023-09-10',
                'Donor_Id' => 2,
                'Camp_Id' => 2,
                'Acceptor_Id' => 1,  // Changed from 5 to 1
                'Don_Type_Id' => 1   // Changed from 5 to 1
            ],
            [
                'Amount' => 500.00,
                'Donation_Date' => '2023-10-15',
                'Donor_Id' => 4,
                'Camp_Id' => 1,
                'Acceptor_Id' => 3,
                'Don_Type_Id' => 2
            ]
        ];

        foreach ($donations as $donation) {
            DB::table('donations')->insert($donation);
        }
    }
}