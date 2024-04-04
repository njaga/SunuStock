<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        // Ajoutez d'autres champs ici selon votre schéma de base de données
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
