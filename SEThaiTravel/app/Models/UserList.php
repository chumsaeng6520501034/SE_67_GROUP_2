<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    public $timestamps = false;
    protected $table = 'user_list';
    protected $primaryKey="account_id_account";
    use HasFactory;
    protected $fillable = [
        'name', // ✅ เพิ่มฟิลด์นี้เข้าไป
        'surname',
        'phonenumber',
        'fake_BAN',
        'photo',
        'address',
        'country',
        'postcode',
    ];
}
