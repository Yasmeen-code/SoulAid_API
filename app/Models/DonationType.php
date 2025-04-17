<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationType extends Model
{
    protected $table = 'donation_types';
    protected $primaryKey = 'Don_Type_Id';
    
    protected $fillable = [
        'Type_Name',
        'Description'
    ];

    
    public function donations()
    {
        return $this->hasMany(Donation::class, 'don_type_id', 'Don_Type_Id');
    }
}