<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // Les attributs que vous pouvez assigner massivement.
    protected $fillable = [
        'title',
        'description',
        'created_by', // exemple d'attribut supplémentaire, supposant un système avec des utilisateurs
    ];

    // Relations supplémentaires selon les besoins de votre application
    // ...
}
