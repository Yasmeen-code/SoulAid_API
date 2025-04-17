<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    protected $table = 'user_phones';
    protected $primaryKey = 'PhoneId';
    
    protected $fillable = [
        'UserId',
        'Phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserId');
    }
}