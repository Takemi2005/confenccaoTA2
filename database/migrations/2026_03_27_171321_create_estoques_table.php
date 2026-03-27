<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_estoques_table.php
public function up(): void
{
    Schema::create('estoques', function (Blueprint $table) {
        $table->id();
        $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
        $table->decimal('quantidade', 10, 2);
        $table->enum('tipo', ['entrada', 'saida']);
        $table->text('observacao')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};
