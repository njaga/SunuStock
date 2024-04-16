<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = ['nom', 'telephone', 'adresse', 'site_web', 'email', 'logo'];

    protected $attributes = [
        'nom' => 'Vigilus Groupe SA',
        'telephone' => '+221338677732',
        'adresse' => 'VDN Sacré Coeur 3, Dakar - Sénégal',
        'site_web' => 'http://www.groupevigilus.com',
        'email' => 'showroom@groupevigilus.com'
    ];
}
