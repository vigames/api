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
        Schema::create('budynki_wioskis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_wioski');
            $table->integer('budynek')->nullable();
            $table->integer('poziom')->nullable();
            $table->integer('produkcja')->nullable();
            $table->integer('level_produkcji')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budynki_wioskis');
    }
};

