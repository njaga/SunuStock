<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'phone', 'email', 'orders_count', 'invoices_count'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Mettre à jour le compteur des commandes pour ce client.
     */
    public function refreshOrdersCount()
    {
        $this->orders_count = $this->orders()->count();
        $this->save();
    }

    /**
     * Mettre à jour le compteur des factures pour ce client.
     */
    public function refreshInvoicesCount()
    {
        $this->invoices_count = $this->invoices()->count();
        $this->save();
    }

    /**
     * Ajouter une commande au client et mettre à jour le compteur des commandes.
     *
     * @param Order $order
     */
    public function addOrder(Order $order)
    {
        $this->orders()->save($order);
        $this->refreshOrdersCount(); // Mettre à jour le compteur des commandes
    }

    /**
     * Ajouter une facture au client et mettre à jour le compteur des factures.
     *
     * @param Invoice $invoice
     */
    public function addInvoice(Invoice $invoice)
    {
        $this->invoices()->save($invoice);
        $this->refreshInvoicesCount(); // Mettre à jour le compteur des factures
    }

    /**
     * Supprimer une commande du client et mettre à jour le compteur des commandes.
     *
     * @param Order $order
     */
    public function removeOrder(Order $order)
    {
        $order->delete();
        $this->refreshOrdersCount(); // Mettre à jour le compteur des commandes
    }

    /**
     * Supprimer une facture du client et mettre à jour le compteur des factures.
     *
     * @param Invoice $invoice
     */
    public function removeInvoice(Invoice $invoice)
    {
        $invoice->delete();
        $this->refreshInvoicesCount(); // Mettre à jour le compteur des factures
    }
}
