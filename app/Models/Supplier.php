<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'address'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Mettre à jour le compteur de produits du fournisseur.
     */
    public function updateProductCount()
    {
        $productCount = Product::where('supplier_id', $this->id)->count();
        $this->update(['products_count' => $productCount]);
    }
}
