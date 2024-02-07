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
        'payment_method',
        'customer_id',
        'amount_payment',
        'amount_changes',
        'cashier_id',
        'is_sync',
        'cashier_name',
        'receipt_no',
        'status',
        'status_payment',
        'order_items',
        'queue_on',
        'queue_by',
        'processed_on',
        'processed_by',
        'completed_on',
        'completed_by',
        'canceled_on',
        'canceled_by',
        'deleted'
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
