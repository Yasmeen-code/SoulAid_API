<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserAuthControllerTest extends TestCase
{
    public function test_user_can_register()
    {
        $userData = [
            'name' => '12test user1234',
            'email' => '12t3est_test56@gmail.com',
            'password' => '123456789',
            'address' => 'hg kj l',
            'user_type' => 'Acceptor',  
        ];

        $response = $this->postJson('api/user/register', $userData);

        $response->assertStatus(201) 
                 ->assertJsonStructure([
                     'status',  
                     'data' => [  
                         'id',  
                         'name',  
                         'email',  
                         'user_type',  
                     ],
                     'token',  
                 ]);
    }
    public function test_user_can_login()
    {
        $loginData = [
            'email' => 'karim.ibrahim@gmail.com',
            'password' => 'Ibr@h1m2024',
        ];

        $response = $this->postJson('api/user/login', $loginData);

        $response->assertStatus(200) 
                 ->assertJsonStructure([
                     'status',  
                     'data' => [  
                         'id',  
                         'name', 
                         'email',  
                         'address',
                         'user_type',  
                         'image',  
                     ],
                     'token',  
                 ]);
    }
}


