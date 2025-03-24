<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id_booking'; // ระบุชื่อ primary key ให้ตรงกับใน DB
    public $incrementing = true; // ให้ Laravel รู้ว่า primary key เป็น auto increment
    protected $keyType = 'int'; // ประเภทของ primary key
    public $timestamps = false;
    protected $fillable = [
        'status',
    ];
    use HasFactory;
}
