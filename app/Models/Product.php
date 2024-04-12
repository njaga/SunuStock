<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Stock;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'category_id', 
        'supplier_id',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Spécifier la clé étrangère
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id'); // Spécifier la clé étrangère
    }
}
