<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminAuthControllerTest extends TestCase
{
    public function test_admin_can_login()
    {
        $loginData = [
            'email' => 'warda@gmail.com',
            'password' => '123456789',
        ];

        $response = $this->postJson('api/admin/login', $loginData);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'role',
                     ],
                     'token',
                 ]);
    }
}
