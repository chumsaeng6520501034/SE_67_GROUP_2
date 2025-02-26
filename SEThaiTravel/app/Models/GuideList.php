<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideList extends Model
{
    protected $table = 'guide_list';
    protected $primaryKey="account_id_account";
    use HasFactory;
}
