<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'client_id',
        'total_amount',  // Assurez-vous que cette colonne est ajoutée à la base de données
        'products_count' // Assurez-vous que cette colonne est ajoutée à la base de données
    ];

    protected static function boot()
    {
        parent::boot();

        // Cette méthode est appelée à chaque fois qu'une facture est créée
        static::created(function ($invoice) {
            // Nous allons mettre à jour le compteur de produits pour le client associé, pas le nombre de commandes
            $invoice->refreshProductsCount();
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Mettre à jour le compteur de produits pour cette facture.
     */
    public function refreshProductsCount()
    {
        // Mise à jour du compteur de produits basé sur le nombre d'items de la facture
        $this->products_count = $this->items()->count();
        $this->save();
    }
}
