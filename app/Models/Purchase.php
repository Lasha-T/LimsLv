<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'purchase_price',
        'purchase_date',
    ];
    
    
    protected $casts = [
        'purchase_date' => 'datetime',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }   
}
