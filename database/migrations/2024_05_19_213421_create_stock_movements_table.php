<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Assurez-vous que les contraintes de clé étrangère sont correctes
            $table->integer('quantity');
            $table->enum('type', ['in', 'out']);  // 'in' pour les entrées, 'out' pour les sorties
            $table->text('reason')->nullable();  // Optionnel : la raison du mouvement de stock
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
}

