<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    protected $table = 'requests';
    protected $primaryKey = 'Request_Id';
    public $timestamps = true;

    protected $fillable = [
        'Acceptor_Id',
        'Don_Type_Id',
        'Amount',
        'description',
        'Status',
        'Date',
        'Level_Of_Need',
        'Admin_Id',
    ];

    
    public function acceptor()
    {
        return $this->belongsTo(User::class, 'Acceptor_Id', 'id')->where('User_Type', 'Acceptor');
    }


    public function donationType()
    {
        return $this->belongsTo(DonationType::class, 'Don_Type_Id', 'Don_Type_Id');
    }

    
    public function admin()
    {
        return $this->belongsTo(User::class, 'Admin_Id', 'id')->where('User_Type', 'Admin');
    }
}
