<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';
    protected $primaryKey = 'Camp_Id';

    protected $fillable = [
        'CampName',
        'Description',
        'StartDate',
        'EndDate',
        'Image',
        'Amount',
        'Address',
        'Admin_Id',
        'Don_Type_Id'
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
        'Amount' => 'decimal:2'
    ];
    public function __clone()
    {
        $this->StartDate = now(); 
        $this->Amount = 0; 
    }
}