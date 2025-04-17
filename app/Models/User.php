<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';
    protected $primaryKey = 'UserId';
    public $timestamps = true;

    protected $fillable = [
        'Name',
        'Email',
        'Password',
        'Image',
        'Address',
        'UserType',
        'Admin_Id'
    ];
    
    protected $hidden = [
        'Password',
        'remember_token' 
    ];

    
    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function phones()
    {
        return $this->hasMany(UserPhone::class, 'UserId');
    }
}