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
        Schema::create('pocztas', function (Blueprint $table) {
            $table->id();
            $table->integer('od');
            $table->integer('do');
            $table->string('temat');
            $table->text('tresc');
            $table->timestamp('czytana')->nullable();;
            $table->integer('stan')->nullable();;
            $table->string('grupa')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('pocztas');
    }
};

