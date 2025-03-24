<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideList extends Model
{
    public $timestamps = false;
    protected $table = 'guide_list';
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
        'guide_license',
        'corp_list_account_id_account',
    ];
}
