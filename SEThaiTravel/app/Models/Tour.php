<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = 'tour';
    protected $primaryKey = 'id_tour'; // ระบุชื่อ primary key ให้ตรงกับใน DB
    public $incrementing = true; // ให้ Laravel รู้ว่า primary key เป็น auto increment
    protected $keyType = 'int'; // ประเภทของ primary key
    public $timestamps = false;
    protected $fillable = [
        'from_owner', 'owner_id', 'name', 'Release_date',
        'End_of_sale_date', 'start_tour_date', 'end_tour_date',
        'price', 'tour_capacity', 'contect', 'hotel', 'hotel_price',
        'description', 'travel_by', 'status', 'offer_id_offer', 'type_tour'
    ];
    use HasFactory;
}
