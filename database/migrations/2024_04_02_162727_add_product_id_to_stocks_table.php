<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id'); // Colonne pour stocker l'ID du produit
            $table->foreign('product_id')->references('id')->on('products'); // Clé étrangère liée à la table des produits
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['product_id']); // Supprimer la clé étrangère
            $table->dropColumn('product_id'); // Supprimer la colonne product_id
        });
    }
}


