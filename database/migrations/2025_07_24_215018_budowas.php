<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('budowas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_gracz');
            $table->integer('id_wioski');
            $table->integer('id_budynku');
            $table->integer('poziom');
            $table->integer('czas');
            $table->string('koszty')->nullable();
            $table->integer('zakonczona')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budowas');
    }
};
