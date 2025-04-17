<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignsSeeder extends Seeder
{
    public function run(): void
    {
        $campaigns = [
            [
                'CampName' => 'Winter Clothes',
                'Description' => 'Collecting winter clothes for the homeless.',
                'StartDate' => '2025-08-01',
                'EndDate' => '2025-08-31',
                'Image' => 'winter_clothes.jpg',
                'Admin_Id' => 1, 
                'Amount' => 3000,
                'Address' => 'Charity House'
            ],

            [
                'CampName' => 'Food Bank',
                'Description' => 'Collecting food for needy families',
                'StartDate' => '2025-09-01',
                'EndDate' => '2025-09-30',
                'Image' => 'food_bank.jpg',
                'Admin_Id' => 2,
                'Amount' => 5000,
                'Address' => 'Food Bank Center'
            ]
        ];

        foreach ($campaigns as $campaign) {
            DB::table('campaigns')->insert($campaign);
        }
    }
}