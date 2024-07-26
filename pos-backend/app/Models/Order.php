<?php

namespace App\Models;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pos_order';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        //'order_id',
        'client_id',
        'total',
        'doc_type',
        'doc_number',
        'last_name',
        'payment_status'
        //'created_at'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }
}
