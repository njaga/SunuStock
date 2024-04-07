<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('invoice_items', function (Blueprint $table) {
        $table->decimal('unit_price', 8, 2)->default(0); // Ajoutez la colonne unit_price
    });
}

public function down()
{
    Schema::table('invoice_items', function (Blueprint $table) {
        $table->dropColumn('unit_price'); // Supprimez la colonne unit_price
    });
}

};
