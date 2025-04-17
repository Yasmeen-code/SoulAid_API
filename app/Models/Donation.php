<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donations';
    protected $primaryKey = 'Donation_Id';
    public $timestamps = false;

    protected $fillable = [
        'Donation_Id',
        'Donation_Date',
        'Donor_Id',
        'Camp_Id',
        'Don_Type_Id',
        'Amount',
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'Donor_Id', 'UserId');
    }


    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'Camp_Id', 'Camp_Id');
    }

    public function donationType()
    {
        return $this->belongsTo(DonationType::class, 'Don_Type_Id', 'Don_Type_Id');
    }
}
