<?php

namespace App\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AcceptorFactory implements UserFactoryInterface
{
    public function create(array $data)
    {
        return User::create([
            'Name' => $data['name'],
            'Email' => $data['email'],
            'Password' => Hash::make($data['password']),
            'Address' => $data['address'],
            'UserType' => "Acceptor",
            'Image' => $data['image'] ?? null
        ]);
    }
}
