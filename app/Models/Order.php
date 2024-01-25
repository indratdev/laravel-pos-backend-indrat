<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'transaction_time',
        'total_price',
        'total_quantity',
        'total_item',
        // 'kasir_id',
        'payment_method',
        'customer_id',
        'amount_payment',
        'cashier_id',
        'is_sync',
        'cashier_name',
        'order_items'
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

}
