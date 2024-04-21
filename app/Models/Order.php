<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_date', 'supplier_id', 'order_number', 'total_price'];

    public function items()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function calculateTotalPrice()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->quantity * $item->unit_price;
        }
        $this->total_price = $total;
        $this->save();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id'); 
    }
}
