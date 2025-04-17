<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DonationTypesSeeder::class,
            UserSeeder::class,
            UserPhonesSeeder::class,
            CampaignsSeeder::class,
            DonationsSeeder::class,
            DeliveriesSeeder::class,
            RequestsSeeder::class,
        ]);
    }
}