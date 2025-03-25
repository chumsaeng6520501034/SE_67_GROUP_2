<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
    protected $primaryKey="id_account";
    public $timestamps = false;
    protected $fillable = [
        'id_account',
        'username',
        'email',
        'password',
        'status',  // เพิ่ม 'status' ใน fillable
    ];
    use HasFactory;
}
