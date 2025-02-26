<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorpList extends Model
{
    protected $table = 'corp_list';
    protected $primaryKey="account_id_account";
    use HasFactory;
}
