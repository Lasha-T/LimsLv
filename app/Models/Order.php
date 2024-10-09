<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'status', 
        'total_amount',
        'shipping_status'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CANCELED = 'canceled';

    const SHIPPING_STATUS_PENDING = 'pending_shipment';
    const SHIPPING_STATUS_SHIPPED = 'shipped';
    const SHIPPING_STATUS_DELIVERED = 'delivered';

    // Relationship to User (One-to-Many)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Product (Many-to-Many through the pivot table)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
