<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'pos_order_detail';
    protected $primaryKey = 'order_detail_id';

    protected $fillable = [
        //'order_detail_id',
        'order_id',
        'book_id',
        'detail_price',
        'quantity',
    ];

    public function order()
    {
        return $this->hasMany(Order::class, 'order_id', 'order_id');
    }
}
