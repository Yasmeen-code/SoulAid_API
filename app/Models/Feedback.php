<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';  

    protected $fillable = [
        'UserId',
        'Camp_Id',
        'comment',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserId');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'Camp_Id');
    }
}
