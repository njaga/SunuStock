<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    // Définir les attributs qui sont mass assignable
    protected $fillable = ['invoice_id', 'product_id', 'quantity', 'unit_price'];

    /**
     * Relation avec le modèle Invoice.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Relation avec le modèle Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
