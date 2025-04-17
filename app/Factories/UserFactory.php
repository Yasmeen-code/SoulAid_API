<?php

namespace App\Factories;

class UserFactory
{
    public static function createFactory(string $userType): UserFactoryInterface
    {
        return match ($userType) {
            'Donor' => new DonorFactory(),
            'Acceptor' => new AcceptorFactory(),
            default => throw new \InvalidArgumentException("Invalid user type")
        };
    }
}
