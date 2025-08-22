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
        Schema::create('poziomy_graczas', function (Blueprint $table) {
            $table->id();
            $table->integer('gracz');
            $table->decimal('gospodarstwo', 4,2)->default(0.00);
            $table->decimal('ekonomia', 4,2)->default(0.00);
            $table->decimal('wojskowosc', 4,2)->default(0.00);
            $table->decimal('szpiegostwo', 4,2)->default(0.00);
            $table->decimal('wiedza', 4,2)->default(0.00);
            $table->decimal('walka', 4,2)->default(0.00);
            $table->decimal('magia', 4,2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('poziomy_graczas');
    }
};
