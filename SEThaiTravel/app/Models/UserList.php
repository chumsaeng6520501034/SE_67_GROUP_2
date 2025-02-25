<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $table = 'user_list';
    protected $primaryKey="account_id_account";
    use HasFactory;
}
