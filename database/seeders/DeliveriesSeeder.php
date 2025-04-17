<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveriesSeeder extends Seeder
{
    public function run(): void
    {
        $deliveries = [
            [
                'Donation_Id' => 1,  // تأكد من وجود هذا الـ ID في جدول donations
                'Scheduled_Date' => '2024-03-20',
                'Status' => 'Scheduled'
            ],
            [
                'Donation_Id' => 2,  // تأكد من وجود هذا الـ ID في جدول donations
                'Scheduled_Date' => '2024-03-21',
                'Status' => 'Delivered'
            ]
        ];

        foreach ($deliveries as $delivery) {
            DB::table('deliveries')->insert($delivery);
        }
    }
}