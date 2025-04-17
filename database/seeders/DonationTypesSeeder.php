<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['TypeName' => 'Money'],
            ['TypeName' => 'Clothes'],
            ['TypeName' => 'Food'],
            ['TypeName' => 'Books'],
            ['TypeName' => 'blood'],
            ['TypeName' => 'other']
        ];

        foreach ($types as $type) {
            // Check if type exists before inserting
            if (!DB::table('donation_types')->where('TypeName', $type['TypeName'])->exists()) {
                DB::table('donation_types')->insert($type);
            }
        }
    }
}