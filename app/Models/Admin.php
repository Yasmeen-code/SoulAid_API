<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;  // تأكد من إضافة هذا الـ Trait

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory;  // إضافة الـ Trait هنا

    protected $table = 'admins';
    protected $primaryKey = 'Admin_Id';
    public $timestamps = true;

    protected $fillable = [
        'Name',
        'Email',
        'Password'
    ];

    protected $hidden = [
        'Password',  // لا حاجة لإخفاء api_token هنا إذا لم تستخدمه في الجداول
    ];
}
