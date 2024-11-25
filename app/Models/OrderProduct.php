<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product'; // pivot table
    protected $fillable = ['order_id', 'product_id', 'quantity'];

    // relationship to Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
