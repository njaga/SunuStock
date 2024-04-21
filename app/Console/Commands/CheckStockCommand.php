<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Notifications\RestockAlert;

class CheckStockCommand extends Command
{
    protected $signature = 'stock:check';
    protected $description = 'Check stock levels and send restock alerts';

    public function handle()
    {
        // Vérifier le rôle de l'utilisateur connecté
        if (auth()->check() && (auth()->user()->role !== 1 && auth()->user()->role !== 'admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $restockThreshold = 10; // Seuil de réapprovisionnement

        // Récupérer tous les produits dont le stock est inférieur ou égal au seuil
        $products = Product::where('quantity', '<=', $restockThreshold)->get();

        foreach ($products as $product) {
            // Envoyer une notification d'alerte de réapprovisionnement à l'administrateur
            $admin = User::where('role', 'admin')->first();
            $admin->notify(new RestockAlert($product));
        }

        $this->info('Stock check completed.');
    }
}
