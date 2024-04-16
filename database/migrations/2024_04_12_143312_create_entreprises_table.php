<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->default('Default Company Name');
            $table->string('telephone')->default('1234567890');
            $table->text('adresse')->default('123 Default Address');
            $table->string('site_web')->default('http://www.defaultwebsite.com');
            $table->string('email')->default('info@defaultcompany.com');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entreprises');
    }
}
