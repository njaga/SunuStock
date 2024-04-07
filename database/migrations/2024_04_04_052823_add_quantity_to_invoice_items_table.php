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
        $table->integer('quantity')->default(0); // Ajoutez la colonne quantity
    });
}

public function down()
{
    Schema::table('invoice_items', function (Blueprint $table) {
        $table->dropColumn('quantity'); // Supprimez la colonne quantity
    });
}

};
