<?php

namespace Tests\Unit;

use Tests\TestCase;

class DonationServiceTest extends TestCase
{
    public function test_user_can_donate_successfully()
    {
        $loginData = [
            'email' => 'karim.ibrahim@gmail.com',
            'password' => 'Ibr@h1m2024',
        ];

        $loginResponse = $this->postJson('/api/user/login', $loginData);

        $loginResponse->assertStatus(200);

        $token = $loginResponse->json('token');

        $donationData = [
            'Camp_Id' => 1,
            'Don_Type_Id' => 1,
            'Amount' => 900,
        ];

        $donationResponse = $this->postJson('/api/donations', $donationData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $donationResponse->assertStatus(201)  
                         ->assertJson([
                             'status' => 'success',
                             'data' => [
                                 'Camp_Id' => 1,
                                 'Don_Type_Id' => 1,
                                 'Amount' => 900,
                             ],
                         ]);
    }
}
