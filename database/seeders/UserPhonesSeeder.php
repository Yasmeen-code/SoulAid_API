<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPhonesSeeder extends Seeder
{
    public function run(): void
    {
        $phones = [
            ['UserId' => 1, 'Phone' => '01234567890'],  // Samir Rashad
            ['UserId' => 1, 'Phone' => '01112223333'],  // رقم ثاني لـ Samir
            ['UserId' => 2, 'Phone' => '01098765432'],  // Omar Mohamed
            ['UserId' => 3, 'Phone' => '01187654321'],  // Aisha Khalil
            ['UserId' => 4, 'Phone' => '01276543210']   // Karim Ibrahim
        ];

        foreach ($phones as $phone) {
            DB::table('user_phones')->insert($phone);
        }
    }
}