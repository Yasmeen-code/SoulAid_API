<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('deliveries')->insert([
            ['Donation_Id' => 1, 'Scheduled_Date' => '2024-03-17', 'Status' => 'Scheduled'],
            ['Donation_Id' => 2, 'Scheduled_Date' => '2024-01-22', 'Status' => 'In Transit'],
            ['Donation_Id' => 3, 'Scheduled_Date' => '2024-03-22', 'Status' => 'Scheduled'],
            ['Donation_Id' => 11, 'Scheduled_Date' => '2024-02-03', 'Status' => 'In Transit'],
            ['Donation_Id' => 6, 'Scheduled_Date' => '2024-03-27', 'Status' => 'Delivered'],
            ['Donation_Id' => 7, 'Scheduled_Date' => '2024-02-12', 'Status' => 'Delivered'],
            ['Donation_Id' => 8, 'Scheduled_Date' => '2024-04-05', 'Status' => 'Cancelled'],
            ['Donation_Id' => 9, 'Scheduled_Date' => '2024-03-30', 'Status' => 'Scheduled'],
            ['Donation_Id' => 10, 'Scheduled_Date' => '2024-04-10', 'Status' => 'In Transit'],
        ]);
    }
}