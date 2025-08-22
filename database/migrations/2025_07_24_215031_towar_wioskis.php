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
         Schema::create('towar_wioskis', function (Blueprint $table) {
            $table->integer('id_wioski');
            $table->integer('ludzie')->default(15);
            $table->integer('osadnicy');
            $table->integer('1')->default(1750);
            $table->integer('2')->default(900);
            $table->integer('3');
            $table->integer('4');
            $table->integer('5')->default(900);
            $table->integer('6');
            $table->integer('7');
            $table->integer('8');
            $table->integer('9')->default(500);
            $table->integer('10')->default(500);
            $table->integer('11')->default(700);
            $table->integer('12');
            $table->integer('13');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('towar_wioskis');
    }
};


