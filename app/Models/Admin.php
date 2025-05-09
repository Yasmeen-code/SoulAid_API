<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens; 

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'admins';
    protected $primaryKey = 'Admin_Id';
    public $timestamps = true;

    protected $fillable = [
        'Name',
        'Email',
        'Password'
    ];

    protected $hidden = [
        'Password',
    ];
}
