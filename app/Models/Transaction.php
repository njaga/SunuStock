<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Les attributs que vous pouvez assigner massivement.
    protected $fillable = [
        'amount',
        'transaction_date', // exemple d'attribut supplémentaire
        'type', // exemple d'attribut supplémentaire
        'description', // exemple d'attribut supplémentaire
    ];

    // Relations supplémentaires selon les besoins de votre application
    // ...
}
