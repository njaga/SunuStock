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
        'total_amount', // Nouvelle colonne
        'products_count', // Nouvelle colonne
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($invoice) {
            // Mettre à jour le nombre de commandes du client associé
            $invoice->client->refreshOrdersCount();
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
}
