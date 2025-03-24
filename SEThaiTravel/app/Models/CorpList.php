<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorpList extends Model
{
    public $timestamps = false;
    protected $table = 'corp_list';
    protected $primaryKey="account_id_account";
    use HasFactory;
    protected $fillable = [
        'name',
        'name_owner',
        'phone_number',
        'nationality',
        'logo',
        'address',
        'country',
        'postcode',
        'corp_license',
        'owner_country_code',
        'dob',
    ];
}
