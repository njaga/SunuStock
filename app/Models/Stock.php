<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    // Les attributs que vous pouvez assigner massivement.
    protected $fillable = [
        'product_id',
        'quantity',
        'minimum_quantity', // exemple d'attribut supplémentaire
    ];

    // Relation avec le modèle Product (si applicable)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
}
