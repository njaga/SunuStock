<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'unit_price', 'total_price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Assurez-vous que total_price est toujours calculé correctement
    protected static function booted()
    {
        static::saving(function ($detail) {
            $detail->total_price = $detail->quantity * $detail->unit_price;
        });
    }
}
